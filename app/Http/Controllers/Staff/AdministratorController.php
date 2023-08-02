<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdministratorController extends Controller
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
            'club'      => 'required'
        ]);

        $data['password'] = bcrypt($request->password);

        User::create($data);
        return redirect()->route('staff.index')->with('message', 'Administrator Added Successfully');
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
            'gender'    => 'required',
            'club'      => 'required'
        ]);

        $item->update($data);
        return redirect()->route('staff.index')->with('message', 'Administrator Updated Successfully');
    }

    public function destroy(User $administrator)
    {
        $administrator->delete();
        return redirect()->back()->with('message', 'Administrator Deleted Successfully');
    }
}
