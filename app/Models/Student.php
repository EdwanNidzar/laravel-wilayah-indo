<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $tableName = 'students'; 
    
    protected $fillable = [
        'name',
        'gender',
        'address',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
    ];
}
