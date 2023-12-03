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
        $trainerSessions = DB::table('trainer_sessions as a')
            ->select('a.id', 'a.start_date', 'a.description', 'b.full_name as member_name', 'b.member_code', 'c.package_name', 'c.number_of_session', 'd.full_name as trainer_name', 'e.full_name as staff_name')
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
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $item->update($data);
        return redirect()->route('trainer-session.index')->with('message', 'Trainer Session Updated Successfully');
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

    public function cetak_pdf()
    {
        $trainerSessions = DB::table('trainer_sessions as a')
            ->select('a.id', 'a.start_date', 'b.full_name as member_name', 'b.member_code', 'c.package_name', 'c.number_of_session', 'd.full_name as trainer_name', 'e.full_name as staff_name')
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
            ->join('users as e', 'a.user_id', '=', 'e.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
            ->addSelect(DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'))
            ->addSelect(DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status'))
            ->get();

        $pdf = Pdf::loadView('admin/trainer-session/trainer-session-pdf', [
            'trainerSessions'        => $trainerSessions,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('trainer-session-report.pdf');
    }

    public function print_trainer_session_detail_pdf()
    {
        $trainerSessionCheckIn = CheckInTrainerSession::with('trainerSession')->get();
        $members            = Member::orderBy('full_name')->get();
        $trainerSessions    = TrainerSession::orderBy('status', 'DESC')->get();
        $personalTrainers   = PersonalTrainer::all();
        $trainerPackages    = TrainerPackage::all();

        $pdf = Pdf::loadView('admin/trainer-session/trainer-session-pdf', [
            'trainerSession'        => $trainerSessions,
            'members'               => $members,
            'trainerSessionCheckIn' => $trainerSessionCheckIn,
            'personalTrainers'      => $personalTrainers,
            'trainerPackages'       => $trainerPackages,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('detail-trainer-session-report.pdf');
    }
}
