<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LockerTransactionStoreRequest;
use App\Http\Requests\LockerTransactionUpdateRequest;
use App\Models\LockerPackage;
use App\Models\LockerTransaction;
use App\Models\Member\Member;
use App\Models\Staff\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LockerTransactionController extends Controller
{
    public function index()
    {
        $data = [
            'title'                     => 'Locker Transaction List',
            'lockerTransaction'         => LockerTransaction::get(),
            'members'                   => Member::get(),
            'lockerPackage'             => LockerPackage::get(),
            'cs'                        => CustomerService::get(),
            'content'                   => 'admin/locker-transaction/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'             => 'New Locker Transaction',
            'content'           => 'admin/locker-transaction/create',
            'members'           => Member::get(),
            'cs'                => CustomerService::get(),
            'lockerTransaction' => LockerTransaction::all(),
            'lockerPackage'     => LockerPackage::get(),
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(LockerTransactionStoreRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();

        LockerTransaction::create($data);
        return redirect()->route('locker-transaction.index')->with('message', 'Locker Transaction Added Successfully');
    }

    public function edit(string $id)
    {
        $data = [
            'title'             => 'Edit Locker Transaction',
            'lockerTransaction' => LockerTransaction::find($id),
            'members'           => Member::get(),
            'cs'                => CustomerService::get(),
            'lockerPackage'     => LockerPackage::get(),
            'content'           => 'admin/locker-transaction/edit'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function update(LockerTransactionUpdateRequest $request, string $id)
    {
        $item = LockerTransaction::find($id);
        $data = $request->all();

        $item->update($data);
        return redirect()->route('locker-transaction.index')->with('message', 'Locker Transaction Updated Successfully');
    }

    public function destroy(LockerTransaction $lockerTransaction)
    {
        $lockerTransaction->delete();
        return redirect()->back()->with('message', 'Locker Transaction Deleted Successfully');
    }
}
