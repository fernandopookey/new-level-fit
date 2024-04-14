<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="teacher-deatails">
                <h3 class="heading">Member's Profile:</h3>
                <table class="table" border="2">
                    <tbody style="color: rgb(85, 85, 85);">
                        <tr>
                            <th scope="col">
                                <b>Full Name</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $query->first()->member_name }}
                            </th>
                            <th scope="col">
                                <b>Nick Name</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $query->first()->nickname }}
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">
                                <b>Member Number</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $query->first()->member_code }}
                            </th>
                            <th scope="col">
                                <b>Card Number</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $query->first()->card_number }}
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">
                                <b>Date of birth</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ DateFormat($query->first()->born, 'DD MMMM YYYY') }}
                            </th>
                            <th scope="col">
                                <b>Phone Number</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $query->first()->member_phone }}
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">
                                <b>Gender</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $query->first()->gender }}
                            </th>
                            <th scope="col">
                                <b>Address</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $query->first()->address }}
                            </th>
                        </tr>
                        <tr>
                            <th><b>Email</th>
                            <th style="text-transform: lowercase; border-right: 2px solid rgb(212, 212, 212);">:
                                {{ $query->first()->email }}</th>
                            <th><b>Instragram</th>
                            <th>: {{ $query->first()->ig }}</th>
                        </tr>
                        <tr>
                            <th><b>Emergency Contact</th>
                            <th style="text-transform: lowercase; border-right: 2px solid rgb(212, 212, 212);">:
                                {{ $query->first()->emergency_contact }}</th>
                            <th><b>Emergency Contact Name</th>
                            <th>: {{ $query->first()->ec_name }}</th>
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
            @foreach ($query as $query)
                <div class="accordion accordion-flush" id="accordionFlushExample{{ $loop->iteration }}">
                    <div class="accordion-item">
                        <h2 class="accordion-header text-white">
                            <button class="accordion-button collapsed bg-info text-white" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{ $loop->iteration }}"
                                aria-expanded="false" aria-controls="flush-collapseOne{{ $loop->iteration }}">
                                Package Info: {{ $loop->iteration }}
                            </button>
                        </h2>
                        <div id="flush-collapseOne{{ $loop->iteration }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample{{ $loop->iteration }}">
                            <div class="accordion-body">
                                <table class="table">
                                    <tbody style="color: rgb(85, 85, 85);">
                                        <tr>
                                            <th><b>Package Name</b></th>
                                            <th>{{ $query->package_name }}</th>
                                        </tr>
                                        <tr>
                                            <th><b>Number Of Days</th>
                                            <th>{{ $query->ts_number_of_days }} Days</th>
                                        </tr>
                                        <tr>
                                            <th><b>Package Price</b></th>
                                            <th>{{ formatRupiah($query->ts_package_price) }}</th>
                                        </tr>
                                        <tr>
                                            <th><b>Start Date</th>
                                            <th>{{ DateFormat($query->start_date, 'DD MMMM YYYY') }}</th>
                                        </tr>
                                        <tr>
                                            <th><b>Expired Date</th>
                                            <th>{{ DateFormat($query->expired_date, 'DD MMMM YYYY') }}</th>
                                        </tr>
                                        <tr>
                                            <th><b>Method Payment</b></th>
                                            <th>{{ $query->method_payment_name }}</th>
                                        </tr>
                                        <tr>
                                            <th><b>Description</b></th>
                                            <th>{{ $query->description }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ route('pt-agreement', $query->id) }}" class="btn btn-primary btn-sm"
                                    target="_blank">Download
                                    Agrement {{ $loop->iteration }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-info text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                            aria-controls="flush-collapseOne">
                            Check In & Checkout History
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Check In Time</th>
                                        <th>Check Out Time</th>
                                        <th>Duration</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($checkInTrainerSession as $item)
                                    <tbody style="color: rgb(85, 85, 85);">
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ DateFormat($item->check_in_time, 'DD MMMM YYYY, HH:mm') }}</td>
                                            <td>{{ $item->check_out_time ? DateFormat($item->check_out_time, 'DD MMMM YYYY, HH:mm') : 'Not Yet' }}
                                            </td>
                                            @php
                                                $checkInTime = \Carbon\Carbon::parse($item->check_in_time);
                                                $checkOutTime = \Carbon\Carbon::parse($item->check_out_time);

                                                $totalDuration = $checkInTime->diffInSeconds($checkOutTime);
                                                $hours = floor($totalDuration / 3600);
                                                $minutes = floor(($totalDuration % 3600) / 60);
                                                $seconds = $totalDuration % 60;

                                                $formattedDuration = sprintf(
                                                    '%02d:%02d:%02d',
                                                    $hours,
                                                    $minutes,
                                                    $seconds,
                                                );
                                            @endphp
                                            <td>{{ $item->check_out_time ? $formattedDuration : 'Not Yet' }}</td>
                                            <td>
                                                @if (Auth::user()->role == 'ADMIN')
                                                    <form
                                                        action="{{ route('trainer-session-check-in.destroy', $item->id) }}"
                                                        onclick="return confirm('Delete Data ?')" method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn light btn-danger btn-xs mb-1 btn-block">Delete</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            @if ($remainingSessions == 0)
                <a href="{{ route('trainer-session-over.index') }}" class="btn btn-primary">Back</a>
            @else
                <a href="{{ route('trainer-session.index') }}" class="btn btn-primary">Back</a>
            @endif
        </div>
    </div>
</div>
