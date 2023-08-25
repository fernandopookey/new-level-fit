<?php

namespace App\Models\Member;

// use Alfa6661\AutoNumber\AutoNumberTrait;
use App\Models\SourceCode;
use App\Models\MethodPayment;
use App\Models\Refferal;
use App\Models\Sold;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'gender',
        'member_code',
        'phone_number',
        'source_code_id',
        'member_package_id',
        'expired_date',
        'method_payment_id',
        'sold_by_id',
        'refferal_id',
        'description',
        'status',
        'photos'
    ];

    protected $hidden = [];

    public function sourceCode()
    {
        return $this->belongsTo(SourceCode::class, 'source_code_id', 'id');
    }

    public function memberPackage()
    {
        return $this->belongsTo(MemberPackage::class, 'member_package_id', 'id');
    }

    public function methodPayment()
    {
        return $this->belongsTo(MethodPayment::class, 'method_payment_id', 'id');
    }

    public function soldBy()
    {
        return $this->belongsTo(Sold::class, 'sold_by_id', 'id');
    }

    public function refferalName()
    {
        return $this->belongsTo(Refferal::class, 'refferal_id', 'id');
    }
}
