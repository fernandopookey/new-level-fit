<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                'a.description',
                'a.photos',
                'b.full_name as user_full_name'
            )
            ->join('users as b', 'a.user_id', '=', 'b.id')
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
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'         => 'required',
            'phone_number'      => 'required',
            'nickname'          => 'nullable',
            'member_code'       => 'nullable',
            'gender'            => 'nullable',
            'born'              => 'nullable',
            'email'             => 'nullable',
            'ig'                => 'nullable',
            'emergency_contact' => 'nullable',
            'address'           => 'nullable',
            'description'       => 'nullable',
            'photos'            => 'mimes:png,jpg,jpeg|max:2048',
            'status'            => 'required'
        ]);


        $data['user_id'] = Auth::user()->id;
        $data['gender'] = $request->input('gender', 'Not Selected');

        if ($request->filled('member_code')) {
            $memberCode = $request->member_code;
            $existingRecord = Member::where('member_code', $memberCode)->first();

            if ($existingRecord) {
                return redirect()->back()->with('error', 'Code already exists');
            }
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
        Member::create($data);
        return redirect()->back()->with('message', 'Member Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = Member::find($id);
        $data = $request->validate([
            'full_name'         => 'nullable',
            'phone_number'      => 'nullable',
            'nickname'          => 'nullable',
            'member_code'       => 'nullable',
            'gender'            => 'nullable',
            'born'              => 'nullable',
            'email'             => 'nullable',
            'ig'                => 'nullable',
            'emergency_contact' => 'nullable',
            'address'           => 'nullable',
            'status'            => 'nullable',
            'description'       => 'nullable',
            'photos'            => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $data['user_id'] = Auth::user()->id;

        if (!isset($data['member_code'])) {
            $data['member_code'] = $item->member_code;
        } elseif ($data['member_code'] !== $item->member_code) {
            $member = $data['member_code'];
            $memberCode = $member;

            $existingRecord = Member::where('member_code', $memberCode)->first();
            if ($existingRecord && $existingRecord->id != $id) {
                return redirect()->back()->with('error', 'Code already exists');
            }
            $data['member_code'] = $memberCode;
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

        $item->update($data);
        return redirect()->route('members.index')->with('message', 'Member Updated Successfully');
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