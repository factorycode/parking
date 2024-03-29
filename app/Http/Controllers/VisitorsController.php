<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\VisitorPass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class VisitorsController extends Controller
{

    public function index(Request $request)
    {

        $property_code = $request->query('property_code');

        $property = Property::where('property_code', $property_code)->first();

        if (!$property) {

            abort(404); // Si no se encuentra la propiedad, puedes mostrar una página de error 404

        }

        $address = $property->address;

        return view('visitors/addvisitors', compact('property_code', 'address'));

    }

    public function show()
    {
        $user = Auth::user(); // Obtén el usuario autenticado
    
        if ($user->hasRole('Company administrator')) {
            // Si el usuario tiene el rol 'Company Administrator', puede ver todos los detalles de las propiedades
            $properties = Property::select('properties.name as nombre_propiedad', 'properties.property_code',
                DB::raw('COUNT(visitorpasses.id) as pass_issued'),
                DB::raw('SUM(CASE WHEN visitorpasses.status = "Active" THEN 1 ELSE 0 END) as active_passes'),
                DB::raw('SUM(CASE WHEN visitorpasses.status = "Expired" THEN 1 ELSE 0 END) as expired_passes'),
                DB::raw('SUM(CASE WHEN visitorpasses.status = "Invalid" THEN 1 ELSE 0 END) as invalid_passes'))
                ->leftJoin('visitorpasses', 'properties.property_code', '=', 'visitorpasses.property_code')
                ->groupBy('properties.name', 'properties.property_code')
                ->get();
        } elseif ($user->hasRole('Property manager')) {
            // Si el usuario tiene el rol 'Property Manager', verifica si su property_code coincide con el de la propiedad
            $propertyCode = $user->property_code;
            $properties = Property::select('properties.name as nombre_propiedad', 'properties.property_code',
                DB::raw('COUNT(visitorpasses.id) as pass_issued'),
                DB::raw('SUM(CASE WHEN visitorpasses.status = "Active" THEN 1 ELSE 0 END) as active_passes'),
                DB::raw('SUM(CASE WHEN visitorpasses.status = "Expired" THEN 1 ELSE 0 END) as expired_passes'),
                DB::raw('SUM(CASE WHEN visitorpasses.status = "Invalid" THEN 1 ELSE 0 END) as invalid_passes'))
                ->where('properties.property_code', $propertyCode)
                ->leftJoin('visitorpasses', 'properties.property_code', '=', 'visitorpasses.property_code')
                ->groupBy('properties.name', 'properties.property_code')
                ->get();
        } else {
            // Otros casos o roles desconocidos
            abort(403, 'Acceso no autorizado');
        }
    
        // Devuelve la vista 'visitors.index' y pasa los detalles de las propiedades a la vista
        return view('visitors.index', ['properties' => $properties]);
    }
    

    public function registerVisitorPass(Request $request)
    {
        //dd($request);
        $validatedData = $request->validate([
            'property_code' => 'required',
            'visitor_name' => 'required|string',
            'visitor_phone' => 'required|string',
            'license_plate' => 'required|string',
            'year' => 'required|integer|max:' . date('Y'),
            'make' => 'required|string',
            'color' => 'required|string',
            'model' => 'required|string',
            'vehicle_type' => 'required|string',
            'valid_from' => [
                'required',
                'date_format:Y-m-d H:i', // Asegurándose de que la fecha sigue el formato específico
                function ($attribute, $value, $fail) {
                    try {
                        $validFrom = Carbon::createFromFormat('Y-m-d H:i', $value);
                        $now = Carbon::now();
    
                        if ($validFrom->isToday() && $validFrom->lt($now)) {
                            return $fail('The time must be later than the current time..');
                        }
                    } catch (\Exception $e) {
                        // En caso de que la fecha no se pueda parsear correctamente
                        return $fail('The date format is invalid.');
                    }
                },
            ],
            'user_id' => 'required|exists:users,id', // Asegura que el user_id exista en la tabla users
        ]);
        //dd($validatedData);

        // Generate a unique 5-digit vp_code
        $vpCode = $this->generateUniqueVpCode();
        // Los datos han sido validados, puedes continuar guardándolos en la base de datos
        $visitorPass = new VisitorPass();
        $visitorPass->vp_code = $vpCode;
        $visitorPass->property_code = $validatedData['property_code'];
        $visitorPass->user_id = $validatedData['user_id'];
        $visitorPass->visitor_name = $validatedData['visitor_name'];
        $visitorPass->visitor_phone = $validatedData['visitor_phone'];
        $visitorPass->license_plate = $validatedData['license_plate'];
        $visitorPass->year = $validatedData['year'];
        $visitorPass->make = $validatedData['make'];
        $visitorPass->color = $validatedData['color'];
        $visitorPass->model = $validatedData['model'];
        $visitorPass->vehicle_type = $validatedData['vehicle_type'];
        $visitorPass->valid_from = Carbon::parse($validatedData['valid_from']);

        // Check if the vehicle already has an active pass (with a valid date range)
        $existingActivePass = VisitorPass::where('license_plate', $visitorPass->license_plate)
            ->where('valid_from', '>=', now()) // Check if the pass is currently active
            ->first();

        if ($existingActivePass) {
// The vehicle already has an active pass
            return redirect()->back()->with('error', 'Vehicle already has an active pass.');
        }
      // dd($visitorPass);
        $visitorPass->save();

        // Fetch the latest registered visitor pass for display
        $latestVisitorPass = VisitorPass::latest()->first();

        return view('errorregister')->with([
            'successMessage' => 'Visitor pass registered successfully.',
            'latestVisitorPass' => $latestVisitorPass,
        ]);

    }

    private function generateUniqueVpCode()
    {
        $vpCode = mt_rand(10000, 99999); // Generate a random 5-digit number
        while (VisitorPass::where('vp_code', $vpCode)->exists()) {
            // If the code already exists, generate a new one
            $vpCode = mt_rand(10000, 99999);
        }
        return $vpCode;
    }

    public function listVisitors($property_code)
    {
        $property = Property::where('property_code', $property_code)->first();

        $visitors = VisitorPass::join('properties', 'visitorpasses.property_code', '=', 'properties.property_code')
            ->join('users', 'visitorpasses.user_id', '=', 'users.id')
            ->join('departments', 'users.id', '=', 'departments.user_id') // Unir la tabla departments
            ->where('visitorpasses.property_code', $property_code)
            ->select(
                'visitorpasses.id',
                'visitorpasses.valid_from',
                'visitorpasses.vp_code',
                'visitorpasses.license_plate',
                'visitorpasses.make',
                'visitorpasses.model',
                'visitorpasses.color',
                'visitorpasses.year',
                'visitorpasses.status',
                'visitorpasses.visitor_name',
                'users.phone as resident_phone',
                'visitorpasses.vehicle_type',
                'users.name as resident_name',
                'departments.apart_unit' // Agregar la columna apart_unit
            )
            ->get();

        return view('visitors.listvisitors', compact('property', 'visitors'));
    }

    public function addTemporary(Request $request)
    {

        $property_code = $request->route('property_code');

        $visitorPasses = DB::table('visitorpasses')

            ->join('properties', 'visitorpasses.property_code', '=', 'properties.property_code')

            ->where('visitorpasses.property_code', $property_code)

            ->select('visitorpasses.*', 'properties.address')

            ->get();

        //dd($visitorPasses); // Imprimir los datos en la consola para verificar

        return view('visitors/addtemporary', compact('property_code', 'visitorPasses'));

    }

    public function storeTemporary(Request $request)
    {

        $property_code = $request->input('property_code');

        // Validar los datos del formulario si es necesario

        $validatedData = $request->validate([

            'visitor_name' => 'required',

            'visitor_phone' => 'required',

            'license_plate' => 'required',

            'year' => 'required',

            'make' => 'required',

            'model' => 'required',

            'color' => 'required',

            'vehicle_type' => 'required',

            'resident_name' => 'required',

            'unit_number' => 'required',

            'resident_phone' => 'required',

            'valid_from_date' => 'required|date',

            'valid_from_time' => 'required',

        ]);

        // Crear un nuevo objeto VisitorPass y guardar los datos

        $visitorPass = new VisitorPass();

        $visitorPass->property_code = $property_code;

        $visitorPass->visitor_name = $request->input('visitor_name');

        $visitorPass->visitor_phone = $request->input('visitor_phone');

        $visitorPass->license_plate = $request->input('license_plate');

        $visitorPass->year = $request->input('year');

        $visitorPass->make = $request->input('make');

        $visitorPass->model = $request->input('model');

        $visitorPass->color = $request->input('color');

        $visitorPass->vehicle_type = $request->input('vehicle_type');

        $visitorPass->resident_name = $request->input('resident_name');

        $visitorPass->unit_number = $request->input('unit_number');

        $visitorPass->resident_phone = $request->input('resident_phone');

        $visitorPass->valid_from = $request->input('valid_from_date') . ' ' . $request->input('valid_from_time');

        $visitorPass->save();

        // Redireccionar o mostrar un mensaje de éxito si es necesario

        return redirect()->route('list.visitors', ['property_code' => $property_code])->with('successMessage', 'Vehicle saved successfully.');

    }

    public function excel_visitorspases()
    {

        // Create new Spreadsheet object

        // Crea una instancia de Spreadsheet

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $datos = VisitorPass::join('properties', 'visitorpasses.property_code', '=', 'properties.property_code')

            ->select('properties.property_code', 'properties.name')

            ->distinct()

            ->get();

        $expiredCount = VisitorPass::where('status', 'expired')->count();

        $activeCount = VisitorPass::where('status', 'active')->count();

        $invalidCount = VisitorPass::where('status', 'invalid')->count();

        // Obtener el property_code

        $propertyCode = request()->get('property_code');

        $spreadsheet->setActiveSheetIndex(0)

            ->setCellValue('A1', 'Property')

            ->setCellValue('B1', 'Pass Issued (total)')

            ->setCellValue('C1', 'Active pass')

            ->setCellValue('D1', 'Expired pass')

            ->setCellValue('E1', 'Invalid Pass');

        $i = 2;

        foreach ($datos as $dato) {

            $spreadsheet->getActiveSheet()

                ->setCellValue('A' . $i, $dato->name)

                ->setCellValue('B' . $i, $dato->count())

                ->setCellValue('C' . $i, $activeCount)

                ->setCellValue('D' . $i, $expiredCount)

                ->setCellValue('E' . $i, $invalidCount);

            $i++;

        }

        // Crea el archivo Excel

        $writer = new Xlsx($spreadsheet);

        $filename = 'visitors_passes.xlsx';

        $writer->save($filename);

        // Descargar el archivo

        $response = response()->download($filename)->deleteFileAfterSend();

        // Redireccionar a la página anterior después de la descarga

        $response->headers->set('Refresh', '0;url=' . url()->previous());

        return $response;

    }

    public function excel_visitorforid($property_code)
    {

        // Create new Spreadsheet object

        // Crea una instancia de Spreadsheet

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $datos = VisitorPass::join('properties', 'visitorpasses.property_code', '=', 'properties.property_code')

            ->where('visitorpasses.property_code', $property_code)

            ->select('visitorpasses.valid_from', 'visitorpasses.license_plate', 'visitorpasses.make', 'visitorpasses.model', 'visitorpasses.color', 'visitorpasses.year', 'visitorpasses.unit_number', 'visitorpasses.status', 'visitorpasses.visitor_name', 'visitorpasses.resident_phone', 'visitorpasses.vehicle_type', 'visitorpasses.resident_name')

            ->get();

        $spreadsheet->setActiveSheetIndex(0)

            ->setCellValue('A1', 'Visitors name')

            ->setCellValue('B1', 'Valid from')

            ->setCellValue('C1', 'License plate')

            ->setCellValue('D1', 'Make')

            ->setCellValue('E1', 'Model')

            ->setCellValue('F1', 'Color')

            ->setCellValue('G1', 'Year')

            ->setCellValue('H1', 'Unit Number')

            ->setCellValue('I1', 'Phone')

            ->setCellValue('J1', 'Type')

            ->setCellValue('K1', 'Status');

        $i = 2;

        foreach ($datos as $dato) {

            $spreadsheet->getActiveSheet()

                ->setCellValue('A' . $i, $dato->visitor_name)

                ->setCellValue('B' . $i, $dato->valid_from)

                ->setCellValue('C' . $i, $dato->license_plate)

                ->setCellValue('D' . $i, $dato->make)

                ->setCellValue('E' . $i, $dato->model)

                ->setCellValue('F' . $i, $dato->color)

                ->setCellValue('G' . $i, $dato->year)

                ->setCellValue('H' . $i, $dato->unit_number)

                ->setCellValue('I' . $i, $dato->resident_phone)

                ->setCellValue('J' . $i, $dato->vehicle_type)

                ->setCellValue('K' . $i, $dato->status);

            $i++;

        }

        // Crea el archivo Excel

        $writer = new Xlsx($spreadsheet);

        $filename = 'visitors lisforid.xlsx';

        $writer->save($filename);

        // Descargar el archivo

        $response = response()->download($filename)->deleteFileAfterSend();

        // Redireccionar a la página anterior después de la descarga

        $response->headers->set('Refresh', '0;url=' . url()->previous());

        return $response;

    }

    public function delete($id)
    {
        // Buscar el visitante por su ID
        $visitor = VisitorPass::find($id);

        if (!$visitor) {
            return redirect()->back()->with('error', 'Visitor not found.');
        }

        // Obtener el property_code asociado al visitor por medio del id
        $propertyCode = $visitor->property_code;

        // Realizar las acciones de eliminación aquí
        $visitor->delete();

        // Redirigir a la vista list.visitors con el property_code como parámetro
        return redirect()->route('list.visitors', ['property_code' => $propertyCode])
            ->with('success_message', 'Visitor deleted successfully.');
    }

}
