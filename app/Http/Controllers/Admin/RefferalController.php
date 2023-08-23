<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refferal;
use Illuminate\Http\Request;

class RefferalController extends Controller
{
    public function index()
    {
        $data = [
            'title'     => 'Referral List',
            'refferal'  => Refferal::get(),
            'content'   => 'admin/refferal/index'
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
            'name'  => 'required|string|max:200'
        ]);

        Refferal::create($data);
        return redirect()->route('referral.index')->with('message', 'Referral Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = Refferal::find($id);
        $data = $request->validate([
            'name'              => 'required|string|max:200'
        ]);

        $item->update($data);
        return redirect()->route('referral.index')->with('message', 'Referral Updated Successfully');
    }

    public function destroy($id)
    {
        try {
            $referral = Refferal::find($id);
            $referral->delete();
            return redirect()->back()->with('message', 'Referral Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Referral Deleted Failed, please check other session where using this referral');
        }
    }
}
