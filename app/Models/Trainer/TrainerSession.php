<?php

namespace App\Models\Trainer;

use App\Models\Member\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerSession extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'active_period',
        'member_id',
        'trainer_id',
        'trainer_package_id',
        'session_total',
        'remaining_session',
        'status',
    ];

    protected $hidden = [];

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function trainers()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'id');
    }

    public function trainerPackages()
    {
        return $this->belongsTo(TrainerPackage::class, 'trainer_package_id', 'id');
    }
}
