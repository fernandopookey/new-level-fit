<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\Member\MemberPackage;
use App\Models\Member\MemberRegistration;
use App\Models\MethodPayment;
use App\Models\SourceCode;
use App\Models\Staff\FitnessConsultant;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class MemberRegistrationController extends Controller
{
    public function index()
    {
        $memberRegistrations = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.package_price as mr_package_price',
                'a.admin_price as mr_admin_price',
                'b.full_name as member_name', // alias for members table name column
                'c.package_name',
                'c.days',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name', // alias for method_payments table name column
                'f.full_name as staff_name', // alias for users table name column
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->whereRaw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END = ?', ['Running'])
            ->orderBy('status', 'desc')
            ->get();

        // dd($query);

        $data = [
            'title'                 => 'Member Registration List',
            'memberRegistrations'   => $memberRegistrations,
            'content'               => 'admin/member-registration/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'                 => 'Create Member Registration',
            'memberRegistration'    => MemberRegistration::get(),
            'members'               => Member::get(),
            'sourceCode'            => SourceCode::get(),
            'memberPackage'         => MemberPackage::get(),
            'methodPayment'         => MethodPayment::get(),
            'fitnessConsultant'     => FitnessConsultant::get(),
            'referralName'          => FitnessConsultant::get(),
            // 'refferalName'          => FitnessConsultant::get(),
            'content'               => 'admin/member-registration/create-page',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'             => 'required',
            'gender'                => 'required',
            'phone_number'          => 'required',
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
        return redirect()->route('member-registration.index')->with('message', 'Member Added Successfully');
    }

    public function memberSecondStore(Request $request)
    {
        $data = $request->validate(
            [
                'member_id'             => 'required|exists:members,id',
                'member_package_id'     => 'required|exists:member_packages,id',
                'start_date'            => '',
                'method_payment_id'     => 'required|exists:method_payments,id',
                // 'fc_id'                 => 'required|exists:fitness_consultants,id',
                'refferal_id'           => '',
                'description'           => '',
                'user_id'               => ''
            ],
            // This is custom error message
            [
                'full_name.required'        => 'Full Name tidak boleh kosong',
                'gender.required'           => 'Gender tidak boleh kosong',
                'member_package_id.exists'  => 'Member Package tidak boleh kosong',
                'method_payment_id.exists'  => 'Method Payment tidak boleh kosong',
            ]
        );

        $package = MemberPackage::findOrFail($data['member_package_id']);

        $member = $request->member_code;
        $data['user_id'] = Auth::user()->id;
        $data['package_price'] = $package->package_price;
        $data['admin_price'] = $package->admin_price;

        $data['member_code'] = 'GG-' . $member . '-M';
        MemberRegistration::create($data);
        return redirect()->back()->with('message', 'Member Added Successfully');
    }

    public function show($id)
    {
        $query = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'b.full_name as member_name',
                'b.address',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->where('a.id', $id)
            ->get();
        // dd($id);

        $checkInMemberRegistration = MemberRegistration::find($id);

        $data = [
            'title'                     => 'Detail Member Registration',
            'memberRegistration'        => $query->first(),
            'memberRegistrationCheckIn' => $checkInMemberRegistration->memberRegistrationCheckIn,
            'members'                   => Member::get(),
            'users'                     => User::get(),
            'memberLastCode'            => Member::latest('id')->first(),
            'sourceCode'                => SourceCode::get(),
            'memberPackage'             => MemberPackage::get(),
            'methodPayment'             => MethodPayment::get(),
            'fitnessConsultant'         => FitnessConsultant::get(),
            'referralName'              => FitnessConsultant::get(),
            'content'                   => 'admin/member-registration/show',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function edit(string $id)
    {
        // dd(MemberRegistration::find($id));
        $data = [
            'title'                 => 'Edit Member Registration',
            'memberRegistration'    => MemberRegistration::find($id),
            'members'               => Member::get(),
            'memberLastCode'        => Member::latest('id')->first(),
            'sourceCode'            => SourceCode::get(),
            'memberPackage'         => MemberPackage::get(),
            'methodPayment'         => MethodPayment::get(),
            'fitnessConsultant'     => FitnessConsultant::get(),
            'referralName'          => FitnessConsultant::get(),
            'content'               => 'admin/member-registration/edit-page',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request, string $id)
    {
        $item = MemberRegistration::find($id);
        $data = $request->validate([
            'full_name'            => '',
            'gender'                => '',
            'phone_number'          => '',
            'member_package_id'     => 'exists:member_packages,id',
            'start_date'            => '',
            'method_payment_id'     => 'exists:method_payments,id',
            'fc_id'                 => 'exists:fitness_consultants,id',
            'refferal_id'           => '',
            'status'                => '',
            'description'           => '',
            'photos'                => 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $data['user_id'] = Auth::user()->id;

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

        $package = MemberPackage::findOrFail($data['member_package_id']);
        $data['package_price'] = $package->package_price;
        $data['admin_price'] = $package->admin_price;

        $item->update($data);
        return redirect()->route('member-registration.index')->with('message', 'Member Updated Successfully');
    }

    public function destroy(MemberRegistration $memberRegistration)
    {
        try {
            if ($memberRegistration->photos != null) {
                $realLocation = "storage/" . $memberRegistration->photos;
                if (file_exists($realLocation) && !is_dir($realLocation)) {
                    unlink($realLocation);
                }
            }

            Storage::delete($memberRegistration->photos);
            $memberRegistration->delete();
            return redirect()->back()->with('message', 'Member Deleted Successfully');
        } catch (\Throwable $e) {
            // Alert::error('Error', $e->getMessage());
            return redirect()->back()->with('error', 'Member Deleted Failed, please check other session where using this member');
        }
    }

    public function cetak_pdf()
    {
        $query = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'b.full_name as member_name', // alias for members table name column
                'c.package_name',
                'c.days',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name', // alias for method_payments table name column
                'f.full_name as staff_name' // alias for users table name column
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->get();

        $pdf = Pdf::loadView('admin/member-registration/member-registration-pdf', [
            'memberRegistrations'   => $query,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('member-registration-report.pdf');
    }

    public function print_detail_pdf($id)
    {
        $query = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'b.full_name as member_name',
                'b.address',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->where('a.id', $id) // Assuming 'id' is the primary key of the 'member_registrations' table
            ->get();

        $data = [
            'title'                 => 'Detail Member Registration',
            'memberRegistration'    => $query->first(),
            'members'               => Member::get(),
            'memberLastCode'        => Member::latest('id')->first(),
            'sourceCode'            => SourceCode::get(),
            'memberPackage'         => MemberPackage::get(),
            'methodPayment'         => MethodPayment::get(),
            'fitnessConsultant'     => FitnessConsultant::get(),
            'referralName'          => FitnessConsultant::get(),
        ];

        $pdf = Pdf::loadView('admin/member-registration/member-registration-detail-pdf', [
            'memberRegistrations'   => $query,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('member-registration-detail.pdf');
    }
}
