<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberStoreRequest;
use App\Models\Member\Member;
use App\Models\Member\MemberPackage;
use App\Models\MethodPayment;
use App\Models\Refferal;
use App\Models\Sold;
use App\Models\SourceCode;
use App\Models\Staff\FitnessConsultant;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;


class MemberController extends Controller
{
    public function index()
    {
        $currentTime = Carbon::now()->tz('Asia/Jakarta');

        $data = [
            'title'             => 'Member List',
            'members'           => Member::get(),
            'memberLastCode'    => Member::latest('id')->first(),
            'sourceCode'        => SourceCode::get(),
            'memberPackage'     => MemberPackage::get(),
            'methodPayment'     => MethodPayment::get(),
            'fitnessConsultant' => FitnessConsultant::get(),
            'referralName'      => Member::get(),
            'users'             => User::get(),
            'currentTime'       => $currentTime,
            'content'           => 'admin/member/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'             => 'New Member',
            'members'           => Member::get(),
            'memberLastCode'    => Member::latest('id')->first(),
            'sourceCode'        => SourceCode::get(),
            'memberPackage'     => MemberPackage::get(),
            'methodPayment'     => MethodPayment::get(),
            'fitnessConsultant' => FitnessConsultant::get(),
            'referralName'      => FitnessConsultant::get(),
            // 'refferalName'      => FitnessConsultant::get(),
            'content'           => 'admin/member/create-page',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'             => 'required',
            'gender'                => 'required',
            'phone_number'          => 'required',
            'source_code_id'        => 'required|exists:source_codes,id',
            'member_package_id'     => 'required|exists:member_packages,id',
            'start_date'            => '',
            'expired_date'          => '',
            'method_payment_id'     => 'required|exists:method_payments,id',
            'fc_id'                 => 'required|exists:fitness_consultants,id',
            'refferal_id'           => 'required|exists:fitness_consultants,id',
            'status'                => 'required',
            'description'           => '',
            'photos'                => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $member = $request->member_code;
        $memberCode = 'GG-' . $member . '-M';

        $existingRecord = Member::where('member_code', $memberCode)->first();

        if ($existingRecord) {
            return redirect()->back()->with('error', 'Code already exists');
        }

        if ($request->hasFile('photos')) {

            if ($request->photos != null) {
                $realLocation = "storage/" . $request->photos;
                if (file_exists($realLocation) && !is_dir($realLocation)) {
                    unlink($realLocation);
                }
            }

            $photos = $request->file('photos');
            $file_name = time() . '-' . $photos->getClientOriginalName();

            $data['photos'] = $request->file('photos')->store('assets/member', 'public');
        } else {
            $data['photos'] = $request->photos;
        }

        $data['member_code'] = 'GG-' . $member . '-M';
        Member::create($data);
        return redirect()->route('member.index')->with('message', 'Member Added Successfully');
    }

    public function memberSecondStore(Request $request)
    {
        // $try = DB::table('members')->join('fitness_consultants', 'members.id' '=', 'fitness_consultants.members_fk_fc')->select('members.*', 'fitness_consultants');

        // $memberPackage = ;

        $data = $request->validate(
            [
                'full_name'             => 'required',
                'gender'                => 'required',
                'phone_number'          => '',
                'source_code_id'        => 'required|exists:source_codes,id',
                'member_package_id'     => 'required|exists:member_packages,id',
                'start_date'            => '',
                'expired_date'          => '',
                'method_payment_id'     => 'required|exists:method_payments,id',
                // 'fc_id'                 => 'required|exists:fitness_consultants,id',
                'refferal_id'           => '',
                'status'                => 'required',
                'description'           => '',
                'user_id'               => '',
                'photos'                => 'mimes:png,jpg,jpeg|max:2048'
            ],
            // This is custom error message
            [
                'full_name.required'        => 'Full Name tidak boleh kosong',
                'gender.required'           => 'Gender tidak boleh kosong',
                'source_code_id.exists'     => 'Source Code tidak boleh kosong',
                'member_package_id.exists'  => 'Member Package tidak boleh kosong',
                'method_payment_id.exists'  => 'Method Payment tidak boleh kosong',
            ]
        );

        $member = $request->member_code;
        $memberCode = 'GG-' . $member . '-M';
        $data['user_id'] = Auth::user()->id;

        $existingRecord = Member::where('member_code', $memberCode)->first();

        if ($existingRecord) {
            return redirect()->back()->with('error', 'Code already exists');
        }

        if ($request->hasFile('photos')) {

            if ($request->photos != null) {
                $realLocation = "storage/" . $request->photos;
                if (file_exists($realLocation) && !is_dir($realLocation)) {
                    unlink($realLocation);
                }
            }

            $photos = $request->file('photos');
            $file_name = time() . '-' . $photos->getClientOriginalName();

            $data['photos'] = $request->file('photos')->store('assets/member', 'public');
        } else {
            $data['photos'] = $request->photos;
        }

        $data['member_code'] = 'GG-' . $member . '-M';
        Member::create($data);
        return redirect()->back()->with('message', 'Member Added Successfully');
    }

    public function edit(string $id)
    {
        $data = [
            'title'             => 'Edit Member',
            'member'            => Member::find($id),
            'members'           => Member::get(),
            'memberLastCode'    => Member::latest('id')->first(),
            'sourceCode'        => SourceCode::get(),
            'memberPackage'     => MemberPackage::get(),
            'methodPayment'     => MethodPayment::get(),
            'fitnessConsultant' => FitnessConsultant::get(),
            'referralName'      => FitnessConsultant::get(),
            'content'           => 'admin/member/edit-page',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request, string $id)
    {
        $item = Member::find($id);
        $data = $request->validate([
            'full_name'            => '',
            'gender'                => '',
            'phone_number'          => '',
            'source_code_id'        => 'exists:source_codes,id',
            'member_package_id'     => 'exists:member_packages,id',
            'start_date'            => '',
            'method_payment_id'     => 'exists:method_payments,id',
            'fc_id'                 => 'exists:fitness_consultants,id',
            'refferal_id'           => '',
            'status'                => '',
            'description'           => '',
            'photos'                => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($request->hasFile('photos')) {

            if ($request->photos != null) {
                $realLocation = "storage/" . $request->photos;
                if (file_exists($realLocation) && !is_dir($realLocation)) {
                    unlink($realLocation);
                }
            }

            $photos = $request->file('photos');
            $file_name = time() . '-' . $photos->getClientOriginalName();

            $data['photos'] = $request->file('photos')->store('assets/member', 'public');
        } else {
            $data['photos'] = $request->photos;
        }

        $item->update($data);
        return redirect()->route('member.index')->with('message', 'Member Updated Successfully');
    }

    public function destroy(Member $member)
    {
        try {
            if ($member->photos != null) {
                $realLocation = "storage/" . $member->photos;
                if (file_exists($realLocation) && !is_dir($realLocation)) {
                    unlink($realLocation);
                }
            }

            Storage::delete($member->photos);
            $member->delete();
            return redirect()->back()->with('message', 'Member Deleted Successfully');
        } catch (\Throwable $e) {
            // Alert::error('Error', $e->getMessage());
            return redirect()->back()->with('error', 'Member Deleted Failed, please check other session where using this member');
        }
    }

    public function cetak_pdf()
    {
        $members            = Member::orderBy('full_name')->get();
        $sourceCodes        = SourceCode::all();
        $memberPackages     = MemberPackage::all();
        $methodPayments     = MethodPayment::all();
        $fitnessConsultants = FitnessConsultant::all();
        $referralNames      = FitnessConsultant::all();

        $pdf = PDF::loadView('admin/member/member_pdf', [
            'members'               => $members,
            'sourceCodes'           => $sourceCodes,
            'memberPackages'        => $memberPackages,
            'methodPayments'        => $methodPayments,
            'fitnessConsultants'    => $fitnessConsultants,
            'referralNames'         => $referralNames
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-member-pdf');
    }
}
