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
            'title'     => 'Refferal List',
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
        return redirect()->route('refferal.index')->with('message', 'Refferal Added Successfully');
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
        return redirect()->route('refferal.index')->with('message', 'Refferal Updated Successfully');
    }

    public function destroy(Refferal $refferal)
    {
        $refferal->delete();
        return redirect()->back()->with('message', 'Refferal Deleted Successfully');
    }
}
