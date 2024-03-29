<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

// Asegúrate de importar el modelo Department

class TermsAndConditionsController extends Controller
{
    public function openTermsAndConditions(Request $request, $token, $language)
    {
       // dd($request);
        $user = User::whereHas('department', function ($query) use ($token) {
            $query->where('agreement_token', $token);
        })->first();
    
        if ($user) {
            // Check if terms have already been accepted
            $department = Department::where('user_id', $user->id)->first();
            if ($department && $department->terms_agreement_status === 'accepted') {
                return view('sweet_alert', ['message' => 'The terms have already been accepted.']);
            }
            
            // If terms have not been accepted, update the status to 'opened'
            if ($department) {
                $department->terms_agreement_status = 'opened';
                $department->save();
            }
    
            // Load the terms and conditions view based on the selected language
            if ($language === 'english') {
                return view('terms_and_conditions_english', compact('user'));
            } elseif ($language === 'spanish') {
                return view('terms_and_conditions_spanish', compact('user'));
            }
        } else {
            // Handle the case when the token is not valid
            return redirect()->route('error-route');
        }
    }
    

    public function acceptTermsAndConditions(Request $request, $token)
    {
        $user = User::whereHas('department', function ($query) use ($token) {
            $query->where('agreement_token', $token);
        })->first();

        if ($user) {
            // Actualiza el estatus en el registro de departments asociado al usuario
            $department = Department::where('user_id', $user->id)->first();
            if ($department && $department->terms_agreement_status === 'opened') {
                $department->terms_agreement_status = 'accepted'; // Cambia a 'accepted'
                
                // Guarda la fecha y hora de aceptación en el campo date_status
                $department->date_status = now(); // Esto utilizará la fecha y hora actual
                
                $department->save();
        
                // Aquí puedes redirigir a donde desees después de aceptar los términos
                return redirect()->route('login');
            
        }
        
        }

        // Maneja el caso cuando el token no es válido
        return redirect()->route('otra-ruta-de-error');
    }
}
