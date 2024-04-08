<?php

namespace App\Http\Controllers\Staff;

use App\Exports\StaffExport;
use App\Http\Controllers\Controller;
use App\Models\Staff\ClassInstructor;
use App\Models\Staff\FitnessConsultant;
use App\Models\Staff\PersonalTrainer;
use App\Models\Staff\Physiotherapy;
use App\Models\Staff\PTLeader;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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
            'users'                 => User::get(),
            'content'               => 'admin/staff/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    // public function cetak_pdf()
    // {
    //     $administrator         = User::where('role', 'ADMIN')->get();
    //     $classInstructor       = ClassInstructor::get();
    //     $customerService       = User::where('role', 'CS')->get();
    //     $personalTrainer       = PersonalTrainer::get();

    //     $pdf = PDF::loadView('admin/staff/staff-pdf', [
    //         'administrator'     => $administrator,
    //         'customerService'   => $customerService,
    //         'personalTrainer'   => $personalTrainer,
    //     ]);
    //     return $pdf->stream('laporan-staff-pdf');
    // }

    public function excel()
    {
        return Excel::download(new StaffExport(), 'pt-report.xlsx');
    }
}
