<?php

namespace App\Models\Member;

// use Alfa6661\AutoNumber\AutoNumberTrait;
use App\Models\MethodPayment;
use App\Models\Staff\FitnessConsultant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'member_package_id',
        'package_price',
        'admin_price',
        'start_date',
        'days',
        'method_payment_id',
        'refferal_id',
        'description',
        'user_id',
    ];

    protected $hidden = [];

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function memberPackage()
    {
        return $this->belongsTo(MemberPackage::class, 'member_package_id', 'id');
    }

    public function methodPayment()
    {
        return $this->belongsTo(MethodPayment::class, 'method_payment_id', 'id');
    }

    public function fitnessConsultant()
    {
        return $this->belongsTo(FitnessConsultant::class, 'fc_id', 'id');
    }

    public function referralNameFitnessConsultant()
    {
        return $this->belongsTo(FitnessConsultant::class, 'refferal_id', 'id');
    }

    public function referralNameMember()
    {
        return $this->belongsTo(Member::class, 'refferal_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function referralName()
    {
        if ($this->referralNameFitnessConsultant) {
            return $this->referralNameFitnessConsultant;
        } else {
            return $this->referralNameMember;
        }
    }

    public function getReferralNameAttribute()
    {
        if ($this->referralNameFitnessConsultant) {
            return $this->referralNameFitnessConsultant;
        } elseif ($this->referralNameMember) {
            return $this->referralNameMember;
        } else {
            return null; // or any other default value
        }
    }

    public function memberRegistrationCheckIn()
    {
        return $this->hasMany(CheckInMember::class);
    }
}
