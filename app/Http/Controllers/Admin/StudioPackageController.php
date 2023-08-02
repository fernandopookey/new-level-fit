<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudioPackage;
use Illuminate\Http\Request;

class StudioPackageController extends Controller
{
    public function index()
    {
        $data = [
            'title'                     => 'Studio Package List',
            'studioPackage'             => StudioPackage::get(),
            'content'                   => 'admin/studio-package/index'
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
            'name'  => 'required'
        ]);

        StudioPackage::create($data);
        return redirect()->route('studio-package.index')->with('message', 'Studio Package Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = StudioPackage::find($id);
        $data = $request->all();

        $item->update($data);
        return redirect()->route('studio-package.index')->with('message', 'Studio Package Updated Successfully');
    }

    public function destroy(StudioPackage $studioPackage)
    {
        $studioPackage->delete();
        return redirect()->back()->with('message', 'Studio Package Deleted Successfully');
    }
}
