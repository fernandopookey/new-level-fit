<?php

namespace App\Models\Trainer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInTrainerSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_session_id',
        'check_in_date',
    ];

    protected $hidden = [];

    public function trainerSession()
    {
        return $this->belongsTo(TrainerSession::class, 'trainer_session_id', 'id');
    }
}
