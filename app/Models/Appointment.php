<?php

namespace App\Models;

use App\Models\Staff\CustomerService;
use App\Models\Staff\FitnessConsultant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_time',
        'full_name',
        'appointment_date',
        'appointment_code',
        'phone_number',
        'email',
        'source',
        'description',
        'status',
        'fc_id',
        'cs_id'
    ];

    protected $hidden = [];

    public function fitnessConsultants()
    {
        return $this->belongsTo(FitnessConsultant::class, 'fc_id', 'id');
    }
    public function customerServices()
    {
        return $this->belongsTo(CustomerService::class, 'cs_id', 'id');
    }
}
