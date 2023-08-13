<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Member\Member;
use Illuminate\Http\Request;

class ReportFitnessController extends Controller
{
    public function index()
    {
        $data = [
            'title'                 => 'Report GYM Club List',
            'appointment'           => Appointment::get(),
            'member'                => Member::get(),
            // 'administrator'         => User::where('role', 'ADMIN')->get(),
            // 'classInstructor'       => ClassInstructor::get(),
            // 'customerService'       => User::where('role', 'CS')->get(),
            // 'customerServicePos'    => User::where('role', 'CSPOS')->get(),
            // 'fitnessConsultant'     => FitnessConsultant::get(),
            // 'personalTrainer'       => PersonalTrainer::get(),
            // 'physiotherapy'         => Physiotherapy::get(),
            // 'ptLeader'              => PTLeader::get(),
            'content'               => 'admin/gym-report/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }
}
