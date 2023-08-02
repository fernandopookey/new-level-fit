<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\CustomerService;
use Illuminate\Http\Request;

class CustomerServiceController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:200',
            'gender'    => 'required',
            'club'      => 'required'
        ]);

        CustomerService::create($data);
        return redirect()->route('staff.index')->with('message', 'Customer Service Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = CustomerService::find($id);
        $data = $request->validate([
            'full_name' => 'required|string|max:200',
            'gender'    => 'required',
            'club'      => 'required'
        ]);

        $item->update($data);
        return redirect()->route('staff.index')->with('message', 'Customer Service Updated Successfully');
    }

    public function destroy(CustomerService $customerService)
    {
        $customerService->delete();
        return redirect()->back()->with('message', 'Customer Service Deleted Successfully');
    }
}
