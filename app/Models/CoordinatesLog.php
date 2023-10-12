<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoordinatesLog extends Model
{
    use HasFactory;
    protected $table = "coordinates_log";

    protected $fillable = [
        'coordinates',
        'is_serviceable',
    ];
}