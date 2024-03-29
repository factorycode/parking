<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\PermitSetting;
use App\Models\Property;
use App\Models\PropertyLanguageSetting;
use App\Models\PropertySetting;
use App\Models\Registration;
use App\Models\visitorSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtén el usuario autenticado

        if ($user->hasRole('Company administrator')) {
            // Si el usuario tiene el rol 'Company Administrator', puede ver todas las propiedades
            $properties = Property::all();
        } elseif ($user->hasRole('Property manager')) {
            // Si el usuario tiene el rol 'Property Manager', obtén su property_code
            $propertyCode = $user->property_code;

            // Luego, puedes usar este property_code para filtrar la consulta de las propiedades
            $properties = Property::where('property_code', $propertyCode)->get();
        } else {
            // Otros casos o roles desconocidos
            abort(403, 'Acceso no autorizado');
        }

        // Devuelve la vista 'settingss.index' y pasa los datos de los registros como variable "properties"
        return view('settingss.index', compact('properties'));
    }

    public function language(Request $request)
    {
        $propertySetting = PropertySetting::where('property_id', $request->property)->first();

        return response()->json([
            'success' => true,
            'propertySetting' => $propertySetting,
        ], 200);

    }

    public function store(Request $request)
    {
        $settingLanguage = PropertySetting::where('property_id', $request->property_id)->first();
        $settingLanguage = $settingLanguage ? $settingLanguage->update($request->except(['_token'])) : PropertySetting::create($request->except(['_token']));
        return $settingLanguage ?
        response()->json([
            'success' => true,
            'message' => 'language configured successfully',
        ], 200)
        : response()->json([
            'success' => false,
            'message' => 'language not set, try again',
        ], 200);
    }

    public function permit($property)
{
    $setting = PropertySetting::where('property_id', $property)->first();
    $defaultValues = [];

    if (!$setting) {
        // Set default values here
        $language = PropertyLanguageSetting::first()->toArray();
        unset($language['id']);
        unset($language['created_at']);
        unset($language['updated_at']);

        $defaultValues = array_merge($language, [
            'property_id' => $property,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PropertySetting::insert($defaultValues);
        $setting = true;
    }

    // Retrieve values from app_settings if they exist
    $appSettings = AppSetting::where('property_code', $property)->first();

    if ($appSettings) {
        $defaultValues = array_merge($defaultValues, $appSettings->toArray());
    }

    // Define your default values for the form fields here
    $defaultFormValues = [
        'vehicles_per_apartment' => 3,
        'tenants_change_info' => 'YES',
        'notify_on_tenants_info' => 'YES',
        'maximum_of_changes_allowed' => 3,
        'reserved_spot_allow' => 'YES',
        'reserved_spot_per_apartment' => 3, 
    ];

    // Merge the default form values with the existing values
    $formValues = array_merge($defaultFormValues, $defaultValues);

    return view('settingss/permit', ['property' => Property::find($property), 'setting' => $setting, 'formValues' => $formValues]);
}


    public function permit_type($property)
    {
        $types = PermitSetting::types();
        return view('settingss/permit_type', ['property' => Property::find($property), 'types' => $types]);
    }

    public function visitor($property)
    {
        return view('settingss/visitor', ['property' => Property::find($property)]);
    }

    public function visitorSettingStore(Request $request)
    {
        if (isset($request->type) && $request->type) {
            if ($request->type == 'form') {
                $setting = visitorSetting::where('property_id', $request->property_id)->where('type', 'form')->get();
                $view_form = visitorSetting::where('property_id', $request->property_id)
                    ->where('type', 'form')
                    ->where('name', 'not like', '%required%')
                    ->where('name', 'not like', '%validation%')
                    ->get();
            }
            if ($request->type == 'setting') {
                $setting = visitorSetting::where('property_id', $request->property_id)->where('type', 'setting')->get();
            }
            return $setting ?
            response()->json([
                'success' => true,
                'form' => $setting,
                'view_form' => $view_form ?? null,
                'message' => $request->type,
            ], 200)
            : response()->json([
                'success' => false,
                'form' => false,
                'view_form' => false,
                'message' => 'configured error, try again',
            ], 200);
        }
        if ($request->action == 'form') {
            $fields = [
                "visitor_name",
                //"visitor_email",
                "visitor_phone",
                //"visitor_language",
                //"vin",
                "license_plate",
                "year",
                "make",
                "model",
                "color",
                "vehicle_type",
                //"resident_name",
                //"resident_unit_number",
                //"resident_email",
                //"resident_phone",
                //"resident_registration",
                "valid_from",
                "required_visitor_name",
                //"required_visitor_email",
                "required_visitor_phone",
                //"required_visitor_language",
                //"required_vin",
                "required_license_plate",
                "required_year",
                "required_make",
                "required_model",
                "required_color",
                "required_vehicle_type",
                //"required_resident_name",
                //"required_resident_unit_number",
                //"required_resident_email",
                //"required_resident_phone",
                //"required_resident_registration",
                "required_valid_from",
                //"validation_resident_name",
                //"validation_resident_unit_number",
                //"validation_resident_email",
                //"validation_resident_phone",
                //"validation_resident_registration"
            ];
            $data = [];
            foreach ($fields as $key => $field) {
                array_push($data, [
                    'name' => $field,
                    'valor' => key_exists($field, $request->all()),
                    'type' => 'form',
                    'property_id' => $request->property_id,
                ]);
            }
            $setting = visitorSetting::where('property_id', $request->property_id)->where('type', 'form')->count();
            if ($setting > 0) {
                visitorSetting::where('property_id', $request->property_id)->where('type', 'form')->delete();
                $setting = visitorSetting::insert($data);
            } else {
                $setting = visitorSetting::insert($data);
            }
        }
        if ($request->action == 'setting') {
            $fields = [
                "total",
                "hours",
                "limit",
                "days",
            ];

            $data = [];
            foreach ($fields as $key => $field) {
                array_push($data, [
                    'name' => $field,
                    'valor' => key_exists($field, $request->all()) ? $request->$field : null,
                    'type' => 'setting',
                    'property_id' => $request->property_id,
                ]);
            }

            $setting = visitorSetting::where('property_id', $request->property_id)->where('type', 'setting')->count();
            if ($setting > 0) {
                visitorSetting::where('property_id', $request->property_id)->where('type', 'setting')->delete();
                $setting = visitorSetting::insert($data);
            } else {
                $setting = visitorSetting::insert($data);
            }
        }

        return $setting ?
        response()->json([
            'success' => true,
            'form' => $setting,
            'message' => 'configured successfully',
        ], 200)
        : response()->json([
            'success' => false,
            'form' => false,
            'message' => 'configured not set, try again',
        ], 200);
    }

    public function registrationSettingStore(Request $request)
    {
        if (isset($request->type) && $request->type) {
            if ($request->type == 'form') {
                $setting = Registration::where('property_id', $request->property_id)->where('type', 'form')->get();
                $view_form = Registration::where('property_id', $request->property_id)
                    ->where('type', 'form')
                    ->where('name', 'not like', '%required%')
                    ->where('name', 'not like', '%validation%')
                    ->get();
            }
            return $setting ?
            response()->json([
                'success' => true,
                'form' => $setting,
                'view_form' => $view_form ?? null,
                'message' => $request->type,
            ], 200)
            : response()->json([
                'success' => false,
                'form' => false,
                'view_form' => false,
                'message' => 'configured error, try again',
            ], 200);
        }
        $fields = [
            //"pre_name",
            //"pre_email",
            //"pre_phone",
            //"pre_unit",
            //"pre_language",
            "pre_license_plate",
            "pre_vin",
            "pre_make",
            "pre_model",
            "pre_year",
            "pre_color",
            "pre_vehicle_type",
            //"required_pre_name",
            //"required_pre_email",
            //"required_pre_phone",
            //"required_pre_unit",
            //"required_pre_language",
            "required_pre_license_plate",
            "required_pre_vin",
            "required_pre_make",
            "required_pre_model",
            "required_pre_year",
            "required_pre_color",
            "required_pre_vehicle_type",
            "validation_pre_license_plate",
        ];

        $data = [];
        foreach ($fields as $key => $field) {
            array_push($data, [
                'name' => $field,
                'valor' => key_exists($field, $request->all()),
                'type' => 'form',
                'property_id' => $request->property_id,
            ]);
        }
        $setting = Registration::where('property_id', $request->property_id)->where('type', 'form')->count();
        if ($setting > 0) {
            Registration::where('property_id', $request->property_id)->where('type', 'form')->delete();
            $setting = Registration::insert($data);
        } else {
            $setting = Registration::insert($data);
        }

        return $setting ?
        response()->json([
            'success' => true,
            'form' => $setting,
            'message' => 'configured successfully',
        ], 200)
        : response()->json([
            'success' => false,
            'form' => false,
            'message' => 'configured not set, try again',
        ], 200);
    }

    public function permitTypeSettingStore(Request $request)
    {
        if (isset($request->type) && $request->type) {
            if ($request->type == 'get') {
                $setting = PermitSetting::where('property_id', $request->property_id)->first();
                if ($setting) {
                    $data = [
                        [
                            "name" => 'resident',
                            "valor" => $setting->resident == 1 ? true : false,
                        ],
                        [
                            "name" => 'visitor',
                            "valor" => $setting->visitor == 1 ? true : false,
                        ],
                        [
                            "name" => 'sub_contractor',
                            "valor" => $setting->sub_contractor == 1 ? true : false,
                        ],
                        [
                            "name" => 'carport',
                            "valor" => $setting->carport == 1 ? true : false,
                        ],
                        [
                            "name" => 'temporary',
                            "valor" => $setting->temporary == 1 ? true : false,
                        ],
                        [
                            "name" => 'reserved',
                            "valor" => $setting->reserved == 1 ? true : false,
                        ],
                        [
                            "name" => 'vip',
                            "valor" => $setting->vip == 1 ? true : false,
                        ],
                        [
                            "name" => 'contractor',
                            "valor" => $setting->contractor == 1 ? true : false,
                        ],
                        [
                            "name" => 'employee',
                            "valor" => $setting->employee == 1 ? true : false,
                        ],
                    ];
                }
            }
            return $setting ?
            response()->json([
                'success' => true,
                'form' => $data ?? null,
                'types' => PermitSetting::types(),
                'message' => $request->type,
            ], 200)
            : response()->json([
                'success' => false,
                'form' => false,
                'types' => false,
                'message' => 'configured error, try again',
            ], 200);
        }
        //dd($request->all());
        $data = [
            "resident" => $request->resident == 'on' ? true : false,
            "visitor" => $request->visitor == 'on' ? true : false,
            "sub_contractor" => $request->sub_contractor == 'on' ? true : false,
            "carport" => $request->carport == 'on' ? true : false,
            "temporary" => $request->temporary == 'on' ? true : false,
            "reserved" => $request->reserved == 'on' ? true : false,
            "vip" => $request->vip == 'on' ? true : false,
            "contractor" => $request->contractor == 'on' ? true : false,
            "employee" => $request->employee == 'on' ? true : false,
            "property_id" => $request->property_id,
        ];

        $setting = PermitSetting::where('property_id', $request->property_id)->count();
        if ($setting > 0) {
            $setting = PermitSetting::where("property_id", $request->property_id)->update($data);
        } else {
            $setting = PermitSetting::insert($data);
        }
        return $setting ?
        response()->json([
            'success' => true,
            'form' => $setting,
            'message' => 'configured permit types successfully',
        ], 200)
        : response()->json([
            'success' => false,
            'form' => false,
            'message' => 'configured permit types not set, try again',
        ], 200);
    }

    public function permitMarginSettingStore(Request $request)
    {
        $settingLanguage = PropertySetting::where('property_id', $request->property_id)->first();
        $settingLanguage = $settingLanguage ? $settingLanguage->update($request->except(['_token'])) : false;
        return $settingLanguage ?
        response()->json([
            'success' => true,
            'message' => 'Margin configured successfully',
        ], 200)
        : response()->json([
            'success' => false,
            'message' => 'Margin not set, try again',
        ], 200);
    }

    public function permitPrintSettingStore(Request $request)
    {
        $request->merge(['name' => $request->has('name') ? true : false]);
        $request->merge(['type' => $request->has('type') ? true : false]);
        $request->merge(['space' => $request->has('space') ? true : false]);
        $request->merge(['license' => $request->has('license') ? true : false]);
        $request->merge(['number' => $request->has('number') ? true : false]);
        $request->merge(['start_date' => $request->has('start_date') ? true : false]);
        $request->merge(['end_date' => $request->has('end_date') ? true : false]);
        $request->merge(['logo' => $request->has('logo') ? true : false]);
        $request->merge(['nickname' => $request->has('nick') ? true : false]);

        $settingLanguage = PropertySetting::where('property_id', $request->property_id)->first();
        $settingLanguage = $settingLanguage ? $settingLanguage->update($request->except(['_token'])) : false;
        return $settingLanguage ?
        response()->json([
            'success' => true,
            'message' => 'Print configured successfully',
        ], 200)
        : response()->json([
            'success' => false,
            'message' => 'Print not set, try again',
        ], 200);
    }

    public function registration($property)
    {
        return view('settingss/registration', ['property' => Property::find($property)]);
    }

    public function residentstore(Request $request)
    {
        //dd($request);
        // Valida y guarda los datos del formulario en la base de datos
        $validatedData = $request->validate([
            'property_code' => 'required', // Asegúrate de tener un campo property_code en tu formulario
            'vehicles_per_apartment' => 'nullable|numeric',
            'tenants_change_info' => 'nullable|in:YES,NO',
            'notify_on_tenants_info' => 'nullable|in:YES,NO',
            'maximum_of_changes_allowed' => 'nullable|numeric',
            'reserved_spot_allow' => 'nullable|in:YES,NO',
            'reserved_spot_per_apartment' => 'nullable|numeric',
        ]);

        // Busca o crea una configuración existente basada en property_code
        AppSetting::updateOrCreate(['property_code' => $validatedData['property_code']], $validatedData);

        // Redirige a la ruta deseada después de guardar los datos
        return redirect()->back()->with('success', 'The data has been saved successfully.');

    }

}
