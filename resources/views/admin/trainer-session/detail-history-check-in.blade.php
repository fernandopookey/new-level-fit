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
                                : {{ $trainerSession->members->full_name }}
                            </th>
                            <th scope="col">
                                <b>Nick Name</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $trainerSession->members->nickname }}
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">
                                <b>Member Number</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $trainerSession->members->member_code }}
                            </th>
                            <th scope="col">
                                <b>Card Number</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $trainerSession->members->card_number }}
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">
                                <b>Date of birth</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ DateFormat($trainerSession->members->born, 'DD MMMM YYYY') }}
                            </th>
                            <th scope="col">
                                <b>Phone Number</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $trainerSession->members->phone_number }}
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">
                                <b>Gender</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $trainerSession->members->gender }}
                            </th>
                            <th scope="col">
                                <b>Address</b>
                            </th>
                            <th style="border-right: 2px solid rgb(212, 212, 212);">
                                : {{ $trainerSession->members->address }}
                            </th>
                        </tr>
                        <tr>
                            <th><b>Email</th>
                            <th style="text-transform: lowercase; border-right: 2px solid rgb(212, 212, 212);">:
                                {{ $trainerSession->members->email }}</th>
                            <th><b>Instragram</th>
                            <th>: {{ $trainerSession->members->ig }}</th>
                        </tr>
                        <tr>
                            <th><b>Emergency Contact</th>
                            <th style="text-transform: lowercase; border-right: 2px solid rgb(212, 212, 212);">:
                                {{ $trainerSession->members->emergency_contact }}</th>
                            <th><b>Emergency Contact Name</th>
                            <th>: {{ $trainerSession->members->ec_name }}</th>
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
            @foreach ($query as $item)
                {{-- <div class="accordion accordion-flush" id="accordionFlushExample{{ $loop->iteration }}">
                    <div class="accordion-item">
                        <h2 class="accordion-header text-white">
                            <button class="accordion-button collapsed bg-info text-white" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{ $loop->iteration }}"
                                aria-expanded="false" aria-controls="flush-collapseOne{{ $loop->iteration }}">
                                Package Info: {{ $loop->iteration }}
                            </button>
                        </h2> --}}
                <table class="table">
                    <tbody style="color: rgb(85, 85, 85);">
                        <tr>
                            <th><b>Package Name</b></th>
                            <th>{{ $item->package_name }}</th>
                        </tr>
                        <tr>
                            <th><b>Number Of Days</th>
                            <th>{{ $item->ts_number_of_days }} Days</th>
                        </tr>
                        <tr>
                            <th><b>Package Price</b></th>
                            <th>{{ formatRupiah($item->ts_package_price) }}</th>
                        </tr>
                        <tr>
                            <th><b>Start Date</th>
                            <th>{{ DateFormat($item->start_date, 'DD MMMM YYYY') }}</th>
                        </tr>
                        <tr>
                            <th><b>Expired Date</th>
                            <th>{{ DateFormat($item->expired_date, 'DD MMMM YYYY') }}</th>
                        </tr>
                        <tr>
                            <th><b>Method Payment</b></th>
                            <th>{{ $item->method_payment_name }}</th>
                        </tr>
                        <tr>
                            <th><b>Description</b></th>
                            <th>{{ $item->description }}</th>
                        </tr>
                    </tbody>
                </table>
                {{-- <a href="{{ route('pt-agreement', $item->id) }}" class="btn btn-primary btn-sm"
                    target="_blank">Download
                    Agrement {{ $item->id }}</a> --}}

                {{-- </div>
                </div> --}}
            @endforeach
        </div>
    </div>
</div>

{{-- Check In & Check Out --}}
<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Check In Time</th>
                        <th>Check Out Time</th>
                        <th>Duration</th>
                        <th>PT by</th>
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

                                $formattedDuration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                            @endphp
                            <td>{{ $item->check_out_time ? $formattedDuration : 'Not Yet' }}</td>
                            <td>{{ $item->personaltrainer ? $item->personalTrainer->full_name : 'No Data' }}
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('pt-history') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>
