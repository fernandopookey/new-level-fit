<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerSessionUpdateRequest;
use App\Models\Member\Member;
use App\Models\Staff\PersonalTrainer;
use App\Models\Trainer\CheckInTrainerSession;
use App\Models\Trainer\TrainerPackage;
use App\Models\Trainer\TrainerSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerSessionCheckInController extends Controller
{
    public function create()
    {
        $data = [
            'title'             => 'New Trainer Session',
            'trainerSession'    => TrainerSession::all(),
            'members'           => Member::get(),
            'personalTrainers'  => PersonalTrainer::get(),
            'trainerPackages'   => TrainerPackage::get(),
            'content'           => 'admin/trainer-session/create',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'trainer_session_id'    => 'exists:trainer_sessions,id',
        ]);
        $data['check_in_date'] = Carbon::now()->tz('Asia/Jakarta');
        CheckInTrainerSession::create($data);
        return redirect()->route('trainer-session.index')->with('message', 'Member Check In Successfully');
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

    public function destroy($id)
    {
        try {
            $checkInTrainerSession = CheckInTrainerSession::find($id);
            $checkInTrainerSession->delete();
            return redirect()->back()->with('message', 'Check In Date Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Deleted Failed, please check other page where using this check in');
        }
    }
}
