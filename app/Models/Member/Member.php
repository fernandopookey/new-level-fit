<?php

namespace App\Models\Member;

use App\Models\Trainer\TrainerSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'full_name',
        'nickname',
        'member_code',
        'card_number',
        'gender',
        'born',
        'phone_number',
        'email',
        'ig',
        'emergency_contact',
        'ec_name',
        'address',
        'status',
        'description',
        'photos',
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

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    // public function methodPayment()
    // {
    //     return $this->hasMany(Member::class);
    // }
}