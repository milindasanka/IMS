<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tute extends Model
{
    use HasFactory;
    protected $table='tutes';
    protected $fillable = [
        'class_id',
        'name',
        'file',
    ];
}
