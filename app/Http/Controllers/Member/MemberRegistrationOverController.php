<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member\MemberRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberRegistrationOverController extends Controller
{
    public function index()
    {
        $memberRegistrationsOver = DB::table('member_registrations as a')
            ->select(
                'a.package_price',
                'a.start_date',
                'a.admin_price',
                'a.description',
                'a.id',
                'b.full_name as member_name',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name',
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('"Over" as status'),
                DB::raw('SUM(a.package_price) as total_price'),
                DB::raw('SUM(a.admin_price) as admin_price')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->whereRaw('NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY)')
            ->groupBy(
                'a.id',
                'a.start_date',
                'a.admin_price',
                'a.description',
                'a.package_price',
                'b.full_name',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'e.name',
                'f.full_name',
                'expired_date',
                'status'
            )
            ->get();

        $data = [
            'title'                     => 'Member Expired List',
            'memberRegistrationsOver'   => $memberRegistrationsOver,
            'content'                   => 'admin/member-registration-over/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function bulkDeleteOver(Request $request)
    {
        $selectedItems = $request->input('selectedMemberRegistrationOver');

        try {
            foreach ($selectedItems as $itemId) {
                $member = MemberRegistration::find($itemId);

                if (!empty($member)) {
                    // if ($member->photos != null) {
                    //     $realLocation = "storage/" . $member->photos;
                    //     if (file_exists($realLocation) && !is_dir($realLocation)) {
                    //         unlink($realLocation);
                    //     }
                    // }

                    $member->delete();
                }
            }

            return redirect()->back()->with('message', 'Member Registration Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Member Registration Deleted Failed, Please check other pages that are using this member');
        }
    }

    public function bulkDeleteRunning(Request $request)
    {
        $selectedItems = $request->input('selected_member_registrations');

        try {
            foreach ($selectedItems as $itemId) {
                $member = MemberRegistration::find($itemId);

                if (!empty($member)) {
                    if ($member->photos != null) {
                        $realLocation = "storage/" . $member->photos;
                        if (file_exists($realLocation) && !is_dir($realLocation)) {
                            unlink($realLocation);
                        }
                    }

                    $member->delete();
                }
            }

            return redirect()->back()->with('message', 'Member Registration Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Deleted Failed, Dehgtrhtrheck In First');
        }
    }

    public function pdfReport()
    {
        $memberRegistrationsOver = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.package_price',
                'a.start_date',
                'a.admin_price',
                'a.description',
                'b.full_name as member_name',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name',
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('"Over" as status'),
                DB::raw('SUM(a.package_price) as total_price'),
                DB::raw('SUM(a.admin_price) as admin_price')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->whereRaw('NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY)')
            ->groupBy(
                'a.id',
                'a.start_date',
                'a.admin_price',
                'a.description',
                'a.package_price',
                'b.full_name',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'e.name',
                'f.full_name',
                'expired_date',
                'status'
            )
            ->get();

        $pdf = Pdf::loadView('admin/member-registration-over/pdf', [
            'memberRegistrationsOver'   => $memberRegistrationsOver,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('member-registration-over-report.pdf');
    }

    public function deleteSelectedMembersOver(Request $request)
    {
        $selectedMembers = $request->input('selectedMembersOver', []);

        // Add your logic to delete the selected members from the database
        MemberRegistration::whereIn('id', $selectedMembers)->delete();

        // Redirect back or return a response as needed
        return redirect()->back()->with('message', 'Selected member registration deleted successfully');
    }
}
