<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerStoreRequest;
use App\Models\Member\Member;
use App\Models\MethodPayment;
use App\Models\Staff\FitnessConsultant;
use App\Models\Trainer\Trainer;
use App\Models\Trainer\TrainerPackage;
use App\Models\Trainer\TrainerTransactionType;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $data = [
            'title'                     => 'Trainer List',
            'trainers'                  => Trainer::get(),
            'members'                   => Member::get(),
            'trainerTransactionType'    => TrainerTransactionType::get(),
            'trainerPackage'            => TrainerPackage::get(),
            'methodPayment'             => MethodPayment::get(),
            'fc'                        => FitnessConsultant::get(),
            'content'                   => 'admin/trainer/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        //
    }

    public function store(TrainerStoreRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('photos')) {

            if ($request->photos != null) {
                $realLocation = "storage/" . $request->photos;
                if (file_exists($realLocation) && !is_dir($realLocation)) {
                    unlink($realLocation);
                }
            }

            $photos = $request->file('photos');
            $file_name = time() . '-' . $photos->getClientOriginalName();

            $data['photos'] = $request->file('photos')->store('assets/trainer', 'public');
        } else {
            $data['photos'] = $request->photos;
        }

        Trainer::create($data);
        return redirect()->route('trainer.index')->with('message', 'Trainer Added Successfully');
    }

    public function edit(string $id)
    {
        // 
    }

    public function update(Request $request, string $id)
    {
        $item = Trainer::find($id);
        $data = $request->validate([
            'transaction_type_id'   => '',
            'member_id'             => '',
            'trainer_name'          => '',
            'trainer_package_id'    => '',
            'method_payment_id'     => '',
            'fc_id'                 => '',
            'description'           => '',
            'photos'                => 'nullable|mimes:png,jpg,jpeg'
        ]);

        if ($request->hasFile('photos')) {

            if ($item->photos != null) {
                $realLocation = "storage/" . $item->photos;
                if (file_exists($realLocation) && !is_dir($realLocation)) {
                    unlink($realLocation);
                }
            }

            $photos = $request->file('photos');
            $file_name = time() . '-' . $photos->getClientOriginalName();

            $data['photos'] = $request->file('photos')->store('assets/trainer', 'public');
        } else {
            $data['photos'] = $item->photos;
        }

        $item->update($data);
        return redirect()->route('trainer.index')->with('message', 'Trainer Updated Successfully');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return redirect()->back()->with('message', 'Trainer Deleted Successfully');
    }
}
