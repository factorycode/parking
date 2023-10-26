<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSuspend extends Model
{
    use HasFactory;
     // Nombre de la tabla asociada al modelo
     protected $table = 'emails_suspend';

     // Los campos que se pueden llenar de forma masiva
     protected $fillable = [
         'email_content',
         'property_code',
     ];
}
