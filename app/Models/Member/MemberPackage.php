<?php

namespace App\Models\Member;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPackage extends Model
{
    use HasFormatRupiah;
    use HasFactory;

    protected $fillable = [
        'package_name',
        'days',
        'expired_session',
        'package_type_id',
        'package_category_id',
        'package_price',
        'admin_price',
        'joining_price',
        'description',
    ];

    protected $hidden = [];

    public function memberPackageType()
    {
        return $this->belongsTo(MemberPackageType::class, 'package_type_id', 'id');
    }

    public function memberPackageCategories()
    {
        return $this->belongsTo(MemberPackageCategory::class, 'package_category_id', 'id');
    }
}
