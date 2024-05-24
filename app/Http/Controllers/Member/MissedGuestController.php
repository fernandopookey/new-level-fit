<?php

namespace App\Http\Controllers\Member;

use App\Exports\MissedGuestExport;
use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\User;
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

        $data = [
            'title'             => 'Missed Guest',
            'members'           => Member::where('status', 'missed_guest')->get(),
            'fitnessConsultant' => User::where('role', 'FC')->get(),
            'content'           => 'admin/members/missed-guest'
        ];

        return view('admin.layouts.wrapper', $data);
    }
}