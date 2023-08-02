<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'booking_date',
        'booking_code',
        'phone_number',
        'studio_name',
        'package_id',
        'role',
        'staff_name',
        'payment_status'
    ];

    protected $hidden = [];

    public function studioPackage()
    {
        return $this->belongsTo(StudioPackage::class, 'package_id', 'id');
    }
}
