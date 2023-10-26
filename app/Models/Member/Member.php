<?php

namespace App\Models\Member;

// use Alfa6661\AutoNumber\AutoNumberTrait;
use App\Models\SourceCode;
use App\Models\MethodPayment;
use App\Models\Refferal;
use App\Models\Sold;
use App\Models\Staff\FitnessConsultant;
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
        'start_date',
        'expired_date',
        'durationInDays',
        'method_payment_id',
        'fc_id',
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

    public function fitnessConsultant()
    {
        return $this->belongsTo(FitnessConsultant::class, 'fc_id', 'id');
    }

    // public function referralName()
    // {
    //     return $this->belongsTo(Member::class, 'refferal_id', 'id');
    // }

    public function referralNameFitnessConsultant()
    {
        return $this->belongsTo(FitnessConsultant::class, 'refferal_id', 'id');
        // return $this->belongsTo('App\Models\Staff\FitnessConsultant', 'refferal_id', 'id');
        // return $this->belongsTo('App\Models\Member\Member', 'refferal_id', 'id');
    }

    public function referralNameMember()
    {
        return $this->belongsTo(Member::class, 'refferal_id', 'id');
    }

    // public function referralName()
    // {
    //     // return $this->referralNameMember()->referralNameFitnessConsultant();
    //     // return $this->referralNameMember();
    //     // return $this->referralNameFitnessConsultant()->orWhere($this->referralNameMember());
    //     // if ($this->referralNameFitnessConsultant()) {
    //     //     return $this->belongsTo(FitnessConsultant::class, 'refferal_id', 'id');
    //     // } elseif ($this->referralNameMember()) {
    //     //     return $this->belongsTo(Member::class, 'refferal_id', 'id');
    //     // }
    //     return $this->referralNameMember->orWhere($this->referralNameFitnessConsultant);
    // }

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
}
