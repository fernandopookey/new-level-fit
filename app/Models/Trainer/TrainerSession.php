<?php

namespace App\Models\Trainer;

use App\Models\Member\Member;
use App\Models\Staff\PersonalTrainer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerSession extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'trainer_id',
        'start_date',
        'trainer_package_id',
        'user_id',
        'package_price',
        'admin_price',
        'description'
    ];

    protected $hidden = [];

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function personalTrainers()
    {
        return $this->belongsTo(PersonalTrainer::class, 'trainer_id', 'id');
    }

    public function trainerPackages()
    {
        return $this->belongsTo(TrainerPackage::class, 'trainer_package_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function trainerSessionCheckIn()
    {
        return $this->hasMany(CheckInTrainerSession::class);
    }
}
