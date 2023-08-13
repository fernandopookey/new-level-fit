<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\ClassInstructor;
use App\Models\Staff\CustomerPosService;
use App\Models\Staff\CustomerService;
use App\Models\Staff\FitnessConsultant;
use App\Models\Staff\PersonalTrainer;
use App\Models\Staff\Physiotherapy;
use App\Models\Staff\PTLeader;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $data = [
            'title'                 => 'Staff List',
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'classInstructor'       => ClassInstructor::get(),
            'customerService'       => User::where('role', 'CS')->get(),
            'customerServicePos'    => User::where('role', 'CSPOS')->get(),
            'fitnessConsultant'     => FitnessConsultant::get(),
            'personalTrainer'       => PersonalTrainer::get(),
            'physiotherapy'         => Physiotherapy::get(),
            'ptLeader'              => PTLeader::get(),
            'content'               => 'admin/staff/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }
}
