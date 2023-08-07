<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferPackage extends Model
{
    use HasFormatRupiah;
    use HasFactory;

    protected $fillable = [
        'package_name',
        'package_type',
        'package_price',
        'description',
        'staff_name'
    ];

    protected $hidden = [];
}
