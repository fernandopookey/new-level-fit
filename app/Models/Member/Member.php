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
        'member_code',
        'gender',
        'phone_number',
        'address',
        'description',
        'photos',
        'user_id',
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
