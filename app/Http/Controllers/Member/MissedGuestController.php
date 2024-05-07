<?php

namespace App\Http\Controllers\Member;

use App\Exports\MissedGuestExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MissedGuestController extends Controller
{
    public function index()
    {
        $fromDate   = Request()->input('fromDate');
        $toDate     = Request()->input('toDate');

        $excel = Request()->input('excel');
        if ($excel && $excel == "1") {
            return Excel::download(new MissedGuestExport(), 'Missed Guest, ' . $fromDate . ' to ' . $toDate . '.xlsx');
        }

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
                'a.created_at'
            )
            ->where('a.status', '=', 'missed_guest')
            ->get();

        $data = [
            'title'             => 'Missed Guest',
            'members'           => $members,
            'fitnessConsultant' => User::where('role', 'FC')->get(),
            'content'           => 'admin/members/missed-guest'
        ];

        return view('admin.layouts.wrapper', $data);
    }
}