<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudioTransactionStoreRequest;
use App\Models\StudioPackage;
use App\Models\StudioTransaction;
use Illuminate\Http\Request;

class StudioTransactionController extends Controller
{
    public function index()
    {
        $data = [
            'title'             => 'Studio Transaction List',
            'studioTransaction' => StudioTransaction::get(),
            'studioPackage'     => StudioPackage::get(),
            'content'           => 'admin/studio-transaction/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'             => 'New Studio Transaction',
            'content'           => 'admin/studio-transaction/create',
            'studioTransaction' => StudioTransaction::get(),
            'studioPackage'     => StudioPackage::get(),
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(StudioTransactionStoreRequest $request)
    {
        $data = $request->all();
        $data['booking_code'] = 'ST-' . mt_rand(00000, 99999) . '-BC';

        StudioTransaction::create($data);
        return redirect()->route('studio-transactions.index')->with('message', 'Studio Transaction Added Successfully');
    }

    public function edit(string $id)
    {
        $data = [
            'title'             => 'Edit Locker Transaction',
            'studioTransaction' => StudioTransaction::find($id),
            'studioPackage'     => StudioPackage::get(),
            'content'           => 'admin/studio-transaction/edit'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request, string $id)
    {
        $item = StudioTransaction::find($id);
        $data = $request->validate([
            'name'              => '',
            'booking_date'      => '',
            'booking_code'      => '',
            'phone_number'      => '',
            'studio_name'       => '',
            'package_id'        => 'exists:studio_packages,id',
            'role'              => '',
            'staff_name'        => '',
            'payment_status'    => '',
        ]);

        $item->update($data);
        return redirect()->route('studio-transactions.index')->with('message', 'Studio Transaction Updated Successfully');
    }

    public function destroy(StudioTransaction $studioTransaction)
    {
        $studioTransaction->delete();
        return redirect()->back()->with('message', 'Studio Transaction Deleted Successfully');
    }
}
