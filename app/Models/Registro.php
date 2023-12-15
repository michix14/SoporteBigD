<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Registro extends Model
{
    use HasFactory;
    protected $table = 'registro';
    protected $fillable = ['fecha_hora', 'mensaje_enviado'];
}
