<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index()
    {
        $data = [
            'title'     => 'Studio List',
            'studio'    => Studio::get(),
            'content'   => 'admin/studio/index'
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
            'name' => 'required|string|max:200'
        ]);

        Studio::create($data);
        return redirect()->route('studio.index')->with('message', 'Studio Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = Studio::find($id);
        $data = $request->validate([
            'name' => 'required|string|max:200'
        ]);

        $item->update($data);
        return redirect()->route('studio.index')->with('message', 'Studio Updated Successfully');
    }

    public function destroy(Studio $studio)
    {
        try {
            $studio->delete();
            return redirect()->back()->with('message', 'Studio Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Deleted Failed, please check other page where using this studio');
        }
    }
}
