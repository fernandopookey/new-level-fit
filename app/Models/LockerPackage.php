<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockerPackage extends Model
{
    use HasFormatRupiah;
    use HasFactory;

    protected $fillable = [
        'package_name',
        'number_of_days',
        'package_price',
        'description'
    ];

    protected $hidden = [];
}
