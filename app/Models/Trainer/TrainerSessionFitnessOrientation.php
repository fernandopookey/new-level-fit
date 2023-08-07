<?php

namespace App\Models\Trainer;

use App\Models\Member\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerSessionFitnessOrientation extends Model
{
    use HasFactory;

    protected $fillable = [
        'active_period',
        'session_code',
        'member_id',
        'trainer_id',
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
}
