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
        'active_period',
        'member_id',
        'trainer_id',
        'trainer_package_id',
        'remaining_session',
        'status',
        'user_id'
    ];

    protected $hidden = [];

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    // public function trainers()
    // {
    //     return $this->belongsTo(Trainer::class, 'trainer_id', 'id');
    // }

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
}
