<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerSessionStoreRequest;
use App\Http\Requests\TrainerSessionUpdateRequest;
use App\Models\Member\Member;
use App\Models\MethodPayment;
use App\Models\Staff\FitnessConsultant;
use App\Models\Staff\PersonalTrainer;
use App\Models\Trainer\CheckInTrainerSession;
use App\Models\Trainer\TrainerPackage;
use App\Models\Trainer\TrainerSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TrainerSessionController extends Controller
{
    public function index()
    {
        $trainerSessions = DB::table('trainer_sessions as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days as member_registration_days',
                'a.old_days',
                'b.full_name as member_name',
                'b.member_code',
                'b.phone_number as member_phone',
                'b.photos',
                'b.born',
                'c.package_name',
                'c.number_of_session',
                'c.package_price',
                'd.full_name as trainer_name',
                'd.phone_number as trainer_phone',
                'g.full_name as staff_name',
                'h.full_name as fc_name',
                'h.phone_number as fc_phone_number',
                'i.name as method_payment_name',
                'cits.check_in_time',
                'cits.check_out_time'
                // 'f.id as current_check_in_trainer_sessions_id',
                // 'f.check_out_time'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as expired_date_status'),
                DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'),
                DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status'),
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions where check_out_time is not null GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, MAX(check_in_time) as check_in_time, MAX(check_out_time) as check_out_time FROM check_in_trainer_sessions GROUP BY trainer_session_id) as cits'), 'a.id', '=', 'cits.trainer_session_id')
            ->join('users as g', 'a.user_id', '=', 'g.id')
            ->join('fitness_consultants as h', 'a.fc_id', '=', 'h.id')
            ->join('method_payments as i', 'a.method_payment_id', '=', 'i.id')
            ->whereRaw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END = "Running"')
            ->orderBy('cits.check_in_time', 'desc')
            ->get();

        $birthdayMessage3 = "";
        $birthdayMessage2 = "";
        $birthdayMessage1 = "";
        $birthdayMessage0 = "";

        foreach ($trainerSessions as $memberRegistration) {
            if (BirthdayDiff($memberRegistration->born) == 0) {
                $memberRegistration->birthdayCelebrating = "bg-warning";
                $birthdayMessage0 = $birthdayMessage0 . $memberRegistration->member_name . '';
            } else if (BirthdayDiff($memberRegistration->born) == 1) {
                $memberRegistration->birthdayCelebrating = "bg-primary";
                $birthdayMessage1 = $birthdayMessage1 . $memberRegistration->member_name . '';
            } else if (BirthdayDiff($memberRegistration->born) == 2) {
                $memberRegistration->birthdayCelebrating = "bg-warning";
                $birthdayMessage2 = $birthdayMessage2 . $memberRegistration->member_name . '';
            }
        }

        $data = [
            'title'             => 'Trainer Session List',
            'trainerSessions'   => $trainerSessions,
            'content'           => 'admin/trainer-session/index',
            'birthdayMessage3'       => $birthdayMessage3,
            'birthdayMessage2'       => $birthdayMessage2,
            'birthdayMessage1'       => $birthdayMessage1,
            'birthdayMessage0'       => $birthdayMessage0,
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'             => 'New Trainer Session',
            'trainerSession'    => TrainerSession::all(),
            'members'           => Member::get(),
            'personalTrainers'  => PersonalTrainer::get(),
            'trainerPackages'   => TrainerPackage::get(),
            'methodPayment'     => MethodPayment::get(),
            'users'             => User::get(),
            'fitnessConsultant' => FitnessConsultant::get(),
            'content'           => 'admin/trainer-session/create',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(TrainerSessionStoreRequest $request)
    {
        $data = $request->all();

        $package = TrainerPackage::findOrFail($data['trainer_package_id']);

        $data['user_id'] = Auth::user()->id;

        $data['start_date'] =  $data['start_date'] . ' ' .  $data['start_time'];
        $dateTime = new \DateTime($data['start_date']);
        $data['start_date'] = $dateTime->format('Y-m-d H:i:s');
        unset($data['start_time']);

        $data['package_price'] = $package->package_price;
        $data['admin_price'] = $package->admin_price;
        $data['days'] = $package->days;
        $data['number_of_session'] = $package->number_of_session;

        TrainerSession::create($data);

        return redirect()->back()->with('message', 'Trainer Session Added Successfully');
    }

    public function show($id)
    {
        $trainerSessionss = DB::table('trainer_sessions as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days',
                'b.full_name as member_name',
                'b.address',
                'b.member_code',
                'b.phone_number as member_phone',
                'b.photos',
                'b.gender',
                'b.nickname',
                'b.ig',
                'b.emergency_contact',
                'b.email',
                'b.born',
                'c.package_name',
                'c.number_of_session',
                'c.days',
                'c.package_price',
                'd.full_name as trainer_name',
                'd.phone_number as trainer_phone',
                'g.full_name as staff_name',
                'h.full_name as fc_name',
                'h.phone_number as fc_phone_number',
                'i.name as method_payment_name',
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as expired_date_status'),
                DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'),
                DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions where check_out_time is not null GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
            ->join('users as g', 'a.user_id', '=', 'g.id')
            ->join('fitness_consultants as h', 'a.fc_id', '=', 'h.id')
            ->join('method_payments as i', 'a.method_payment_id', '=', 'i.id')
            ->whereRaw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END = "Running"')
            ->where('a.id', $id)
            ->get();

        $trainerSessions = TrainerSession::find($id);

        if (!$trainerSessions) {
            return abort(404);
        }

        $totalSessions = $trainerSessions->trainerPackages->number_of_session;

        $checkInTrainerSession = $trainerSessions->trainerSessionCheckIn;

        $checkInCount = $checkInTrainerSession->count();

        $remainingSessions = $totalSessions - $checkInCount;

        $data = [
            'title'                 => 'Trainer Session Detail',
            'checkInTrainerSession' => $checkInTrainerSession,
            'trainerSession'        => $trainerSessions->first(),
            'trainerSessionss'      => $trainerSessionss->first(),
            'totalSessions'         => $totalSessions,
            'remainingSessions'     => $remainingSessions,
            'members'               => Member::get(),
            'fitnessConsultants'    => FitnessConsultant::get(),
            'users'                 => User::get(),
            'personalTrainers'      => PersonalTrainer::get(),
            'trainerPackages'       => TrainerPackage::get(),
            'content'               => 'admin/trainer-session/show',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function edit(string $id)
    {
        $data = [
            'title'                 => 'Edit Trainer Session',
            'trainerSession'        => TrainerSession::find($id),
            'members'               => Member::get(),
            'personalTrainers'      => PersonalTrainer::get(),
            'trainerPackages'       => TrainerPackage::get(),
            'fitnessConsultants'    => FitnessConsultant::get(),
            'methodPayment'         => MethodPayment::get(),
            'content'               => 'admin/trainer-session/edit'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function update(TrainerSessionUpdateRequest $request, string $id)
    {
        $item = TrainerSession::find($id);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        // $data['start_date'] =  $data['start_date'] . ' ' .  $data['start_time'];
        // unset($data['start_time']);


        // $package = TrainerPackage::findOrFail($data['trainer_package_id']);

        $data['start_date'] =  $data['start_date'] . ' ' .  $data['start_time'];
        $dateTime = new \DateTime($data['start_date']);
        $data['start_date'] = $dateTime->format('Y-m-d H:i:s');
        unset($data['start_time']);

        // $data['package_price'] = $package->package_price;
        // $data['admin_price'] = $package->admin_price;
        // $data['days'] = $package->days;
        // $data['number_of_session'] = $package->number_of_session;


        $item->update($data);
        return redirect()->route('trainer-session.index')->with('message', 'Trainer Session Updated Successfully');
    }

    public function freeze(Request $request, string $id)
    {
        $item = TrainerSession::find($id);
        $data = $request->validate([
            'expired_date'            => 'required',
            'start_date'           => 'required',
        ]);
        $data['user_id'] = Auth::user()->id;
        $data['days'] =  DateDiff($data['start_date'], $data['expired_date']);
        $data['old_days'] = $item->trainerPackages->days;

        $item->update($data);

        unset($data['expired_date']);
        unset($data['old_expired_date']);
        $item->update($data);

        return redirect()->route('trainer-session.index')->with('message', 'Trainer Session Freeze Successfully');
    }

    public function destroy(TrainerSession $trainerSession)
    {
        try {
            $trainerSession->delete();
            return redirect()->back()->with('message', 'Trainer Session Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Deleted Failed, please delete check in first');
        }
    }

    public function deleteSelectedTrainerSessions(Request $request)
    {
        $selectedTrainerSessions = $request->input('selectedTrainerSessions', []);

        TrainerSession::whereIn('id', $selectedTrainerSessions)->delete();

        return redirect()->back()->with('message', 'Selected trainer sessions deleted successfully');
    }

    public function cetak_pdf()
    {
        $trainerSessions = DB::table('trainer_sessions as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days',
                'b.full_name as member_name',
                'b.member_code',
                'c.package_name',
                'c.number_of_session',
                'c.package_price',
                'd.full_name as trainer_name',
                'g.full_name as staff_name',
                'h.full_name as fc_name',
                'h.phone_number as fc_phone_number',
                'i.name as method_payment_name',
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as expired_date_status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
            ->join('users as g', 'a.user_id', '=', 'g.id')
            ->join('fitness_consultants as h', 'a.fc_id', '=', 'h.id')
            ->join('method_payments as i', 'a.method_payment_id', '=', 'i.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
            ->addSelect(DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'))
            ->addSelect(DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status'))
            ->whereRaw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END = "Running"')
            ->get();

        $pdf = Pdf::loadView('admin/trainer-session/trainer-session-pdf', [
            'trainerSessions'        => $trainerSessions,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('trainer-session-report.pdf');
    }

    public function agreement($id)
    {
        $trainerSession = DB::table('trainer_sessions as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days',
                'a.package_price as pt_package_price',
                'a.admin_price as pt_admin_price',
                'a.days as pt_registration_days',
                'a.number_of_session',
                'a.start_date',
                'b.full_name as member_name',
                'b.member_code',
                'b.gender',
                'b.phone_number as member_phone',
                'b.email',
                'b.address',
                'c.package_name',
                'c.number_of_session',
                'c.package_price',
                'd.full_name as trainer_name',
                'd.phone_number as trainer_phone',
                'g.full_name as staff_name',
                'h.full_name as fc_name',
                'h.phone_number as fc_phone_number',
                'i.name as method_payment_name'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as expired_date_status'),
                DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'),
                DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions where check_out_time is not null GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
            //->leftJoin(DB::raw('(SELECT * FROM check_in_trainer_sessions  order by check_in_time desc limit 1) as f'), 'f.trainer_session_id', '=', 'a.id')
            ->join('users as g', 'a.user_id', '=', 'g.id')
            ->join('fitness_consultants as h', 'a.fc_id', '=', 'h.id')
            ->join('method_payments as i', 'a.method_payment_id', '=', 'i.id')
            ->whereRaw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END = "Running"')
            ->where('a.id', $id)
            ->first();

        $fileName1 = $trainerSession->member_name;
        $fileName2 = $trainerSession->start_date;

        $pdf = Pdf::loadView('admin/trainer-session/agreement', [
            'trainerSession'        => $trainerSession,
        ]);
        return $pdf->stream('PT Agreement-' . $fileName1 . '-' . $fileName2 . '.pdf');
    }

    public function cuti($id)
    {
        $trainerSession = DB::table('trainer_sessions as a')
            ->select(
                'a.id',
                'a.start_date',
                'a.description',
                'a.days',
                'a.old_days',
                'a.package_price as pt_package_price',
                'a.admin_price as pt_admin_price',
                'a.days as pt_registration_days',
                'a.number_of_session',
                'a.start_date',
                'a.updated_at',
                'a.created_at',
                'b.full_name as member_name',
                'b.nickname',
                'b.born',
                'b.phone_number',
                'b.member_code',
                'b.gender',
                'b.phone_number as member_phone',
                'b.email',
                'b.address',
                'c.package_name',
                'c.number_of_session',
                'c.package_price',
                'd.full_name as trainer_name',
                'd.phone_number as trainer_phone',
                'g.full_name as staff_name',
                'h.full_name as fc_name',
                'h.phone_number as fc_phone_number',
                'i.name as method_payment_name'
            )
            ->addSelect(
                DB::raw('DATE_ADD(a.start_date, INTERVAL a.days DAY) as expired_date'),
                DB::raw('CASE WHEN NOW() > DATE_ADD(a.start_date, INTERVAL a.days DAY) THEN "Over" ELSE "Running" END as expired_date_status'),
                DB::raw('IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) as remaining_sessions'),
                DB::raw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END AS session_status')
            )
            ->join('members as b', 'a.member_id', '=', 'b.id')
            ->join('trainer_packages as c', 'a.trainer_package_id', '=', 'c.id')
            ->join('personal_trainers as d', 'a.trainer_id', '=', 'd.id')
            ->leftJoin(DB::raw('(SELECT trainer_session_id, COUNT(id) as check_in_count FROM check_in_trainer_sessions where check_out_time is not null GROUP BY trainer_session_id) as e'), 'e.trainer_session_id', '=', 'a.id')
            //->leftJoin(DB::raw('(SELECT * FROM check_in_trainer_sessions  order by check_in_time desc limit 1) as f'), 'f.trainer_session_id', '=', 'a.id')
            ->join('users as g', 'a.user_id', '=', 'g.id')
            ->join('fitness_consultants as h', 'a.fc_id', '=', 'h.id')
            ->join('method_payments as i', 'a.method_payment_id', '=', 'i.id')
            ->whereRaw('CASE WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) > 0 THEN "Running" WHEN IFNULL(c.number_of_session - e.check_in_count, c.number_of_session) < 0 THEN "kelebihan" ELSE "over" END = "Running"')
            ->where('a.id', $id)
            ->first();

        $fileName1 = $trainerSession->member_name;
        $fileName2 = $trainerSession->start_date;

        $pdf = Pdf::loadView('admin/trainer-session/cuti', [
            'memberRegistration'        => $trainerSession,
        ]);
        return $pdf->stream('Cuti Trainer Session -' . $fileName1 . '-' . $fileName2 . '.pdf');
    }
}
