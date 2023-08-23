<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferPackageStoreRequest;
use App\Http\Requests\TransferPackageUpdateRequest;
use App\Models\TransferPackage;
use Illuminate\Http\Request;

class TransferPackageController extends Controller
{
    public function index()
    {
        $data = [
            'title'                     => 'Transfer Package List',
            'transferPackage'           => TransferPackage::get(),
            'content'                   => 'admin/transfer-package/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        //
    }

    public function store(TransferPackageStoreRequest $request)
    {
        $data = $request->all();

        TransferPackage::create($data);
        return redirect()->route('transfer-package.index')->with('message', 'Transfer Package Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(TransferPackageUpdateRequest $request, string $id)
    {
        $item = TransferPackage::find($id);
        $data = $request->all();

        $item->update($data);
        return redirect()->route('transfer-package.index')->with('message', 'Transfer Package Updated Successfully');
    }

    public function destroy(TransferPackage $transferPackage)
    {
        try {
            $transferPackage->delete();
            return redirect()->back()->with('message', 'Transfer Package Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Deleted Failed, please check other page where using this transfer package');
        }
    }
}
