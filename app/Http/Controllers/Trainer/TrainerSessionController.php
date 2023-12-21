<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerSessionStoreRequest;
use App\Http\Requests\TrainerSessionUpdateRequest;
use App\Models\Member\Member;
use App\Models\Staff\PersonalTrainer;
use App\Models\Trainer\CheckInTrainerSession;
use App\Models\Trainer\TrainerPackage;
use App\Models\Trainer\TrainerSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TrainerSessionController extends Controller
{
    public function index()
    {
        // $trainerSessions = DB::table('trainer_sessions as a')
        //     ->select(
        //         'a.id',
        //         'a.start_date',
        //         'a.description',
        //         'a.days',
        //         'b.full_name as member_name',
        //         'b.member_code',
        //         'c.package_name',
        //         'c.number_of_session',
        //         'c.package_price',
        //         'd.full_name as trainer_name',
        //         'e.full_name as staff_name',
        //         DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
        //         DB::raw(
        //             '
        //     CASE 
        //         WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over"
        //         WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) <= 0 THEN "Over"
        //         ELSE "Running" 
        //     END as status'
        //         ),
        //     )
        //     ->join('members as b', 'a.member_id', '=', 'b.id')
        //     ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
        //     ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
        //     ->join('users as e', 'a.user_id', '=', 'e.id')
        //     ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
        //     ->addSelect(DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'))
        //     // ->addSelect(DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status'))
        //     // ->whereRaw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END = "Running"')
        //     ->get();

        // Code below not using expired date, only using session remaining
        $trainerSessions = DB::table('trainer_sessions as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days',
                'b.full_name as member_name',
                'b.member_code',
                'b.phone_number as member_phone',
                'c.package_name',
                'c.number_of_session',
                'c.package_price',
                'd.full_name as trainer_name',
                'd.phone_number as trainer_phone',
                'e.full_name as staff_name',
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as expired_date_status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
            ->join('users as e', 'a.user_id', '=', 'e.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
            ->addSelect(DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'))
            ->addSelect(DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status'))
            ->whereRaw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END = "Running"')
            ->get();

        $data = [
            'title'             => 'Trainer Session List',
            'trainerSessions'   => $trainerSessions,
            'content'           => 'admin/trainer-session/index',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'             => 'New Trainer Session',
            'trainerSession'    => TrainerSession::all(),
            'members'           => Member::get(),
            'personalTrainers'  => PersonalTrainer::get(),
            'trainerPackages'   => TrainerPackage::get(),
            'users'             => User::get(),
            'content'           => 'admin/trainer-session/create',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(TrainerSessionStoreRequest $request)
    {
        $data = $request->all();

        $package = TrainerPackage::findOrFail($data['trainer_package_id']);

        $data['user_id'] = Auth::user()->id;

        $data['days'] = $package->days;

        $data['start_date'] =  $data['start_date'] . ' ' .  $data['start_time2'];
        $dateTime = new \DateTime($data['start_date']);
        $data['start_date'] = $dateTime->format('Y-m-d H:i:s');
        unset($data['start_time2']);

        $data['package_price'] = $package->package_price;
        $data['admin_price'] = $package->admin_price;
        TrainerSession::create($data);

        return redirect()->back()->with('message', 'Trainer Session Added Successfully');
    }

    // public function store(TrainerSessionStoreRequest $request)
    // {
    //     $data = $request->all();
    //     $package = TrainerPackage::findOrFail($data['trainer_package_id']);
    //     $data['user_id'] = Auth::user()->id;
    //     $data['package_price'] = $package->package_price;
    //     $data['admin_price'] = $package->admin_price;
    //     TrainerSession::create($data);
    //     return redirect()->route('trainer-session.index')->with('message', 'Trainer Session Added Successfully');
    // }

    public function show($id)
    {
        $trainerSessions = TrainerSession::find($id);

        if (!$trainerSessions) {
            // Handle case where the trainer session is not found
            return abort(404);
        }

        // Assuming you have a 'number_of_session' field in your TrainerSession model
        $totalSessions = $trainerSessions->trainerPackages->number_of_session;
        // dd($totalSessions);

        $checkInTrainerSession = $trainerSessions->trainerSessionCheckIn;

        // Count the number of check-ins
        $checkInCount = $checkInTrainerSession->count();

        // Calculate remaining sessions
        $remainingSessions = $totalSessions - $checkInCount;

        $data = [
            'title'                 => 'Trainer Session Detail',
            'checkInTrainerSession' => $checkInTrainerSession,
            'trainerSession'        => $trainerSessions,
            'totalSessions'         => $totalSessions,
            'remainingSessions'     => $remainingSessions,
            'members'               => Member::get(),
            'users'                 => User::get(),
            'personalTrainers'      => PersonalTrainer::get(),
            'trainerPackages'       => TrainerPackage::get(),
            'content'               => 'admin/trainer-session/show',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function edit(string $id)
    {
        $data = [
            'title'             => 'Edit Trainer Session',
            'trainerSession'    => TrainerSession::find($id),
            'members'           => Member::get(),
            'personalTrainers'  => PersonalTrainer::get(),
            'trainerPackages'   => TrainerPackage::get(),
            'content'           => 'admin/trainer-session/edit'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function update(TrainerSessionUpdateRequest $request, string $id)
    {
        $item = TrainerSession::find($id);

        // $package = TrainerSession::findOrFail($item->trainer_package_id);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $data['start_date'] =  $data['start_date'] . ' ' .  $data['start_time'];
        unset($data['start_time']);

        $status = DB::table('trainer_sessions as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days',
                'b.full_name as member_name',
                'b.member_code',
                'c.package_name',
                'c.number_of_session',
                'c.package_price',
                'd.full_name as trainer_name',
                'e.full_name as staff_name',
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as expired_date_status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
            ->join('users as e', 'a.user_id', '=', 'e.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
            ->addSelect(DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'))
            ->addSelect(DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS status'))
            ->whereRaw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END = "Running"')
            ->get();

        // if ($status['status'] == 'over') {
        //     // Assuming you have a relationship between MemberRegistration and Member
        //     $member = $item->members;

        //     // Update the member_code to null
        //     $member->update(['member_code' => null]);
        // }

        $item->update($data);
        return redirect()->route('trainer-session.index')->with('message', 'Trainer Session Updated Successfully');
    }

    public function freeze(Request $request, string $id)
    {
        $item = TrainerSession::find($id);
        $data = $request->validate([
            'start_date'            => 'nullable',
            'description'           => 'nullable',
        ]);
        $data['user_id'] = Auth::user()->id;

        $package = TrainerPackage::findOrFail($item->trainer_package_id);

        $data['package_price'] = $package->package_price;
        $data['admin_price'] = $package->admin_price;

        $item->update($data);

        $inputDays = $request->input('days_off');
        $sumDays = $item->days + $inputDays;

        $item->update(['days' => $sumDays]);

        return redirect()->route('trainer-session.index')->with('message', 'Trainer Session Freeze Successfully');
    }

    public function destroy(TrainerSession $trainerSession)
    {
        try {
            $trainerSession->delete();
            return redirect()->back()->with('message', 'Trainer Session Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Deleted Failed, please delete check in first');
        }
    }

    public function deleteSelectedTrainerSessions(Request $request)
    {
        $selectedTrainerSessions = $request->input('selectedTrainerSessions', []);

        // Add your logic to delete the selected members from the database
        TrainerSession::whereIn('id', $selectedTrainerSessions)->delete();

        // Redirect back or return a response as needed
        return redirect()->back()->with('message', 'Selected trainer sessions deleted successfully');
    }

    public function cetak_pdf()
    {
        $trainerSessions = DB::table('trainer_sessions as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days',
                'b.full_name as member_name',
                'b.member_code',
                'c.package_name',
                'c.number_of_session',
                'c.package_price',
                'd.full_name as trainer_name',
                'e.full_name as staff_name',
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as expired_date_status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
            ->join('users as e', 'a.user_id', '=', 'e.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
            ->addSelect(DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'))
            ->addSelect(DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status'))
            ->whereRaw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END = "Running"')
            ->get();

        $pdf = Pdf::loadView('admin/trainer-session/trainer-session-pdf', [
            'trainerSessions'        => $trainerSessions,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('trainer-session-report.pdf');
    }
}
