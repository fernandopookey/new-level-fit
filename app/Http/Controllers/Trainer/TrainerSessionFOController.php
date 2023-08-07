<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerSessionFOStoreRequest;
use App\Http\Requests\TrainerSessionFOUpdateRequest;
use App\Models\Member\Member;
use App\Models\Trainer\Trainer;
use App\Models\Trainer\TrainerSessionFitnessOrientation;
use Illuminate\Http\Request;

class TrainerSessionFOController extends Controller
{
    public function index()
    {
        $data = [
            'title'             => 'Trainer Session Fitness Orientation List',
            'trainerSessionFO'  => TrainerSessionFitnessOrientation::get(),
            'members'           => Member::get(),
            'trainers'          => Trainer::get(),
            'content'           => 'admin/trainer-session-fo/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'             => 'New Trainer Session Fitness Orientation',
            'trainerSessionFO'  => TrainerSessionFitnessOrientation::all(),
            'members'           => Member::get(),
            'trainers'          => Trainer::get(),
            'content'           => 'admin/trainer-session-fo/create',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(TrainerSessionFOStoreRequest $request)
    {
        $data = $request->all();
        $data['session_code'] = 'TS-' . mt_rand(00000, 99999) . '-FO';

        TrainerSessionFitnessOrientation::create($data);
        return redirect()->route('trainer-session-FO.index')->with('message', 'Trainer Session Fitness Orientation Added Successfully');
    }

    public function show($id)
    {
        // $trainerSession        = TrainerSession::with(['members', 'product'])->findOrFail($id);

        $data = [
            'title'             => 'Trainer Session Fitness Orientation Detail',
            'trainerSessionFO'  => TrainerSessionFitnessOrientation::find($id),
            'members'           => Member::get(),
            'trainers'          => Trainer::get(),
            'content'           => 'admin/trainer-session-fo/show',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function edit(string $id)
    {
        $data = [
            'title'             => 'Edit Trainer Session Fitness Orientation',
            'trainerSessionFO'  => TrainerSessionFitnessOrientation::find($id),
            'members'           => Member::get(),
            'trainers'          => Trainer::get(),
            'content'           => 'admin/trainer-session-fo/edit'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function update(TrainerSessionFOUpdateRequest $request, string $id)
    {
        $item = TrainerSessionFitnessOrientation::find($id);
        $data = $request->all();

        $item->update($data);
        return redirect()->route('trainer-session-FO.index')->with('message', 'Trainer Session Fitness Orientation Updated Successfully');
    }

    public function destroy($id)
    {
        $trainerSessionfo = TrainerSessionFitnessOrientation::find($id);
        $trainerSessionfo->delete();
        return redirect()->back()->with('message', 'Trainer Session Fitness Orientation Deleted Successfully');
    }
}
