<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerPackageStoreRequest;
use App\Http\Requests\TrainerPackageUpdateRequest;
use App\Models\Trainer\TrainerPackage;
use App\Models\Trainer\TrainerPackageType;
use Illuminate\Http\Request;

class TrainerPackageController extends Controller
{
    public function index()
    {
        $data = [
            'title'                     => 'Trainer Package List',
            'trainerPackage'             => TrainerPackage::get(),
            'trainerPackageType'         => TrainerPackageType::get(),
            'content'                   => 'admin/trainer-package/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        //
    }

    public function store(TrainerPackageStoreRequest $request)
    {
        $data = $request->all();

        TrainerPackage::create($data);
        return redirect()->route('trainer-package.index')->with('message', 'Trainer Package Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(TrainerPackageUpdateRequest $request, string $id)
    {
        $item = TrainerPackage::find($id);
        $data = $request->all();

        $item->update($data);
        return redirect()->route('trainer-package.index')->with('message', 'Trainer Package Updated Successfully');
    }

    public function destroy(TrainerPackage $trainerPackage)
    {
        $trainerPackage->delete();
        return redirect()->back()->with('message', 'Trainer Package Deleted Successfully');
    }
}
