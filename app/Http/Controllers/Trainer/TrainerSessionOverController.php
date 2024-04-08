<?php

namespace App\Http\Controllers\Trainer;

use App\Exports\TrainerSessionExpiredExport;
use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\Trainer\TrainerSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class TrainerSessionOverController extends Controller
{
    public function index()
    {
        $fromDate   = Request()->input('fromDate');
        $toDate     = Request()->input('toDate');

        $excel = Request()->input('excel');
        if ($excel && $excel == "1") {
            return Excel::download(new TrainerSessionExpiredExport(), 'trainer-session-expired, ' . $fromDate . ' to ' . $toDate . '.xlsx');
        }

        $trainerSessions = Member::select(
            'a.id',
            'a.full_name as member_name',
            'a.member_code',
            'a.photos',
            'b.start_date',
            'b.id as ts_id',
            'b.trainer_full_name',
            'b.expired_date_date',
            'b.ts_days',
            'c.registered_member_id',
            'tp.package_name',
            'max_end_date',
            'total_package_price',
            'total_admin_price',
        )
            ->from('members as a')
            ->join(DB::raw('(select a.id as id_max, b.id, trainer.full_name as trainer_full_name, b.start_date,
                            b.days as ts_days, b.trainer_package_id, tp.package_name, max(DATE_ADD(b.start_date, INTERVAL b.days DAY))
                as max_end_date, sum(b.package_price) as total_package_price,
                DATE_ADD(b.start_date, INTERVAL b.days DAY) as expired_date_date,
                sum(b.admin_price) as total_admin_price from members a
                inner join trainer_sessions b on a.id=b.member_id
                LEFT JOIN personal_trainers trainer ON b.trainer_id = trainer.id
                LEFT JOIN trainer_packages tp ON b.trainer_package_id = tp.id
                where DATE_ADD(b.start_date, INTERVAL b.days DAY) < now() group by a.id, b.id, b.days, b.start_date,
                    trainer.full_name, b.trainer_package_id, tp.package_name) as b'), function ($join) {
                $join->on('a.id', '=', 'b.id_max');
            })
            ->leftJoin(DB::raw('(select distinct member_id as registered_member_id from trainer_sessions
                                    where DATE_ADD(start_date, INTERVAL days DAY) >= now()) as c'), function ($join) {
                $join->on('a.id', '=', 'c.registered_member_id');
            })
            ->leftJoin('trainer_packages as tp', 'tp.id', '=', 'b.trainer_package_id')
            ->whereNull('tp.status')
            ->whereNull('c.registered_member_id')
            ->get();

        $data = [
            'title'             => 'PT Expired List',
            'trainerSessions'   => $trainerSessions,
            'content'           => 'admin/trainer-session-over/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function deleteSelectedTrainerSessionsOver(Request $request)
    {
        $selectedTrainerSessionsOver = $request->input('selectedTrainerSessionsOver', []);

        // Add your logic to delete the selected members from the database
        TrainerSession::whereIn('id', $selectedTrainerSessionsOver)->delete();

        // Redirect back or return a response as needed
        return redirect()->back()->with('message', 'Selected trainer sessions over deleted successfully');
    }

    public function pdfReport()
    {
        $trainerSessionsOver = DB::table('trainer_sessions as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.package_price',
                'a.admin_price',
                'a.days',
                'b.full_name as member_name',
                'b.member_code',
                'c.package_name',
                'c.number_of_session',
                'd.full_name as trainer_name',
                'e.full_name as staff_name',
                DB::raw('MIN(a.created_at) as earliest_created_at'), // Added this line
                DB::raw('MAX(a.created_at) as latest_created_at')    // Added this line
            )
            ->addSelect(DB::raw('SUM(a.package_price) as total_price'))
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as expired_date_status')
            )
            ->addSelect(DB::raw('SUM(a.admin_price) as admin_price'))
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
            ->join('users as e', 'a.user_id', '=', 'e.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
            ->groupBy('a.id', 'a.start_date', 'a.description', 'a.package_price', 'a.admin_price', 'a.days', 'b.full_name', 'b.member_code', 'c.package_name', 'c.number_of_session', 'd.full_name', 'e.full_name', 'e.check_in_count')
            ->addSelect(DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'))
            ->addSelect(DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status'))
            // ->whereRaw('')
            ->having('session_status', '=', 'Over') // Use HAVING instead of WHERE
            ->get();

        $pdf = Pdf::loadView('admin/trainer-session-over/pdf', [
            'trainerSessionsOver'   => $trainerSessionsOver,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('trainer-sessions-over-report.pdf');
    }
}
