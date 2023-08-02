<?php

namespace App\Models\Trainer;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerPackage extends Model
{
    use HasFormatRupiah;
    use HasFactory;

    protected $fillable = [
        'package_name',
        'package_type_id',
        'number_of_session',
        'expired_session',
        'package_price',
        'admin_price',
        'description',
    ];

    protected $hidden = [];

    public function trainerPackageType()
    {
        return $this->belongsTo(TrainerPackageType::class, 'package_type_id', 'id');
    }
}
