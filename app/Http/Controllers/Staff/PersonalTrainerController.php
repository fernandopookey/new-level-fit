<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\PersonalTrainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalTrainerController extends Controller
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
            'full_name'     => 'required|string|max:200',
            'phone_number'  => '',
            'gender'        => 'required',
            'address'       => '',
            'description'   => '',
        ]);
        $data['user_id'] = Auth::user()->id;

        PersonalTrainer::create($data);
        return redirect()->route('staff.index')->with('message', 'Personal Trainer Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = PersonalTrainer::find($id);
        $data = $request->validate([
            'full_name' => 'string|max:200',
            'gender'    => '',
        ]);
        $data['user_id'] = Auth::user()->id;

        $item->update($data);
        return redirect()->route('staff.index')->with('message', 'Personal Trainer Updated Successfully');
    }

    public function destroy(PersonalTrainer $personalTrainer)
    {
        $personalTrainer->delete();
        return redirect()->back()->with('message', 'Personal Trainer Deleted Successfully');
    }
}
