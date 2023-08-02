<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Trainer\TrainerPackageType;
use Illuminate\Http\Request;

class TrainerPackageTypeController extends Controller
{
    public function index()
    {
        $data = [
            'title'                 => 'Trainer Package Type List',
            'trainerPackageType'    => TrainerPackageType::get(),
            'content'               => 'admin/trainer-package-type/index'
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
            'package_type_name'      => 'required'
        ]);

        TrainerPackageType::create($data);
        return redirect()->route('trainer-package-type.index')->with('message', 'Trainer Package Type Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = TrainerPackageType::find($id);
        $data = $request->validate([
            'package_type_name'      => 'required'
        ]);

        $item->update($data);
        return redirect()->route('trainer-package-type.index')->with('message', 'Trainer Package Type Updated Successfully');
    }

    public function destroy(TrainerPackageType $trainerPackageType)
    {
        $trainerPackageType->delete();
        return redirect()->back()->with('message', 'Trainer Package Type Deleted Successfully');
    }
}
