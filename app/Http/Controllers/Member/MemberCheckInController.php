<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member\CheckInMember;
use App\Models\Member\Member;
use App\Models\Member\MemberRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberCheckInController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'member_code' => 'required|exists:members,member_code',
        ]);

        $memberRegistration = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days',
                'b.full_name as member_name',
                'b.member_code',
                'b.phone_number',
                'b.born',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'c.package_price',
                'e.name as method_payment_name',
                'f.full_name as staff_name',
                'g.full_name as fc_name',
                'g.phone_number as fc_phone_number',
                'h.id as current_check_in_members_id',
                'h.check_out_time',
                'h.check_in_time',
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status'),
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join(
                'users as f',
                'a.user_id',
                '=',
                'f.id'
            )
            ->join('fitness_consultants as g', 'a.fc_id', '=', 'g.id')
            // ->leftJoin('check_in_members as h', 'a.id', '=', 'h.member_registration_id')
            // ->leftJoin(DB::raw('(SELECT member_registration_id, MAX(check_in_time) as check_in_time, MAX(check_out_time) as check_out_time FROM check_in_members GROUP BY member_registration_id) as i'), 'a.id', '=', 'i.member_registration_id')
            ->whereRaw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END = ?', ['Running'])
            ->leftJoin(DB::raw('(SELECT * FROM check_in_members  order by check_in_time desc limit 1) as h'), 'h.member_registration_id', '=', 'a.id')
            ->where('b.member_code', $request->input('member_code'))
            ->first();

        if (!$memberRegistration) {
            return redirect()->back()->with('error', 'Member active not found or has ended');
        }


        $message = "";
        if ($memberRegistration->current_check_in_members_id && !$memberRegistration->check_out_time) {
            $checkInMember = CheckInMember::find($memberRegistration->current_check_in_members_id);
            $checkInMember->update([
                'check_out_time' => now()->tz('Asia/Jakarta'),
            ]);
            $message = 'Member Checked Out Successfully';
        } else {
            $checkOutTime = null; // Default value

            $latestCheckIn = CheckInMember::where('member_registration_id', $memberRegistration->id)
                ->orderBy('check_in_time', 'desc')
                ->first();

            if ($latestCheckIn && $latestCheckIn->check_out_time === null) {
                $checkOutTime = now()->tz('Asia/Jakarta');
            }

            $data = [
                'member_registration_id' => $memberRegistration->id,
                'check_in_time' => now()->tz('Asia/Jakarta'),
                'user_id' => Auth::user()->id,
                'check_out_time' => $checkOutTime,
            ];

            CheckInMember::create($data);
            $message = 'Member Checked In Successfully';
        }

        return redirect()->route('member-active.index')->with('message', $message);
    }

    public function destroy($id)
    {
        try {
            $checkInMember = CheckInMember::find($id);
            $checkInMember->delete();
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
            CheckInMember::whereIn('id', $selectedItems)->delete();
            return redirect()->back()->with('message', 'Selected Check In Dates Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'No items selected for deletion');
        }
    }
}
