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
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $data = [
            'title'             => 'Member List',
            'members'           => Member::get(),
            'memberLastCode'    => Member::latest('id')->first(),
            'sourceCode'        => SourceCode::get(),
            'memberPackage'     => MemberPackage::get(),
            'methodPayment'     => MethodPayment::get(),
            'soldBy'            => Sold::get(),
            'refferalName'      => Refferal::get(),
            'content'           => 'admin/member/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'                     => 'New Trainer',
            'members'           => Member::get(),
            'memberLastCode'    => Member::latest('id')->first(),
            'sourceCode'        => SourceCode::get(),
            'memberPackage'     => MemberPackage::get(),
            'methodPayment'     => MethodPayment::get(),
            'soldBy'            => Sold::get(),
            'refferalName'      => Refferal::get(),
            'content'           => 'admin/member/create-page',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'            => 'required',
            'gender'                => 'required',
            'phone_number'          => 'required',
            'source_code_id'        => 'required|exists:source_codes,id',
            'member_package_id'     => 'required|exists:member_packages,id',
            'expired_date'          => '',
            'method_payment_id'     => 'required|exists:method_payments,id',
            'sold_by_id'            => 'required|exists:solds,id',
            'refferal_id'           => 'required|exists:refferals,id',
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
        $data = $request->validate([
            'full_name'            => 'required',
            'gender'                => 'required',
            'phone_number'          => 'required',
            'source_code_id'        => 'required|exists:source_codes,id',
            'member_package_id'     => 'required|exists:member_packages,id',
            'expired_date'          => '',
            'method_payment_id'     => 'required|exists:method_payments,id',
            'sold_by_id'            => 'required|exists:solds,id',
            'refferal_id'           => 'required|exists:refferals,id',
            'status'                => 'required',
            'description'           => '',
            'photos'                => 'mimes:png,jpg,jpeg|max:2048'
        ]);

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
        // 
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
            'expired_date'          => '',
            'method_payment_id'     => 'exists:method_payments,id',
            'sold_by_id'            => 'exists:solds,id',
            'refferal_id'           => 'exists:refferals,id',
            'status'                => '',
            'description'           => '',
            'photos'                => 'nullable|mimes:png,jpg,jpeg'
        ]);

        if ($request->hasFile('photos')) {

            if ($item->photos != null) {
                $realLocation = "storage/" . $item->photos;
                if (file_exists($realLocation) && !is_dir($realLocation)) {
                    unlink($realLocation);
                }
            }

            $photos = $request->file('photos');
            $file_name = time() . '-' . $photos->getClientOriginalName();

            $data['photos'] = $request->file('photos')->store('assets/member', 'public');
        } else {
            $data['photos'] = $item->photos;
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
            return redirect()->back()->with('error', 'Trainer Deleted Failed, please check other session where using this trainer');
        }


        // try {
        //     $member->delete();
        //     return redirect()->back()->with('message', 'Member Deleted Successfully');
        // } catch (\Throwable $th) {
        //     return redirect()->back()->with('error', 'Trainer Deleted Failed, please check other session where using this trainer');
        // }
    }
}
