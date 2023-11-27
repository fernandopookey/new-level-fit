<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\Member\MemberRegistration;
use App\Models\Staff\PersonalTrainer;
use App\Models\Trainer\Trainer;
use App\Models\Trainer\TrainerSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $runningRegistrationsMemberCount = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'b.full_name as member_name',
                'c.package_name',
                'c.days',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->where(DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END'), '=', 'Running')
            ->count();

        $overRegistrationsMemberCount = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'b.full_name as member_name',
                'c.package_name',
                'c.days',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->where(DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END'), '=', 'Over')
            ->count();

        $runningTrainerSessionCount = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'b.full_name as member_name',
                'c.package_name',
                'c.days',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->where(DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END'), '=', 'Running')
            ->count();

        $data = [
            'title'                             => 'Dashboard Admin Gelora GYM',
            'totalMember'                       => Member::count(),
            'memberRegistration'                => MemberRegistration::count(),
            'runningRegistrationsMemberCount'   => $runningRegistrationsMemberCount,
            'overRegistrationsMemberCount'      => $overRegistrationsMemberCount,
            'totalTrainers'                     => PersonalTrainer::count(),
            'totalTrainerSessions'              => TrainerSession::count(),
            'runningTrainerSessionsCount'       => $runningTrainerSessionCount,
            'members'                           => Member::take(5)->get(),
            'trainers'                          => PersonalTrainer::take(5)->get(),
            'totalPersonalTrainers'             => PersonalTrainer::count(),
            'totalTrainerSession'               => TrainerSession::count(),
            'content'                           => 'admin/dashboard/index'
        ];
        return view('admin.layouts.wrapper-dashboard', $data);
    }
}
