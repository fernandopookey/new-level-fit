<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberPackageStoreRequest;
use App\Http\Requests\MemberPackageUpdateRequest;
use App\Models\Member\MemberPackage;
use App\Models\Member\MemberPackageCategory;
use App\Models\Member\MemberPackageType;
use Illuminate\Http\Request;

class MemberPackageController extends Controller
{
    public function index()
    {
        $data = [
            'title'                     => 'Member Package List',
            'memberPackage'             => MemberPackage::get(),
            'memberPackageType'         => MemberPackageType::get(),
            'memberPackageCategories'   => MemberPackageCategory::get(),
            'content'                   => 'admin/member-package/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        //
    }

    public function store(MemberPackageStoreRequest $request)
    {
        $data = $request->all();

        MemberPackage::create($data);
        return redirect()->route('member-package.index')->with('message', 'Member Package Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(MemberPackageUpdateRequest $request, string $id)
    {
        $item = MemberPackage::find($id);
        $data = $request->all();

        $item->update($data);
        return redirect()->route('member-package.index')->with('message', 'Member Package Updated Successfully');
    }

    public function destroy(MemberPackage $memberPackage)
    {
        $memberPackage->delete();
        return redirect()->back()->with('message', 'Member Package Deleted Successfully');
    }
}
