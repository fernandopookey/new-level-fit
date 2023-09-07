<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\Staff\PersonalTrainer;
use App\Models\Trainer\Trainer;
use App\Models\Trainer\TrainerSession;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalMember'           => Member::count(),
            'totalTrainer'          => Trainer::count(),
            'members'               => Member::take(2)->get(),
            // 'trainers'              => Trainer::take(5)->get(),
            'trainers'              => PersonalTrainer::take(5)->get(),
            'totalPersonalTrainers' => PersonalTrainer::count(),
            'activeMember'          => Member::where('status', 'Active')->count(),
            'inactiveMember'        => Member::where('status', 'Inactive')->count(),
            'totalTrainerSession'   => TrainerSession::count(),
            'runningTrainerSession' => Member::where('status', 'Running')->count(),
            'trainerSessionOver'    => Member::where('status', 'Over')->count(),
            'title'                 => 'Dashboard Admin Gelora GYM',
            'content'               => 'admin/dashboard/index'
        ];
        return view('admin.layouts.wrapper-dashboard', $data);
    }
}
