<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\CustomerPosService;
use Illuminate\Http\Request;

class CustomerPosServiceController extends Controller
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

        CustomerPosService::create($data);
        return redirect()->route('staff.index')->with('message', 'Customer Service POS Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = CustomerPosService::find($id);
        $data = $request->validate([
            'full_name' => 'required|string|max:200',
            'gender'    => 'required',
            'club'      => 'required'
        ]);

        $item->update($data);
        return redirect()->route('staff.index')->with('message', 'Customer Service POS Updated Successfully');
    }

    public function destroy(CustomerPosService $classInstructor)
    {
        $classInstructor->delete();
        return redirect()->back()->with('message', 'Customer Service POS Deleted Successfully');
    }
}
