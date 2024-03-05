<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap justify-content-between">
                    <div>
                        <a href="{{ route('print-member-registration-over-pdf') }}" target="_blank"
                            class="btn btn-info">Cetak
                            PDF</a>
                    </div>
                    <div>
                        @if (!empty($memberRegistrationsOver))
                            <?php
                            $earliestDate = \Carbon\Carbon::parse($memberRegistrationsOver->min('earliest_created_at'))->format('Y-m-d');
                            $latestDate = \Carbon\Carbon::parse($memberRegistrationsOver->max('latest_created_at'))->format('Y-m-d');
                            ?>
                            <div class="date-section">
                                <p>{{ $earliestDate }} <b>to</b> {{ $latestDate }}</p>

                                @foreach ($memberRegistrationsOver as $session)
                                    <!-- Your display logic for each session goes here -->
                                @endforeach
                            </div>
                        @else
                            <p>No trainer sessions found.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="page-title flex-wrap">
                    <div>
                        @php
                            $totalPrice = 0;
                            $adminPrice = 0;
                        @endphp
                        @foreach ($memberRegistrationsOver as $item)
                            @php
                                $totalPrice += $item->total_price;
                                $adminPrice += $item->admin_price;
                            @endphp
                        @endforeach

                        <table class="table borderless display dataTable price-table">
                            <tbody>
                                <tr>
                                    <th scope="row">Total Package Price Over</th>
                                    <td>: {{ formatRupiah($totalPrice) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total Admin Price over</th>
                                    <td>: {{ formatRupiah($adminPrice) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--column-->
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="table-responsive full-data">
                    {{-- <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="example-student"> --}}
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="myTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>No</th>
                                <th>Image</th>
                                <th>Member's Data</th>
                                <th>Last Check In</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Staff</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($memberRegistrationsOver as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selectedMembersOver[]" value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="trans-list">
                                            @if ($item->photos)
                                                <img src="{{ Storage::url($item->photos) }}" class="lazyload"
                                                    width="100" alt="image">
                                            @else
                                                <img src="{{ asset('default.png') }}" class="lazyload" width="100"
                                                    alt="default image">
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <h6>{{ $item->member_name }},</h6>
                                        <h6>{{ $item->member_code }},</h6>
                                        <h6>{{ $item->phone_number }}</h6>
                                    </td>
                                    <td>
                                        @php
                                            $daysLeft = Carbon\Carbon::parse($item->expired_date)->diffInDays(
                                                Carbon\Carbon::now(),
                                            );
                                        @endphp
                                        @if ($daysLeft <= 5 && $daysLeft == 3)
                                            <span class="badge badge-warning badge-lg">
                                                @if (!$item->check_in_time && !$item->check_out_time)
                                                    Not Yet
                                                @elseif ($item->check_in_time && $item->check_out_time)
                                                    {{ DateDiff($item->check_out_time, \Carbon\Carbon::now(), true) }}
                                                    day ago
                                                @elseif ($item->check_in_time && !$item->check_out_time)
                                                    Running
                                                @endif
                                            </span>
                                        @elseif($daysLeft <= 2)
                                            <span class="badge badge-danger badge-lg">
                                                @if (!$item->check_in_time && !$item->check_out_time)
                                                    Not Yet
                                                @elseif ($item->check_in_time && $item->check_out_time)
                                                    {{ DateDiff($item->check_out_time, \Carbon\Carbon::now(), true) }}
                                                    day ago
                                                @elseif ($item->check_in_time && !$item->check_out_time)
                                                    Running
                                                @endif
                                            </span>
                                        @else
                                            <span class="badge badge-info badge-lg">
                                                @if (!$item->check_in_time && !$item->check_out_time)
                                                    Not Yet
                                                @elseif ($item->check_in_time && $item->check_out_time)
                                                    {{ DateDiff($item->check_out_time, \Carbon\Carbon::now(), true) }}
                                                    day ago
                                                @elseif ($item->check_in_time && !$item->check_out_time)
                                                    Running
                                                @endif
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <h6>{{ DateFormat($item->start_date, 'DD MMMM YYYY') }}-{{ DateFormat($item->expired_date, 'DD MMMM YYYY') }}
                                        </h6>
                                    </td>
                                    <td>
                                        @if ($item->status == 'Running')
                                            <span class="badge badge-primary badge-lg">Running</span>
                                        @else
                                            <span class="badge badge-danger badge-lg">Over</span>
                                        @endif
                                    </td>
                                    <td>
                                        <h6>{{ $item->staff_name }}</h6>
                                    </td>
                                    <td>
                                        <div>
                                            @if (Auth::user()->role == 'ADMIN')
                                                <a href="{{ route('member-active.edit', $item->id) }}"
                                                    class="btn light btn-warning btn-xs mb-1 btn-block">Edit</a>
                                            @endif
                                            <a href="{{ route('membership-agreement', $item->id) }}" target="_blank"
                                                class="btn light btn-secondary btn-xs mb-1 btn-block">Agrement</a>
                                            <a href="{{ route('member-expired.show', $item->id) }}"
                                                class="btn light btn-info btn-xs mb-1 btn-block">Detail</a>
                                            <a href="{{ route('renewal', $item->id) }}"
                                                class="btn light btn-dark btn-xs mb-1 btn-block">Renewal</a>
                                            @if (Auth::user()->role == 'ADMIN')
                                                <form action="{{ route('member-active.destroy', $item->id) }}"
                                                    onclick="return confirm('Delete Data ?')" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn light btn-danger btn-xs btn-block mb-1">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-danger" id="deleteSelectedMembersOver">Delete
                        Selected</button>
                </div>
            </div>
            <!--/column-->
        </div>
    </div>
</div>
