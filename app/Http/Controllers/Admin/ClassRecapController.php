<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassStoreRequest;
use App\Http\Requests\ClassUpdateRequest;
use App\Models\ClassRecap;
use App\Models\Staff\ClassInstructor;
use App\Models\Staff\CustomerService;
use Illuminate\Http\Request;

class ClassRecapController extends Controller
{
    public function index()
    {
        $data = [
            'title'             => 'Class List',
            'class'             => ClassRecap::get(),
            'classInstructor'   => ClassInstructor::get(),
            'customerService'   => CustomerService::get(),
            'content'           => 'admin/class/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'             => 'New Class',
            'class'             => ClassRecap::get(),
            'classInstructor'   => ClassInstructor::get(),
            'customerService'   => CustomerService::get(),
            'content'           => 'admin/class/create',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(ClassStoreRequest $request)
    {
        $data = $request->all();

        ClassRecap::create($data);
        return redirect()->route('class.index')->with('message', 'Class Added Successfully');
    }

    public function edit(string $id)
    {
        $data = [
            'title'             => 'Edit Class',
            'class'             => ClassRecap::find($id),
            'classInstructor'   => ClassInstructor::get(),
            'customerService'   => CustomerService::get(),
            'content'           => 'admin/class/edit'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function update(ClassUpdateRequest $request, string $id)
    {
        $item = ClassRecap::find($id);
        $data = $request->all();

        $item->update($data);
        return redirect()->route('class.index')->with('message', 'Class Updated Successfully');
    }

    public function destroy($id)
    {
        $class = ClassRecap::find($id);
        $class->delete();
        return redirect()->back()->with('message', 'Class Deleted Successfully');
    }
}
