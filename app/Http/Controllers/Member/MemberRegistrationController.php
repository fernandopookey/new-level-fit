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
use Illuminate\Validation\Rule;


class MemberRegistrationController extends Controller
{
    public function index()
    {
        // $memberRegistrations = DB::table('member_registrations as a')
        //     ->select(
        //         'a.id',
        //         'a.start_date',
        //         'a.description',
        //         'a.package_price as mr_package_price',
        //         'a.admin_price as mr_admin_price',
        //         'b.full_name as member_name', // alias for members table name column
        //         'c.package_name',
        //         'c.days',
        //         'b.member_code',
        //         'b.phone_number',
        //         'b.photos',
        //         'b.gender',
        //         'c.package_name',
        //         'c.package_price',
        //         'c.days',
        //         'e.name as method_payment_name', // alias for method_payments table name column
        //         'f.full_name as staff_name', // alias for users table name column
        //     )
        //     ->addSelect(
        //         DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
        //         DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status')
        //     )
        //     ->join('members as b', 'a.member_id', '=', 'b.id')
        //     ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
        //     ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
        //     ->join('users as f', 'a.user_id', '=', 'f.id')
        //     ->whereRaw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END = ?', ['Running'])
        //     ->orderBy('status', 'desc')
        //     ->get();

        $memberRegistrations = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.package_price as mr_package_price',
                'a.admin_price as mr_admin_price',
                'a.days as member_registration_days',
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
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->whereRaw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END = ?', ['Running'])
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
                'start_date'            => 'required',
                'start_time'            => 'required',
                'method_payment_id'     => 'required|exists:method_payments,id',
                'refferal_id'           => 'nullable',
                'description'           => 'nullable',
                'user_id'               => 'nullable',
                'member_code'           => [
                    '',
                    Rule::exists('members', 'member_code')->where(function ($query) use ($request) {
                        $query->where('member_code', $request->member_code);
                    }),
                ],
            ],
            [
                'member_code.exists' => 'Member code doesn\'t exist. Please input a valid member code.',
            ]
        );

        $package = MemberPackage::findOrFail($data['member_package_id']);
        $data['user_id'] = Auth::user()->id;
        $data['package_price'] = $package->package_price;

        $data['start_date'] =  $data['start_date'] . ' ' .  $data['start_time'];
        $dateTime = new \DateTime($data['start_date']);
        $data['start_date'] = $dateTime->format('Y-m-d H:i:s');
        unset($data['start_time']);

        $data['admin_price'] = $package->admin_price;
        $data['days'] = $package->days;

        MemberRegistration::create($data);
        return redirect()->back()->with('message', 'Member Registration Added Successfully');
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
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as status')
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
            'start_date'        => 'nullable',
            'start_time'        => 'nullable',
            'description'       => 'nullable',
        ]);
        $data['user_id'] = Auth::user()->id;

        $package = MemberPackage::findOrFail($item->member_package_id);

        $data['package_price'] = $package->package_price;
        $data['admin_price'] = $package->admin_price;

        $data['start_date'] =  $data['start_date'] . ' ' .  $data['start_time'];
        unset($data['start_time']);

        $item->update($data);

        $status = DB::table('member_registrations as a')
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
            ->first();

        // dd($status);

        // if ($status['status'] = 'Over') {
        //     // Assuming you have a relationship between MemberRegistration and Member
        //     $member = $item->members;

        //     // Update the member_code to null
        //     $member->update(['member_code' => null]);
        // }

        // if (
        //     $status && $status->status === 'Over'
        // ) {
        //     // Assuming you have a relationship between MemberRegistration and Member
        //     $member = $item->members;

        //     // Update the member_code to null
        //     $member->update(['member_code' => null]);
        // }

        return redirect()->route('member-registration.index')->with('message', 'Member Updated Successfully');
    }

    public function freeze(Request $request, string $id)
    {
        $item = MemberRegistration::find($id);
        $data = $request->validate([
            'start_date'            => 'nullable',
            'description'           => 'nullable',
        ]);
        $data['user_id'] = Auth::user()->id;

        $package = MemberPackage::findOrFail($item->member_package_id);

        $data['package_price'] = $package->package_price;
        $data['admin_price'] = $package->admin_price;

        $item->update($data);

        $inputDays = $request->input('days_off');
        $sumDays = $item->days + $inputDays;

        $item->update(['days' => $sumDays]);

        $status = DB::table('member_registrations as a')
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

        if ($status['status'] = 'Over') {
            // Assuming you have a relationship between MemberRegistration and Member
            $member = $item->members;

            // Update the member_code to null
            $member->update(['member_code' => null]);
        }
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
            return redirect()->back()->with('message', 'Member Registration Deleted Successfully');
        } catch (\Throwable $e) {
            // Alert::error('Error', $e->getMessage());
            return redirect()->back()->with('error', 'Deleted Failed, Delete Member Check In First');
        }
    }

    public function deleteSelectedMembers(Request $request)
    {
        $selectedMembers = $request->input('selectedMembers', []);

        // Add your logic to delete the selected members from the database
        MemberRegistration::whereIn('id', $selectedMembers)->delete();

        // Redirect back or return a response as needed
        return redirect()->back()->with('message', 'Selected member registration deleted successfully');
    }

    public function cetak_pdf()
    {
        $memberRegistrations = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.package_price as mr_package_price',
                'a.admin_price as mr_admin_price',
                'a.days as member_registration_days',
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
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->whereRaw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END = ?', ['Running'])
            ->orderBy('status', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin/member-registration/member-registration-pdf', [
            'memberRegistrations'   => $memberRegistrations,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('member-registration-report.pdf');
    }
}
