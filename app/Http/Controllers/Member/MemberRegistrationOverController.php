<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
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
                'b.id',
                'b.full_name as member_name',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'd.name as source_code_name',
                'e.name as method_payment_name',
                'f.full_name as staff_name',
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('"Over" as status'),
                DB::raw('SUM(a.package_price) as total_price'),
                DB::raw('SUM(a.admin_price) as admin_price')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('source_codes as d', 'a.source_code_id', '=', 'd.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->whereRaw('NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY)')
            ->groupBy(
                'a.start_date',
                'a.admin_price',
                'a.description',
                'a.package_price',
                'b.id',
                'b.full_name',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'd.name',
                'e.name',
                'f.full_name',
                'expired_date',
                'status'
            )
            ->get();

        $data = [
            'title'                     => 'Member Registration Over List',
            'memberRegistrationsOver'   => $memberRegistrationsOver,
            'content'                   => 'admin/member-registration-over/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function pdfReport()
    {
        $memberRegistrationsOver = DB::table('member_registrations as a')
            ->select(
                'a.package_price',
                'a.start_date',
                'a.admin_price',
                'a.description',
                'b.id',
                'b.full_name as member_name',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'd.name as source_code_name',
                'e.name as method_payment_name',
                'f.full_name as staff_name',
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('"Over" as status'),
                DB::raw('SUM(a.package_price) as total_price'),
                DB::raw('SUM(a.admin_price) as admin_price')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('source_codes as d', 'a.source_code_id', '=', 'd.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->whereRaw('NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY)')
            ->groupBy(
                'a.start_date',
                'a.admin_price',
                'a.description',
                'a.package_price',
                'b.id',
                'b.full_name',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'd.name',
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
}
