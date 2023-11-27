<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member\CheckInMember;
use App\Models\Member\Member;
use App\Models\Member\MemberRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberCheckInController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'member_code' => 'required|exists:members,member_code',
        ]);
        $memberCode = $data['member_code'];

        $member = Member::where('member_code', $data['member_code'])->first();

        $memberRegistration = MemberRegistration::join('member_packages', 'member_registrations.member_package_id', '=', 'member_packages.id')->where('member_id', $member->id)
            ->whereRaw('NOW() <= DATE_ADD(member_registrations.start_date, INTERVAL member_packages.days DAY)')
            ->select('member_registrations.id')
            ->first();

        if ($memberRegistration === null) {
            return redirect()->back()->with('error', 'Member code not found or member package has over');
        }

        $data = [
            'check_in_date' => now()->tz('Asia/Jakarta'),
            'member_registration_id' => $memberRegistration->id,
        ];
        $data['user_id'] = Auth::user()->id;
        CheckInMember::create($data);
        return redirect()->route('member-registration.index')->with('message', 'Member Registration Check In Successfully');
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
}
