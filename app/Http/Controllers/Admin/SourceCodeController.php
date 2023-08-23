<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SourceCode;
use Illuminate\Http\Request;

class SourceCodeController extends Controller
{
    public function index()
    {
        $data = [
            'title'                     => 'Source Code List',
            'sourceCode'                => SourceCode::get(),
            'content'                   => 'admin/source-code/index'
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

        SourceCode::create($data);
        return redirect()->route('source-code.index')->with('message', 'Source Code Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = SourceCode::find($id);
        $data = $request->validate([
            'name'              => 'required|string|max:200'
        ]);

        $item->update($data);
        return redirect()->route('source-code.index')->with('message', 'Source Code Updated Successfully');
    }

    public function destroy(SourceCode $sourceCode)
    {
        try {
            $sourceCode->delete();
            return redirect()->back()->with('message', 'Source Code Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Deleted Failed, please check other page where using this source code');
        }
    }
}
