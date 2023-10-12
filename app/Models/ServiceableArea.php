<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceableArea extends Model
{
    use HasFactory;
    protected $table = 'serviceable_area';
    protected $fillable = [
        'boundary_coordinates',
    ];
}