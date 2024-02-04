<?php

namespace App\Models\Member;

use App\Models\Trainer\TrainerSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'nickname',
        'member_code',
        'gender',
        'born',
        'phone_number',
        'email',
        'ig',
        'emergency_contact',
        'address',
        'status',
        'description',
        'photos',
        'user_id',
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function trainerSession()
    {
        return $this->hasMany(TrainerSession::class);
    }

    public function memberRegistration()
    {
        return $this->hasMany(MemberRegistration::class);
    }
}