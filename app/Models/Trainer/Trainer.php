<?php

namespace App\Models\Trainer;

use App\Models\Member\Member;
use App\Models\MethodPayment;
use App\Models\Staff\FitnessConsultant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type_id',
        'member_id',
        'trainer_name',
        'trainer_package_id',
        'method_payment_id',
        'fc_id',
        'description',
        'photos'
    ];

    protected $hidden = [];

    public function trainerTransactionType()
    {
        return $this->belongsTo(TrainerTransactionType::class, 'transaction_type_id', 'id');
    }

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function trainerPackage()
    {
        return $this->belongsTo(TrainerPackage::class, 'trainer_package_id', 'id');
    }

    public function methodPayment()
    {
        return $this->belongsTo(MethodPayment::class, 'method_payment_id', 'id');
    }

    public function fc()
    {
        return $this->belongsTo(FitnessConsultant::class, 'fc_id', 'id');
    }
}