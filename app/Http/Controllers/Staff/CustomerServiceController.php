<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\CustomerService;
use App\Models\User;
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
            'email'     => 'required|email',
            'gender'    => 'required',
            'role'      => '',
        ]);

        $data['password'] = bcrypt($request->password);

        User::create($data);
        return redirect()->route('staff.index')->with('message', 'Customer Service Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = User::find($id);
        $data = $request->validate([
            'full_name' => 'required|string|max:200',
            'email'     => 'email',
            'gender'    => 'required',
            'role'      => '',
        ]);

        $data['password'] = bcrypt($request->password);

        $item->update($data);
        return redirect()->route('staff.index')->with('message', 'Customer Service Updated Successfully');
    }

    public function destroy(CustomerService $customerService)
    {
        $customerService->delete();
        return redirect()->back()->with('message', 'Customer Service Deleted Successfully');
    }
}
