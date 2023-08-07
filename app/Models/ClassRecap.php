<?php

namespace App\Models;

use App\Models\Staff\ClassInstructor;
use App\Models\Staff\CustomerService;
use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRecap extends Model
{
    use HasFormatRupiah;
    use HasFactory;

    protected $fillable = [
        'date_time',
        'class_name',
        'class_instructor_id',
        'member_total',
        'class_price',
        'cs_id'
    ];

    protected $hidden = [];

    public function classInstructor()
    {
        return $this->belongsTo(ClassInstructor::class, 'class_instructor_id', 'id');
    }

    public function customerService()
    {
        return $this->belongsTo(CustomerService::class, 'cs_id', 'id');
    }
}
