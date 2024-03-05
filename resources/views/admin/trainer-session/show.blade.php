{{-- <div class="col-xl-12">
    <div class="page-title flex-wrap justify-content-between">
        <a href="{{ route('print-trainer-session-detail-pdf') }}" target="_blank" class="btn btn-info">Print PDF</a>
    </div>
</div> --}}

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="teacher-deatails">
                <h3 class="heading">Personal Data :</h3>

                <table class="table">
                    <tbody>
                        <tr>
                            <td scope="col">
                                <h6>Full Name</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->members->full_name }}</span>
                            </td>
                            <td scope="col">
                                <h6>Nick Name</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->members->nickname }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Member Code</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->members->member_code }}</span>
                            </td>
                            <td scope="col">
                                <h6>Gender</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->members->gender }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Date of birth</h6>
                            </td>
                            <td scope="col">
                                <span>{{ DateFormat($trainerSession->members->born, 'DD MMMM YYYY') }}</span>
                            </td>
                            <td scope="col">
                                <h6>Phone Number</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->members->phone_number }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Email</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->members->email }}</span>
                            </td>
                            <td scope="col">
                                <h6>Instagram</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->members->ig }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Emergency Contact</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->members->emergency_contact }}</span>
                            </td>
                            <td scope="col">
                                <h6>Address</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->members->address }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Description</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->members->emergency_contact }}</span>
                            </td>
                            <td scope="col">
                                <h6>Photos</h6>
                            </td>
                            <td scope="col">
                                <div class="trans-list">
                                    @if ($trainerSessionss->photos)
                                        <img src="{{ Storage::url($trainerSessionss->photos) }}" class="lazyload"
                                            width="100" alt="image">
                                    @else
                                        <img src="{{ asset('default.png') }}" class="lazyload" width="100"
                                            alt="default image">
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="teacher-deatails">
                <h3 class="heading">Package Data & Other :</h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <td scope="col">
                                <h6>PT by</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->personalTrainers->full_name }}</span>
                            </td>
                            <td scope="col">
                                <h6>Trainer Phone Number</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->personalTrainers->phone_number }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Session Total</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->number_of_session }}</span>
                            </td>
                            <td scope="col">
                                <h6>Remaining Session</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSessionss->remaining_sessions }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Number of Days</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->days }}</span>
                            </td>
                            <td scope="col">
                                <h6>Package Price</h6>
                            </td>
                            <td scope="col">
                                <span>{{ formatRupiah($trainerSession->package_price) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Start Date</h6>
                            </td>
                            <td scope="col">
                                <span>{{ DateFormat($trainerSession->start_date, 'DD MMMM YYYY') }}</span>
                            </td>
                            <td scope="col">
                                <h6>Expired Date</h6>
                            </td>
                            <td scope="col">
                                <span>{{ DateFormat($trainerSessionss->expired_date, 'DD MMMM YYYY') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Method Payment</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSessionss->method_payment_name }}</span>
                            </td>
                            <td scope="col">
                                <h6>Trainer Package Description</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->trainerPackages->description }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Trainer Session Description</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->description }}</span>
                            </td>
                            <td scope="col">
                                <h6>Fitness Consultant</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->fitnessConsultants->full_name }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col">
                                <h6>Staff</h6>
                            </td>
                            <td scope="col">
                                <span>{{ $trainerSession->users->full_name }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <h3 class="heading">Check In Time & Check Out Time</h3>
            <table class="table">
                <thead>
                    <tr>
                        @if (Auth::user()->role == 'ADMIN')
                            <td></td>
                        @endif
                        <th>No</th>
                        <th>Check In Time</th>
                        <th>Check Out Time</th>
                        @if (Auth::user()->role == 'ADMIN')
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checkInTrainerSession as $item)
                        <tr>
                            @if (Auth::user()->role == 'ADMIN')
                                <td><input type="checkbox" name="selectedItems[]" value="{{ $item->id }}"></td>
                            @endif
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ DateFormat($item->check_in_time, 'DD MMMM YYYY, HH:mm') }}</td>
                            <td>{{ DateFormat($item->check_out_time, 'DD MMMM YYYY, HH:mm') }}</td>
                            @if (Auth::user()->role == 'ADMIN')
                                <td>
                                    <form action="{{ route('member-check-in.destroy', $item->id) }}"
                                        onclick="return confirm('Delete Data ?')" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn light btn-danger btn-xs mb-1">Delete</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($remainingSessions == 0)
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('trainer-session-over.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
@else
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('trainer-session.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
@endif
