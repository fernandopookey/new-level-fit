<?php

namespace App\Http\Controllers\Member;

use App\Exports\MemberRegistrationExport;
use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\Member\MemberPackage;
use App\Models\Member\MemberRegistration;
use App\Models\MethodPayment;
use App\Models\SourceCode;
use App\Models\Staff\FitnessConsultant;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class MemberRegistrationController extends Controller
{
    public function index()
    {
        $memberRegistrations = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days as member_registration_days',
                'a.old_days',
                'a.package_price as mr_package_price',
                'a.admin_price as mr_admin_price',
                'b.full_name as member_name',
                'b.member_code',
                'b.phone_number',
                'b.born',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.days',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name',
                'g.full_name as fc_name',
                'g.phone_number as fc_phone_number',
                'h.check_in_time',
                'h.check_out_time'
            )
            ->addSelect(
                DB::raw("'bg-dark' as birthdayCelebrating"), //0 tidak ultah, 3 hari lagi ultah, 2 hari lagi, 1 hari lagi
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status'),
                // DB::raw('CONCAT(YEAR(CURDATE()), "-", MONTH(b.born), "-", DAY(b.born)) as member_birthday')
                DB::raw('CONCAT(YEAR(CURDATE()), "-", MONTH(b.born), "-", DAY(b.born)) as member_birthday'),
                DB::raw('DATEDIFF(CONCAT(YEAR(CURDATE()), "-", MONTH(b.born), "-", DAY(b.born)), CURDATE()) as days_until_birthday') // tambahkan ini untuk mendapatkan jumlah hari sampai ulang tahun
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
            ->leftJoin(DB::raw('(select * from (select a.* from (select * from check_in_members) as a inner join (SELECT max(id) as id FROM check_in_members group by member_registration_id) as b on a.id=b.id) as tableH) as h'), 'a.id', '=', 'h.member_registration_id')
            ->whereRaw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END = ?', ['Running'])
            ->orderBy('h.check_in_time', 'desc')
            ->orderBy('h.check_out_time', 'desc')
            ->get();


        $birthdayMessage3 = "";
        $birthdayMessage2 = "";
        $birthdayMessage1 = "";
        $birthdayMessage0 = "";

        foreach ($memberRegistrations as $memberRegistration) {
            if (BirthdayDiff($memberRegistration->born) == 0) {
                $memberRegistration->birthdayCelebrating = "bg-warning";
                $birthdayMessage0 = $birthdayMessage0 . $memberRegistration->member_name . '';
            } else if (BirthdayDiff($memberRegistration->born) == 1) {
                $memberRegistration->birthdayCelebrating = "bg-primary";
                $birthdayMessage1 = $birthdayMessage1 . $memberRegistration->member_name . '';
            } else if (BirthdayDiff($memberRegistration->born) == 2) {
                $memberRegistration->birthdayCelebrating = "bg-warning";
                $birthdayMessage2 = $birthdayMessage2 . $memberRegistration->member_name . '';
            }
        }

        $data = [
            'title'                 => 'Member Active List',
            'memberRegistrations'   => $memberRegistrations,
            'content'               => 'admin/member-registration/index',
            'birthdayMessage3'       => $birthdayMessage3,
            'birthdayMessage2'       => $birthdayMessage2,
            'birthdayMessage1'       => $birthdayMessage1,
            'birthdayMessage0'       => $birthdayMessage0,
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
            'content'               => 'admin/member-registration/create-page',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function memberSecondStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'full_name'             => 'required',
                'phone_number'          => 'required',
                'status'                => 'required',
                'nickname'              => 'nullable',
                'born'                  => 'nullable',
                'email'                 => 'nullable',
                'ig'                    => 'nullable',
                'emergency_contact'     => 'nullable',
                'gender'                => 'nullable',
                'address'               => 'nullable',
                'photos'                => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                // 'member_package_id'     => 'required_if:status,sell|exists:member_packages,id',
                'start_date'            => 'required_if:status,sell',
                'start_time'            => 'required_if:status,sell',
                // 'method_payment_id'     => 'required_if:status,sell|exists:method_payments,id',
                // 'fc_id'                 => 'required_if:status,sell|exists:fitness_consultants,id',
                'description'           => 'nullable',
                'member_code' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        if ($value) {
                            $exists = Member::where('member_code', $value)->exists();
                            if ($exists) {
                                $fail('The member code has already been taken.');
                            }
                        }
                    }
                ],
            ]);

            if ($request->status == 'sell') {

                $data += $request->validate([
                    'member_package_id'     => 'required|exists:member_packages,id',
                    'start_date'            => 'required',
                    'start_time'            => 'required',
                    'method_payment_id'     => 'required|exists:method_payments,id',
                    'fc_id'                 => 'required|exists:fitness_consultants,id',
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

                $data['born'] = Carbon::parse($data['born'])->format('Y-m-d');

                $package = MemberPackage::findOrFail($data['member_package_id']);
                $data['package_price'] = $package->package_price;

                $data['user_id'] = Auth::user()->id;

                $data['start_date'] =  $data['start_date'] . ' ' .  $data['start_time'];
                $dateTime = new \DateTime($data['start_date']);
                $data['start_date'] = $dateTime->format('Y-m-d H:i:s');
                unset($data['start_time']);

                $data['admin_price'] = $package->admin_price;
                $data['days'] = $package->days;

                $newMember = Member::create(array_intersect_key($data, array_flip([
                    'full_name', 'phone_number', 'status', 'nickname',
                    'born', 'member_code', 'email', 'ig', 'emergency_contact', 'gender', 'address', 'photos'
                ])));

                $data['member_id'] = $newMember->id;

                MemberRegistration::create(array_intersect_key($data, array_flip([
                    'member_id', 'member_package_id', 'start_date',
                    'method_payment_id', 'fc_id', 'user_id', 'description', 'package_price', 'admin_price', 'days'
                ])));
            } else {
                // $data['member_package_id'] = null;
                // $data['method_payment_id'] = null;
                // $data['fc_id'] = null;
                $newMember = Member::create(array_intersect_key($data, array_flip([
                    'full_name', 'phone_number', 'status'
                ])));
            }

            DB::commit();

            return redirect()->back()->with('success', 'Member Registration Added Successfully');
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    // public function memberSecondStore(Request $request)
    // {
    //     $data = $request->validate(
    //         [
    //             'member_id'             => 'required|exists:members,id',
    //             'member_package_id'     => 'required|exists:member_packages,id',
    //             'start_date'            => 'required',
    //             'start_time'            => 'required',
    //             'method_payment_id'     => 'required|exists:method_payments,id',
    //             'refferal_id'           => 'nullable',
    //             'description'           => 'nullable',
    //             'user_id'               => 'nullable',
    //             'fc_id'                      => 'required|exists:fitness_consultants,id',
    //             'member_code'           => [
    //                 '',
    //                 Rule::exists('members', 'member_code')->where(function ($query) use ($request) {
    //                     $query->where('member_code', $request->member_code);
    //                 }),
    //             ],
    //         ],
    //         [
    //             'member_code.exists' => 'Member code doesn\'t exist. Please input a valid member code.',
    //         ]
    //     );

    //     $package = MemberPackage::findOrFail($data['member_package_id']);
    //     $data['user_id'] = Auth::user()->id;
    //     $data['package_price'] = $package->package_price;

    //     $data['start_date'] =  $data['start_date'] . ' ' .  $data['start_time'];
    //     $dateTime = new \DateTime($data['start_date']);
    //     $data['start_date'] = $dateTime->format('Y-m-d H:i:s');
    //     unset($data['start_time']);

    //     $data['admin_price'] = $package->admin_price;
    //     $data['days'] = $package->days;

    //     MemberRegistration::create($data);
    //     return redirect()->back()->with('message', 'Member Registration Added Successfully');
    // }

    public function show($id)
    {
        $query = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days as member_registration_days',
                'a.old_days',
                'a.package_price as mr_package_price',
                'a.admin_price as mr_admin_price',
                'b.full_name as member_name',
                'b.address',
                'b.member_code',
                'b.phone_number',
                'b.photos',
                'b.gender',
                'b.nickname',
                'b.ig',
                'b.emergency_contact',
                'b.email',
                'b.born',
                'c.package_name',
                'c.days',
                'c.package_price',
                'e.name as method_payment_name',
                'f.full_name as staff_name',
                'g.full_name as fc_name',
                'g.phone_number as fc_phone_number',
                'h.check_in_time',
                'h.check_out_time'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->join('fitness_consultants as g', 'a.fc_id', '=', 'g.id')
            ->leftJoin(DB::raw('(select * from (select a.* from (select * from check_in_members) as a inner join (SELECT max(id) as id FROM check_in_members group by member_registration_id) as b on a.id=b.id) as tableH) as h'), 'a.id', '=', 'h.member_registration_id')
            ->where('a.id', $id)
            ->get();

        $checkInMemberRegistration = MemberRegistration::find($id);

        $data = [
            'title'                     => 'Detail Member Registration',
            'memberRegistration'        => $query->first(),
            'memberRegistrationCheckIn' => $checkInMemberRegistration->memberRegistrationCheckIn,
            'memberLastCode'            => Member::latest('id')->first(),
            'content'                   => 'admin/member-registration/show',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function edit(string $id)
    {
        $data = [
            'title'                 => 'Edit Member Registration',
            'memberRegistration'    => MemberRegistration::find($id),
            'members'               => Member::get(),
            'memberLastCode'        => Member::latest('id')->first(),
            'memberPackage'         => MemberPackage::get(),
            'methodPayment'         => MethodPayment::get(),
            'fitnessConsultant'     => FitnessConsultant::get(),
            'referralName'          => FitnessConsultant::get(),
            'content'               => 'admin/member-registration/edit-page',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function renewal(string $id)
    {
        $data = [
            'title'                 => 'Renewal Member Active',
            'memberRegistration'    => MemberRegistration::find($id),
            'members'               => Member::get(),
            'memberLastCode'        => Member::latest('id')->first(),
            'memberPackage'         => MemberPackage::get(),
            'methodPayment'         => MethodPayment::get(),
            'fitnessConsultant'     => FitnessConsultant::get(),
            'content'               => 'admin/member-registration/renewal',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function renewMemberRegistration(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $memberRegistration = MemberRegistration::findOrFail($id);

            $data = $request->validate([
                'member_package_id' => 'required|exists:member_packages,id',
                'start_date'        => 'required',
                'method_payment_id' => 'required|exists:method_payments,id',
                'fc_id'             => 'required|exists:fitness_consultants,id',
                'start_time'        => 'required',
                'description'       => 'nullable',
            ]);

            $package = MemberPackage::findOrFail($data['member_package_id']);
            $data['package_price'] = $package->package_price;

            $data['user_id'] = Auth::user()->id;

            $data['start_date'] =  $data['start_date'] . ' ' .  $data['start_time'];
            $dateTime = new \DateTime($data['start_date']);
            $data['start_date'] = $dateTime->format('Y-m-d H:i:s');
            unset($data['start_time']);

            $data['admin_price'] = $package->admin_price;
            $data['days'] = $package->days;


            $data['member_id'] = $memberRegistration->member_id;

            MemberRegistration::create($data);

            DB::commit();

            return redirect()->route('member-active.index')->with('success', 'Renewal Successfully');
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
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
        $dateTime = new \DateTime($data['start_date']);
        $data['start_date'] = $dateTime->format('Y-m-d H:i:s');
        unset($data['start_time']);

        $item->update($data);

        return redirect()->route('member-active.index')->with('message', 'Member Updated Successfully');
    }

    public function freeze(Request $request, string $id)
    {
        $item = MemberRegistration::find($id);
        // dd($item->days);
        $data = $request->validate([
            'expired_date'  => 'required',
            'start_date'    => 'required'
        ]);
        $data['user_id'] = Auth::user()->id;
        // $data['days'] =  DateDiff($data['start_date'], $data['expired_date']);

        $data['days'] =  $item->days + $data['expired_date'];

        $data['old_days'] = $item->memberPackage->days;
        $data['submission_date'] = Carbon::now()->tz('Asia/Jakarta');

        $item->update($data);

        unset($data['expired_date']);
        unset($data['old_expired_date']);
        $item->update($data);
        return redirect()->route('member-active.index')->with('message', 'Cuti Membership Successfully Added');
    }

    public function destroy($id)
    {
        $memberRegistration = MemberRegistration::find($id);

        try {
            $memberRegistration->delete();
            return redirect()->back()->with('success', $memberRegistration->members->full_name . 'member package delete successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('errorr', 'Deleted Failed, Delete Member Check In First');
        }
    }

    public function agreement($id)
    {
        $memberRegistration = DB::table('member_registrations as a')
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
                'b.nickname',
                'b.phone_number',
                'b.born',
                'b.photos',
                'b.gender',
                'b.emergency_contact',
                'b.email',
                'b.ig',
                'b.address',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name',
                'g.full_name as fc_name',
                'g.phone_number as fc_phone_number'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL c.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status'),
                DB::raw('CONCAT(YEAR(CURDATE()), "-", MONTH(b.born), "-", DAY(b.born)) as member_birthday')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->join('fitness_consultants as g', 'a.fc_id', '=', 'g.id')
            ->where('a.id', $id)
            ->first();

        $fileName1 = $memberRegistration->member_name;
        $fileName2 = $memberRegistration->start_date;

        $pdf = Pdf::loadView('admin/member-registration/agreement', [
            'memberRegistration'        => $memberRegistration,
        ]);
        return $pdf->stream('Membership Agreement-' . $fileName1 . '-' . $fileName2 . '.pdf');
    }

    public function cuti($id)
    {
        $memberRegistration = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.package_price as mr_package_price',
                'a.admin_price as mr_admin_price',
                'a.days as member_registration_days',
                'a.old_days',
                'a.updated_at',
                'a.created_at',
                'a.submission_date',
                'b.full_name as member_name', // alias for members table name column
                'c.package_name',
                'c.days',
                'b.member_code',
                'b.nickname',
                'b.phone_number',
                'b.born',
                'b.photos',
                'b.gender',
                'b.emergency_contact',
                'b.email',
                'b.ig',
                'b.address',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name',
                'g.full_name as fc_name',
                'g.phone_number as fc_phone_number'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as status'),
                DB::raw('CONCAT(YEAR(CURDATE()), "-", MONTH(b.born), "-", DAY(b.born)) as member_birthday')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->join('fitness_consultants as g', 'a.fc_id', '=', 'g.id')
            ->where('a.id', $id)
            ->first();

        $fileName1 = $memberRegistration->member_name;
        $fileName2 = $memberRegistration->start_date;

        $pdf = Pdf::loadView('admin/member-registration/cuti', [
            'memberRegistration'        => $memberRegistration,
        ]);
        return $pdf->stream('Cuti Membership-' . $fileName1 . '-' . $fileName2 . '.pdf');
    }

    public function filter(Request $request)
    {
        $query = DB::table('member_registrations as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days as member_registration_days',
                'a.old_days',
                'a.package_price as mr_package_price',
                'a.admin_price as mr_admin_price',
                'b.full_name as member_name',
                'c.package_name',
                'c.days',
                'b.member_code',
                'b.phone_number',
                'b.born',
                'b.photos',
                'b.gender',
                'c.package_name',
                'c.package_price',
                'c.days',
                'e.name as method_payment_name',
                'f.full_name as staff_name',
                'g.full_name as fc_name',
                'g.phone_number as fc_phone_number',
                'h.check_in_time',
                'h.check_out_time'
            )
            ->addSelect(
                DB::raw("'bg-dark' as birthdayCelebrating"),
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END as status'),
                DB::raw('CONCAT(YEAR(CURDATE()), "-", MONTH(b.born), "-", DAY(b.born)) as member_birthday'),
                DB::raw('DATEDIFF(CONCAT(YEAR(CURDATE()), "-", MONTH(b.born), "-", DAY(b.born)), CURDATE()) as days_until_birthday')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('member_packages as c', 'a.member_package_id', '=', 'c.id')
            ->join('method_payments as e', 'a.method_payment_id', '=', 'e.id')
            ->join('users as f', 'a.user_id', '=', 'f.id')
            ->join('fitness_consultants as g', 'a.fc_id', '=', 'g.id')
            ->leftJoin(DB::raw('(select * from (select a.* from (select * from check_in_members) as a inner join (SELECT max(id) as id FROM check_in_members group by member_registration_id) as b on a.id=b.id) as tableH) as h'), 'a.id', '=', 'h.member_registration_id')
            ->whereRaw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL c.days DAY) THEN "Over" ELSE "Running" END = ?', ['Running'])
            ->orderBy('h.check_in_time', 'desc');

        if ($request->fromDate && $request->toDate) {
            $query->whereBetween('a.created_at', [$request->fromDate, $request->toDate]);
        }

        // Paginate the results
        $memberRegistrations = $query->paginate(10);

        $data = [
            'memberRegistrations'   => $memberRegistrations,
            'request'               => $request,
            'content'               => 'admin/member-registration/filter'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function excel()
    {
        return Excel::download(new MemberRegistrationExport(), 'member-active.xlsx');
    }
}
