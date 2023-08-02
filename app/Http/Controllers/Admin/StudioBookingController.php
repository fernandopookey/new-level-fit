<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudioBookingStoreRequest;
use App\Models\StudioBooking;
use Illuminate\Http\Request;

class StudioBookingController extends Controller
{
    public function index()
    {
        $data = [
            'title'         => 'Studio Booking List',
            'studioBooking' => StudioBooking::get(),
            'content'       => 'admin/studio-booking/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        //
    }

    public function store(StudioBookingStoreRequest $request)
    {
        $data = $request->all();
        $data['booking_code'] = 'BC-' . mt_rand(0000, 9999) . '-STUDIO';

        StudioBooking::create($data);
        return redirect()->route('studio-booking.index')->with('message', 'Studio Booking Added Successfully');
    }

    public function edit(string $id)
    {
        // 
    }

    public function update(Request $request, string $id)
    {
        $item = StudioBooking::find($id);
        $data = $request->validate([
            'booking_date'  => '',
            'duration_time' => '',
            'name'          => '',
            'phone_number'  => '',
            'studio_name'   => '',
            'status'        => ''
        ]);

        $item->update($data);
        return redirect()->route('studio-booking.index')->with('message', 'Studio Booking Updated Successfully');
    }

    public function destroy(StudioBooking $studioBooking)
    {
        $studioBooking->delete();
        return redirect()->back()->with('message', 'Studio Booking Deleted Successfully');
    }
}
