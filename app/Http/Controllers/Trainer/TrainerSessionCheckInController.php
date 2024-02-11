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
            'member_code'   => 'required|exists:members,member_code'
        ]);

        $trainerSession = DB::table('trainer_sessions as a')
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
                'g.id as current_check_in_trainer_sessions_id',
                'g.check_out_time'
            )
            ->addSelect(DB::raw('IFNULL(c.number_of_session - f.check_in_count, c.number_of_session) as remaining_sessions'))
            ->addSelect(DB::raw('CASE WHEN IFNULL(c.number_of_session - f.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - f.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status'))
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as expired_date_status')
            )
            ->leftJoin('members as b', 'a.member_id', '=', 'b.id')
            ->leftJoin('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->leftJoin('users as d', 'a.user_id', '=', 'd.id')
            ->leftJoin('personal_trainers as e', 'a.trainer_id', '=', 'e.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions GROUP BY trainer_session_id) as f'), 'f.trainer_session_id', '=', 'a.id')
            ->leftJoin(DB::raw('(SELECT * FROM check_in_trainer_sessions  order by check_in_time desc limit 1) as g'), 'g.trainer_session_id', '=', 'a.id')
            ->where('b.member_code', $request->input('member_code'))
            ->first();

        if (!$trainerSession) {
            return redirect()->back()->with('error', 'Trainer session not found or has ended');
        }

        // $latestCheckIn = CheckInTrainerSession::where('trainer_session_id', $trainerSession->id)
        //     ->orderBy('check_in_time', 'desc')
        //     ->first();

        // if ($latestCheckIn && $latestCheckIn->check_out_date === null) {
        //     $latestCheckIn->update([
        //         'check_out_time' => now()->tz('Asia/Jakarta'),
        //         // 'duration' => now()->diffInMinutes($latestCheckIn->check_in_date),
        //     ]);

        //     return redirect()->route('trainer-session.index')->with('message', 'Trainer Session Checked Out Successfully');
        // }

        $message = "";
        if ($trainerSession->current_check_in_trainer_sessions_id && !$trainerSession->check_out_time) {
            $checkInTrainerSession = CheckInTrainerSession::find($trainerSession->current_check_in_trainer_sessions_id);
            $checkInTrainerSession->update([
                'check_out_time' => now()->tz('Asia/Jakarta'),
            ]);
            $message = 'Trainer Session Checked Out Successfully';
        } else {
            $checkOutTime = null; // Default value

            $latestCheckIn = CheckInTrainerSession::where('trainer_session_id', $trainerSession->id)
                ->orderBy('check_in_time', 'desc')
                ->first();

            if ($latestCheckIn && $latestCheckIn->check_out_time === null) {
                $checkOutTime = now()->tz('Asia/Jakarta');
            }

            $data = [
                'trainer_session_id' => $trainerSession->id,
                'check_in_time' => now()->tz('Asia/Jakarta'),
                'user_id' => Auth::user()->id,
                'check_out_time' => $checkOutTime,
                'duration' => null,
            ];

            CheckInTrainerSession::create($data);
            $message = 'Trainer Session Checked In Successfully';
        }

        return redirect()->route('trainer-session.index')->with('message', $message);
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

    public function bulkDelete(Request $request)
    {
        $selectedItems = $request->input('selectedItems');

        if (!empty($selectedItems)) {
            // Use the IDs in $selectedItems to delete the selected rows
            CheckInTrainerSession::whereIn('id', $selectedItems)->delete();
            return redirect()->back()->with('message', 'Selected Check In Dates Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'No items selected for deletion');
        }
    }

    public function checkMemberExistence()
    {
        $data = request()->get('member_code'); // Assuming 'member_code' is the key from the AJAX request
        $model = new CheckInTrainerSession(); // Replace 'YourModel' with the actual name of your model
        $where = ['member_code' => $data]; // Adjust the condition based on your model

        return $model->where($where)->exists();
    }
}
