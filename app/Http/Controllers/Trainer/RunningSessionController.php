<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\RunningSessionStoreRequest;
use App\Http\Requests\RunningSessionUpdateRequest;
use App\Models\Member\Member;
use App\Models\Staff\CustomerService;
use App\Models\Staff\PersonalTrainer;
use App\Models\Trainer\RunningSession;
use App\Models\Trainer\TrainerPackage;
use Illuminate\Http\Request;

class RunningSessionController extends Controller
{
    public function index()
    {
        $data = [
            'title'             => 'Running Session List',
            'runningSession'    => RunningSession::get(),
            'members'           => Member::get(),
            'trainerPackages'   => TrainerPackage::get(),
            'personalTrainers'  => PersonalTrainer::get(),
            'customerServices'  => CustomerService::get(),
            'content'           => 'admin/running-session/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'             => 'New Running Session',
            'runningSession'    => RunningSession::get(),
            'members'           => Member::get(),
            'trainerPackages'   => TrainerPackage::get(),
            'personalTrainers'  => PersonalTrainer::get(),
            'customerServices'  => CustomerService::get(),
            'content'           => 'admin/running-session/create',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(RunningSessionStoreRequest $request)
    {
        $data = $request->all();

        RunningSession::create($data);
        return redirect()->route('running-session.index')->with('message', 'Running Session Added Successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = [
            'title'             => 'Running Session Check Out',
            'runningSession'    => RunningSession::find($id),
            'members'           => Member::get(),
            'trainerPackages'   => TrainerPackage::get(),
            'personalTrainers'  => PersonalTrainer::get(),
            'customerServices'  => CustomerService::get(),
            'content'           => 'admin/running-session/edit'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function update(RunningSessionUpdateRequest $request, string $id)
    {
        $item = RunningSession::find($id);
        // dd($item);
        $data = $request->all();

        $item->update($data);
        return redirect()->route('running-session.index')->with('message', 'Running Session Check Out Successfully');
    }

    public function destroy(RunningSession $runningSession)
    {
        $runningSession->delete();
        return redirect()->back()->with('message', 'Running Session Deleted Successfully');
    }
}
