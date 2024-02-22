<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MissedGuestController extends Controller
{
    public function index()
    {
        $members = DB::table('members as a')
            ->select(
                'a.id',
                'a.full_name',
                'a.nickname',
                'a.member_code',
                'a.gender',
                'a.born',
                'a.phone_number',
                'a.email',
                'a.ig',
                'a.emergency_contact',
                'a.address',
                'a.status',
                'a.photos',
            )
            ->where('a.status', '=', 'missed_guest')
            ->get();

        $data = [
            'title'             => 'Member List',
            'members'           => $members,
            // 'users'             => User::get(),
            'content'           => 'admin/members/missed-guest'
        ];

        return view('admin.layouts.wrapper', $data);
    }
}
