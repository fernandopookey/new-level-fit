<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\FitnessConsultant;
use Illuminate\Http\Request;

class FitnessConsultantController extends Controller
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

        FitnessConsultant::create($data);
        return redirect()->route('staff.index')->with('message', 'Fitness Consultant Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = FitnessConsultant::find($id);
        $data = $request->validate([
            'full_name' => 'required|string|max:200',
            'gender'    => 'required',
            'club'      => 'required'
        ]);

        $item->update($data);
        return redirect()->route('staff.index')->with('message', 'Fitness Consultant Updated Successfully');
    }

    public function destroy(FitnessConsultant $fitnessConsultant)
    {
        $fitnessConsultant->delete();
        return redirect()->back()->with('message', 'Fitness Consultant Deleted Successfully');
    }
}
