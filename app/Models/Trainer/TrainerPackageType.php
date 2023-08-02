<?php

namespace App\Models\Trainer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerPackageType extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_type_name'
    ];

    protected $hidden = [];
}
