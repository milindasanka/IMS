<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $table = 'classes';
    protected $fillable = [
        'fee',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(StudentClass::class, 'class_id');
    }

    public function payments()
    {
        return $this->hasMany(Payemnt::class, 'class_id');
    }
}
