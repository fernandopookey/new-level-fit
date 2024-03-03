<?php

namespace App\Http\Controllers\Member;

use App\Exports\MemberExport;
use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\Member\MemberPackage;
use App\Models\Member\MemberRegistration;
use App\Models\MethodPayment;
use App\Models\Staff\FitnessConsultant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    public function index()
    {
        $sell = DB::table('members as a')
            ->select(
                'a.id',
                'a.full_name',
                'a.nickname',
                'a.member_code',
                'a.gender',
                'a.born',
                'a.phone_number',
                'a.email',
                'a.ig',
                'a.emergency_contact',
                'a.address',
                'a.status',
                'a.photos',
            )
            ->where('a.status', '=', 'sell')
            ->get();

        $data = [
            'title'             => 'Member List',
            'members'           => $sell,
            // 'users'             => User::get(),
            'memberLastCode'    => Member::latest('id')->first(),
            'content'           => 'admin/members/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        return Excel::download(new MemberExport(), 'member.xlsx');
    }

    public function store(Request $request)
    {
        // $data = $request->validate([
        //     'full_name'         => 'required',
        //     'phone_number'      => 'required',
        //     'nickname'          => 'nullable',
        //     'member_code'       => 'nullable',
        //     'gender'            => 'nullable',
        //     'born'              => 'nullable',
        //     'email'             => 'nullable',
        //     'ig'                => 'nullable',
        //     'emergency_contact' => 'nullable',
        //     'address'           => 'nullable',
        //     'description'       => 'nullable',
        //     'photos'            => 'mimes:png,jpg,jpeg|max:2048',
        //     'status'            => 'required'
        // ]);


        // $data['user_id'] = Auth::user()->id;
        // $data['gender'] = $request->input('gender', 'Not Selected');
        // $data['born'] = Carbon::parse($data['born'])->format('Y-m-d');

        // if ($request->filled('member_code')) {
        //     $memberCode = $request->member_code;
        //     $existingRecord = Member::where('member_code', $memberCode)->first();

        //     if ($existingRecord) {
        //         return redirect()->back()->with('error', 'Code already exists');
        //     }
        // }

        // if ($request->hasFile('photos')) {

        //     if ($request->photos != null) {
        //         $realLocation = "storage/" . $request->photos;
        //         if (file_exists($realLocation) && !is_dir($realLocation)) {
        //             unlink($realLocation);
        //         }
        //     }

        //     $photos = $request->file('photos');
        //     $file_name = time() . '-' . $photos->getClientOriginalName();

        //     $data['photos'] = $request->file('photos')->store('assets/member', 'public');
        // } else {
        //     $data['photos'] = $request->photos;
        // }
        // Member::create($data);
        // return redirect()->back()->with('message', 'Member Added Successfully');
    }

    public function edit(string $id)
    {
        $data = [
            'title'                 => 'Edit Member',
            // 'memberRegistration'    => MemberRegistration::find($id),
            'members'               => Member::find($id),
            'memberLastCode'        => Member::latest('id')->first(),
            'memberPackage'         => MemberPackage::get(),
            'methodPayment'         => MethodPayment::get(),
            'fitnessConsultant'     => FitnessConsultant::get(),
            'content'               => 'admin/members/edit',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $member = Member::findOrFail($id); // Menemukan anggota yang ingin diperbarui

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
                'member_package_id'     => 'required|exists:member_packages,id',
                'start_date'            => 'required',
                'start_time'            => 'required',
                'method_payment_id'     => 'required|exists:method_payments,id',
                'fc_id'                 => 'required|exists:fitness_consultants,id',
                'description'           => 'nullable',
                'member_code' => [
                    'nullable',
                    function ($attribute, $value, $fail) use ($id) {
                        if ($value) {
                            $exists = Member::where('member_code', $value)->where('id', '!=', $id)->exists();
                            if ($exists) {
                                $fail('The member code has already been taken.');
                            }
                        }
                    }
                ],
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

            // Perbarui data anggota
            $member->update(array_intersect_key($data, array_flip([
                'full_name', 'phone_number', 'status', 'nickname',
                'born', 'member_code', 'email', 'ig', 'emergency_contact', 'gender', 'address', 'photos'
            ])));

            // Buat atau perbarui data pendaftaran anggota
            $registrationData = array_intersect_key($data, array_flip([
                'member_package_id', 'start_date',
                'method_payment_id', 'fc_id', 'user_id', 'description', 'package_price', 'admin_price', 'days'
            ]));
            if ($member->registration) {
                $member->registration->update($registrationData);
            } else {
                MemberRegistration::create(array_merge(['member_id' => $member->id], $registrationData));
            }

            DB::commit();

            return redirect()->back()->with('success', 'Member Registration Updated Successfully');
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    // public function update(Request $request, string $id)
    // {
    //     $item = Member::find($id);
    //     $data = $request->validate([
    //         'full_name'         => 'nullable',
    //         'phone_number'      => 'nullable',
    //         'nickname'          => 'nullable',
    //         'member_code'       => 'nullable',
    //         'gender'            => 'nullable',
    //         'born'              => 'nullable',
    //         'email'             => 'nullable',
    //         'ig'                => 'nullable',
    //         'emergency_contact' => 'nullable',
    //         'address'           => 'nullable',
    //         'status'            => 'nullable',
    //         'description'       => 'nullable',
    //         'photos'            => 'mimes:png,jpg,jpeg|max:2048'
    //     ]);

    //     $data['user_id'] = Auth::user()->id;

    //     if (!isset($data['member_code'])) {
    //         $data['member_code'] = $item->member_code;
    //     } elseif ($data['member_code'] !== $item->member_code) {
    //         $member = $data['member_code'];
    //         $memberCode = $member;

    //         $existingRecord = Member::where('member_code', $memberCode)->first();
    //         if ($existingRecord && $existingRecord->id != $id) {
    //             return redirect()->back()->with('error', 'Code already exists');
    //         }
    //         $data['member_code'] = $memberCode;
    //     }

    //     if ($request->hasFile('photos')) {

    //         if ($request->photos != null) {
    //             $realLocation = "storage/" . $request->photos;
    //             if (file_exists($realLocation) && !is_dir($realLocation)) {
    //                 unlink($realLocation);
    //             }
    //         }

    //         $photos = $request->file('photos');
    //         $file_name = time() . '-' . $photos->getClientOriginalName();

    //         $data['photos'] = $request->file('photos')->store('assets/member', 'public');
    //     } else {
    //         $data['photos'] = $request->photos;
    //     }

    //     $item->update($data);
    //     return redirect()->route('members.index')->with('message', 'Member Updated Successfully');
    // }

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

    public function bulkDelete(Request $request)
    {
        $selectedItems = $request->input('selected_members');

        try {
            foreach ($selectedItems as $itemId) {
                $member = Member::find($itemId);

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

            return redirect()->back()->with('message', 'Members Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Members Deleted Failed, Please check other pages that are using this member');
        }
    }

    public function cetak_pdf()
    {
        $members    = Member::orderBy('full_name')->get();
        $users = User::get();

        $pdf = Pdf::loadView('admin/members/member-report', [
            'members'   => $members,
            'users'     => $users,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('member-report.pdf');
    }
}
