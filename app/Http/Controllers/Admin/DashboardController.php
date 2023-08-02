<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\Trainer\Trainer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalMember'           => Member::count(),
            'totalTrainer'          => Trainer::count(),
            'members'               => Member::take(2)->get(),
            'trainers'              => Trainer::take(1)->get(),
            'activeMember'          => Member::where('status', 'Active')->count(),
            'inactiveMember'        => Member::where('status', 'Inactive')->count(),
            'title'                 => 'Dashboard Admin Gelora GYM',
            'content'               => 'admin/dashboard/index'
        ];
        return view('admin.layouts.wrapper-dashboard', $data);
    }
}
