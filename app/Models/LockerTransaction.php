<?php

namespace App\Models;

use App\Models\Staff\CustomerService;
use App\Models\Member\Member;
use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockerTransaction extends Model
{
    use HasFormatRupiah;
    use HasFactory;

    protected $fillable = [
        'member_id',
        'active_period',
        // 'member_code',
        'locker_package',
        // 'package_price',
        'description',
        'status',
        'cs_name'
    ];

    protected $hidden = [];

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function lockerPackage()
    {
        return $this->belongsTo(LockerPackage::class, 'locker_package', 'id');
    }

    public function cs()
    {
        return $this->belongsTo(CustomerService::class, 'cs_name', 'id');
    }
}
