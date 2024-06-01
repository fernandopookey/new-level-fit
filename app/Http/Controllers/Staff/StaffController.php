<?php

namespace App\Http\Controllers\Staff;

use App\Exports\StaffExport;
use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\Staff\ClassInstructor;
use App\Models\Staff\PersonalTrainer;
use App\Models\Trainer\CheckInTrainerSession;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Psr7\Request;

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
        $fromDate       = Request()->input('fromDate');
        $fromDate       = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate         = Request()->input('toDate');
        $toDate         = $toDate ? DateFormat($toDate) : NowDate();
        $personalTrainer = Request()->input('trainerName');
        $pdf            = Request()->input('pdf');

        $results = PersonalTrainer::select('personal_trainers.full_name as trainer_name', DB::raw('COUNT(personal_trainers.id) as pt_total'))
            ->join('check_in_trainer_sessions', 'check_in_trainer_sessions.pt_id', '=', 'personal_trainers.id')
            ->whereNotNull('check_in_trainer_sessions.check_out_time')
            ->whereDate('check_in_trainer_sessions.check_in_time', '>=', $fromDate) // Ini bukannya harus pakai start_date ?
            ->whereDate('check_in_trainer_sessions.check_in_time', '<=', $toDate)
            ->where('personal_trainers.id', '=', $personalTrainer)
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
            'title'                 => 'Personal Trainer Total Report',
            'personalTrainer'       => $personalTrainer,
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

    public function lo()
    {
        $fromDate       = Request()->input('fromDate');
        $fromDate       = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate         = Request()->input('toDate');
        $toDate         = $toDate ? DateFormat($toDate) : NowDate();

        $personalTrainer = Request()->input('trainerName');
        $pdf            = Request()->input('pdf');

        $results = Member::select('members.full_name as member_name', 'members.lo_start_date', 'pt.full_name as pt_name')
            ->join('personal_trainers as pt', 'members.lo_pt_by', '=', 'pt.id')
            ->where('lo_is_used', 1)
            ->whereDate('lo_start_date', '>=', $fromDate)
            ->whereDate('lo_start_date', '<=', $toDate)
            ->where('pt.id', '=', $personalTrainer)
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/lo', [
                'result'   => $results,
            ]);
            return $pdf->stream('LO.pdf');
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
            'personalTrainer'       => $personalTrainer,
            'users'                 => User::get(),
            'page'                  => Request()->input('page'),
            'content'               => 'admin/gym-report/lo'
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

        $personalTrainer = Request()->input('trainerName');

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
            ->where('personal_trainers.id', '=', $personalTrainer)
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
            'personalTrainer'       => $personalTrainer,
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

    public function reportMemberPTCheckIn()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = DB::table('members')
            ->select(
                'cits.id as cits_id',
                'members.id as member_id',
                'members.full_name as member_name',
                'cits.check_in_time',
                'cits.check_out_time'
            )
            ->join('trainer_sessions as ts', 'ts.member_id', '=', 'members.id')
            ->join('check_in_trainer_sessions as cits', 'cits.trainer_session_id', '=', 'ts.id')
            ->whereDate('cits.check_in_time', '>=', $fromDate)
            ->whereDate('cits.check_in_time', '<=', $toDate)
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/report-member-pt-checkin', [
                'result'   => $results,
            ]);
            return $pdf->stream('Report-PT-checkin, ' . $fromDate . '-' . $toDate . '.pdf');
        }


        $data = [
            'title'                 => 'Report Member PT Check In',
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'customerService'       => User::where('role', 'CS')->get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'users'                 => User::get(),
            'content'               => 'admin/gym-report/report-member-pt-checkin'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function reportMemberCheckIn()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = DB::table('members')
            ->select(
                'cim.id as cim_id',
                'members.id as member_id',
                'members.full_name as member_name',
                'cim.check_in_time',
                'cim.check_out_time'
            )
            ->join('member_registrations as mr', 'mr.member_id', '=', 'members.id')
            ->join('check_in_members as cim', 'cim.member_registration_id', '=', 'mr.id')
            ->whereDate('cim.check_in_time', '>=', $fromDate)
            ->whereDate('cim.check_in_time', '<=', $toDate)
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/report-member-checkin', [
                'result'   => $results,
            ]);
            return $pdf->stream('Report-member-checkin, ' . $fromDate . '-' . $toDate . '.pdf');
        }


        $data = [
            'title'                 => 'Report Member Check In',
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'customerService'       => User::where('role', 'CS')->get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'users'                 => User::get(),
            'content'               => 'admin/gym-report/report-member-checkin'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function reportPTCheckIn()
    {
        $fromDate   = Request()->input('fromDate');
        $fromDate  = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate     = Request()->input('toDate');
        $toDate = $toDate ? DateFormat($toDate) : NowDate();
        $pdf = Request()->input('pdf');

        $results = DB::table('members')
            ->select(
                'cim.id as cim_id',
                'members.id as member_id',
                'members.full_name as member_name',
                'cim.check_in_time',
                'cim.check_out_time'
            )
            ->join('member_registrations as mr', 'mr.member_id', '=', 'members.id')
            ->join('check_in_members as cim', 'cim.member_registration_id', '=', 'mr.id')
            ->whereDate('cim.check_in_time', '>=', $fromDate)
            ->whereDate('cim.check_in_time', '<=', $toDate)
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/report-member-checkin', [
                'result'   => $results,
            ]);
            return $pdf->stream('Report-member-checkin, ' . $fromDate . '-' . $toDate . '.pdf');
        }


        $data = [
            'title'                 => 'Report Member Check In',
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'customerService'       => User::where('role', 'CS')->get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'users'                 => User::get(),
            'content'               => 'admin/gym-report/report-member-checkin'
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
