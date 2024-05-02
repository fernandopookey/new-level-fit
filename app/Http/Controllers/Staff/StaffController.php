<?php

namespace App\Http\Controllers\Staff;

use App\Exports\StaffExport;
use App\Http\Controllers\Controller;
use App\Models\Staff\ClassInstructor;
use App\Models\Staff\PersonalTrainer;
use App\Models\Trainer\CheckInTrainerSession;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class StaffController extends Controller
{
    public function index()
    {
        $fromDate   = Request()->input('fromDate');
        $toDate     = Request()->input('toDate');

        $excel = Request()->input('excel');
        if ($excel && $excel == "1") {
            return Excel::download(new StaffExport(), 'staff, ' . $fromDate . ' to ' . $toDate . '.xlsx');
        }

        $data = [
            'title'                 => 'Staff List',
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'classInstructor'       => ClassInstructor::get(),
            'customerService'       => User::where('role', 'CS')->get(),
            'customerServicePos'    => User::where('role', 'CSPOS')->get(),
            'fitnessConsultant'     => User::where('role', 'FC')->get(),
            'personalTrainer'       => PersonalTrainer::get(),
            'users'                 => User::get(),
            "page"                  => Request()->input('page'),
            'content'               => 'admin/staff/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function ptTotalReport()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = PersonalTrainer::select('personal_trainers.full_name as trainer_name', DB::raw('COUNT(personal_trainers.id) as pt_total'))
            ->join('check_in_trainer_sessions', 'check_in_trainer_sessions.pt_id', '=', 'personal_trainers.id')
            ->whereNotNull('check_in_trainer_sessions.check_out_time')
            ->whereDate('check_in_trainer_sessions.check_in_time', '>=', $fromDate) // Ini bukannya harus pakai start_date ?
            ->whereDate('check_in_trainer_sessions.check_in_time', '<=', $toDate)
            ->groupBy('personal_trainers.id', 'personal_trainers.full_name')
            ->orderBy('personal_trainers.full_name', 'asc')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/pt-total', [
                'result'   => $results,
            ]);
            return $pdf->stream('PT-Total-Report.pdf');
        }


        $data = [
            'title'                 => 'PT Total Report',
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'classInstructor'       => ClassInstructor::get(),
            'customerService'       => User::where('role', 'CS')->get(),
            'customerServicePos'    => User::where('role', 'CSPOS')->get(),
            'fitnessConsultant'     => User::where('role', 'FC')->get(),
            'personalTrainers'      => PersonalTrainer::get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'users'                 => User::get(),
            'page'                  => Request()->input('page'),
            'content'               => 'admin/gym-report/pt-total'
        ];

        return view('admin.layouts.wrapper', $data);
    }


    public function ptDetailReport()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = CheckInTrainerSession::select(
            'personal_trainers.full_name as trainer_name',
            'check_in_trainer_sessions.check_in_time',
            'check_in_trainer_sessions.check_out_time',
            'members.full_name as member_name',
            'trainer_packages.package_name'
        )
            ->join('personal_trainers', 'check_in_trainer_sessions.pt_id', '=', 'personal_trainers.id')
            ->join('trainer_sessions', 'check_in_trainer_sessions.trainer_session_id', '=', 'trainer_sessions.id')
            ->join('trainer_packages', 'trainer_sessions.trainer_package_id', '=', 'trainer_packages.id')
            ->join('members', 'trainer_sessions.member_id', '=', 'members.id')
            ->whereNotNull('check_in_trainer_sessions.check_out_time')
            ->whereDate('check_in_time', '>=', $fromDate)
            ->whereDate('check_in_time', '<=', $toDate)
            ->orderBy('personal_trainers.full_name')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/pt-detail', [
                'result'   => $results,
            ]);
            return $pdf->stream('PT-Detail-Report.pdf');
        }


        $data = [
            'title'                 => 'PT Detail Report',
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'classInstructor'       => ClassInstructor::get(),
            'customerService'       => User::where('role', 'CS')->get(),
            'customerServicePos'    => User::where('role', 'CSPOS')->get(),
            'fitnessConsultant'     => User::where('role', 'FC')->get(),
            'personalTrainers'      => PersonalTrainer::get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'users'                 => User::get(),
            'page'                  => Request()->input('page'),
            'content'               => 'admin/gym-report/pt-detail'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function csTotalReportMemberCheckIn()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = User::select('users.full_name as cs_name', DB::raw('COUNT(users.id) as cs_total'))
            ->join('member_registrations', 'member_registrations.user_id', '=', 'users.id')
            ->whereDate('member_registrations.created_at', '>=', $fromDate)
            ->whereDate('member_registrations.created_at', '<=', $toDate)
            ->where('users.role', '=', 'CS')
            ->groupBy('users.id', 'users.full_name')
            ->orderBy('users.full_name', 'asc')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/cs-total-report-member-checkin', [
                'result'   => $results,
            ]);
            return $pdf->stream('CS-Total-Report-member-checkin, ' . $fromDate . '-' . $toDate . '.pdf');
        }


        $data = [
            'title'                 => 'CS Total Input Member Check In',
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'customerService'       => User::where('role', 'CS')->get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'users'                 => User::get(),
            'content'               => 'admin/gym-report/cs-total-report-member-checkin'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function csDetailReportMemberCheckIn()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = User::select('users.full_name as cs_name', 'members.full_name as member_name', 'member_packages.package_name')
            ->join('member_registrations as mr', 'users.id', '=', 'mr.user_id')
            ->join('member_packages', 'mr.member_package_id', '=', 'member_packages.id')
            ->join('members', 'members.id', '=', 'mr.member_id')
            ->whereDate('mr.created_at', '>=', $fromDate)
            ->whereDate('mr.created_at', '<=', $toDate)
            ->where('users.role', 'CS')
            ->orderBy('users.full_name')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/cs-detail-report-member-checkin', [
                'result'   => $results,
            ]);
            return $pdf->stream('CS-Detail-Member-CheckIn-Report.pdf');
        }


        $data = [
            'title'                 => 'CS Detail Input Member Check In',
            'customerService'       => User::where('role', 'CS')->get(),
            'personalTrainers'      => PersonalTrainer::get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'content'               => 'admin/gym-report/cs-detail-report-member-checkin'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function csTotalReportPT()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = User::select('users.full_name as cs_name', DB::raw('COUNT(users.id) as cs_total'))
            ->join('trainer_sessions', 'trainer_sessions.user_id', '=', 'users.id')
            ->whereDate('trainer_sessions.created_at', '>=', $fromDate)
            ->whereDate('trainer_sessions.created_at', '<=', $toDate)
            ->where('users.role', '=', 'CS')
            ->groupBy('users.id', 'users.full_name')
            ->orderBy('users.full_name', 'asc')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/cs-total-report-pt', [
                'result'   => $results,
            ]);
            return $pdf->stream('CS-Total-Report-pt, ' . $fromDate . '-' . $toDate . '.pdf');
        }


        $data = [
            'title'                 => 'CS Total Input PT',
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'customerService'       => User::where('role', 'CS')->get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'users'                 => User::get(),
            'content'               => 'admin/gym-report/cs-total-report-pt'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function csDetailReportPT()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = User::select('users.full_name as cs_name', 'members.full_name as member_name', 'trainer_packages.package_name')
            ->join('trainer_sessions as ts', 'users.id', '=', 'ts.user_id')
            ->join('trainer_packages', 'ts.trainer_package_id', '=', 'trainer_packages.id')
            ->join('members', 'members.id', '=', 'ts.member_id')
            ->whereDate('ts.created_at', '>=', $fromDate)
            ->whereDate('ts.created_at', '<=', $toDate)
            ->where('users.role', 'CS')
            ->orderBy('users.full_name')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/cs-detail-report-pt', [
                'result'   => $results,
            ]);
            return $pdf->stream('CS-Detail-pt-Report.pdf');
        }


        $data = [
            'title'                 => 'CS Detail Input PT',
            'customerService'       => User::where('role', 'CS')->get(),
            'personalTrainers'      => PersonalTrainer::get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'content'               => 'admin/gym-report/cs-detail-report-pt'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function fcTotalReportMemberCheckIn()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = User::select('users.full_name as fc_name', DB::raw('COUNT(users.id) as fc_total'))
            ->join('member_registrations', 'member_registrations.fc_id', '=', 'users.id')
            ->whereDate('member_registrations.created_at', '>=', $fromDate)
            ->whereDate('member_registrations.created_at', '<=', $toDate)
            ->where('users.role', '=', 'FC')
            ->groupBy('users.id', 'users.full_name')
            ->orderBy('users.full_name', 'asc')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/fc-total-report-member-checkin', [
                'result'   => $results,
            ]);
            return $pdf->stream('FC-Total-Report-Member-checkin, ' . $fromDate . '-' . $toDate . '.pdf');
        }


        $data = [
            'title'                 => 'FC Total Input Member Check In',
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'customerService'       => User::where('role', 'FC')->get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'users'                 => User::get(),
            'content'               => 'admin/gym-report/fc-total-report-member-checkin'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function fcDetailReportMemberCheckIn()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = User::select('users.full_name as fc_name', 'members.full_name as member_name', 'member_packages.package_name')
            ->join('member_registrations as mr', 'users.id', '=', 'mr.fc_id')
            ->join('member_packages', 'mr.member_package_id', '=', 'member_packages.id')
            ->join('members', 'members.id', '=', 'mr.member_id')
            ->whereDate('mr.created_at', '>=', $fromDate)
            ->whereDate('mr.created_at', '<=', $toDate)
            ->where('users.role', 'FC')
            ->orderBy('users.full_name')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/fc-detail-report-member-checkin', [
                'result'   => $results,
            ]);
            return $pdf->stream('FC-Detail-Member-CheckIn-Report.pdf');
        }


        $data = [
            'title'                 => 'FC Detail Input Member Check In',
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'content'               => 'admin/gym-report/fc-detail-report-member-checkin'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function fcTotalReportPT()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = User::select('users.full_name as fc_name', DB::raw('COUNT(users.id) as fc_total'))
            ->join('trainer_sessions', 'trainer_sessions.fc_id', '=', 'users.id')
            ->whereDate('trainer_sessions.created_at', '>=', $fromDate)
            ->whereDate('trainer_sessions.created_at', '<=', $toDate)
            ->where('users.role', '=', 'FC')
            ->groupBy('users.id', 'users.full_name')
            ->orderBy('users.full_name', 'asc')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/fc-total-report-pt', [
                'result'   => $results,
            ]);
            return $pdf->stream('FC-Total-Report-pt, ' . $fromDate . '-' . $toDate . '.pdf');
        }


        $data = [
            'title'                 => 'FC Total Input PT',
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'content'               => 'admin/gym-report/fc-total-report-pt'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function fcDetailReportPT()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = User::select('users.full_name as fc_name', 'members.full_name as member_name', 'trainer_packages.package_name')
            ->join('trainer_sessions as ts', 'users.id', '=', 'ts.fc_id')
            ->join('trainer_packages', 'ts.trainer_package_id', '=', 'trainer_packages.id')
            ->join('members', 'members.id', '=', 'ts.member_id')
            ->whereDate('ts.created_at', '>=', $fromDate)
            ->whereDate('ts.created_at', '<=', $toDate)
            ->where('users.role', 'FC')
            ->orderBy('users.full_name')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/fc-detail-report-pt', [
                'result'   => $results,
            ]);
            return $pdf->stream('FC-Detail-pt-Report.pdf');
        }


        $data = [
            'title'                 => 'FC Detail Input PT',
            'personalTrainers'      => PersonalTrainer::get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'content'               => 'admin/gym-report/fc-detail-report-pt'
        ];

        return view('admin.layouts.wrapper', $data);
    }
}
