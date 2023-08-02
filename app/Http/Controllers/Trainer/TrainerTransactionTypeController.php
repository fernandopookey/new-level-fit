<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Trainer\TrainerTransactionType;
use Illuminate\Http\Request;

class TrainerTransactionTypeController extends Controller
{
    public function index()
    {
        $data = [
            'title'                     => 'Trainer Transaction Type List',
            'trainerTransactionType'    => TrainerTransactionType::get(),
            'content'                   => 'admin/trainer-transaction-type/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'transaction_name'  => 'required|string|max:200'
        ]);

        TrainerTransactionType::create($data);
        return redirect()->route('trainer-transaction-type.index')->with('message', 'Trainer Transaction Type Added Successfully');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $item = TrainerTransactionType::find($id);
        $data = $request->validate([
            'transaction_name'              => 'required|string|max:200'
        ]);

        $item->update($data);
        return redirect()->route('trainer-transaction-type.index')->with('message', 'Trainer Transaction Type Updated Successfully');
    }

    public function destroy(TrainerTransactionType $trainerTransactionType)
    {
        $trainerTransactionType->delete();
        return redirect()->back()->with('message', 'Trainer Transaction Type Deleted Successfully');
    }
}
