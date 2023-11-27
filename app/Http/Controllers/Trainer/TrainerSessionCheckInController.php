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
use Illuminate\Support\Facades\DB;

class TrainerSessionCheckInController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'member_code' => 'required|exists:members,member_code',
        ]);

        $trainerSession = DB::table('trainer_sessions as a')
            ->leftJoin('members as b', 'a.member_id', '=', 'b.id')
            ->leftJoin('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->leftJoin('users as d', 'a.user_id', '=', 'd.id')
            ->leftJoin('personal_trainers as e', 'a.trainer_id', '=', 'e.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions GROUP BY trainer_session_id) as f'), 'f.trainer_session_id', '=', 'a.id')
            ->where('b.member_code', $request->input('member_code'))
            ->select('a.id', 'a.start_date', 'b.full_name as member_name', 'b.member_code', 'c.package_name', 'c.number_of_session', 'd.full_name as trainer_name', 'e.full_name as staff_name')
            ->addSelect(DB::raw('IFNULL(c.number_of_session - f.check_in_count, c.number_of_session) as remaining_sessions'))
            ->addSelect(DB::raw('CASE WHEN IFNULL(c.number_of_session - f.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - f.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status'))
            ->first();

        if (!$trainerSession) {
            return redirect()->back()->with('error', 'Trainer session not found or has ended');
        }

        if ($trainerSession->remaining_sessions == 0) {
            return redirect()->back()->with('error', 'Trainer session has ended');
        }

        $data = [
            'trainer_session_id' => $trainerSession->id,
            'check_in_date'      => now()->tz('Asia/Jakarta'),
        ];

        $data['user_id'] = Auth::user()->id;

        CheckInTrainerSession::create($data);

        return redirect()->route('trainer-session.index')->with('message', 'Trainer Session Check In Successfully');
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
