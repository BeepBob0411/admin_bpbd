<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'disasterType',
        'imageUrl', 
        'timestamp',
    ];

    protected $casts = [
        'location' => 'array', // Cast location as array
        'timestamp' => 'datetime',
    ];
}
