<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sold;
use Illuminate\Http\Request;

class SoldByController extends Controller
{
    public function index()
    {
        $data = [
            'title'     => 'Sold By List',
            'soldBy'    => Sold::get(),
            'content'   => 'admin/sold-by/index'
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

        Sold::create($data);
        return redirect()->route('sold-by.index')->with('message', 'Sold By Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = Sold::find($id);
        $data = $request->validate([
            'name'              => 'required|string|max:200'
        ]);

        $item->update($data);
        return redirect()->route('sold-by.index')->with('message', 'Sold By Updated Successfully');
    }

    public function destroy(Sold $soldBy)
    {
        try {
            $soldBy->delete();
            return redirect()->back()->with('message', 'Sold By Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Deleted Failed, please check other page where using this sold');
        }
    }
}
