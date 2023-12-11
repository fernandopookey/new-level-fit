<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap">
                    <div>
                        <a href="{{ route('trainer-session-over-pdf') }}" target="_blank" class="btn btn-info">Cetak
                            PDF</a>
                    </div>
                    <div>
                        @if (!empty($trainerSessions))
                            <?php
                            $earliestDate = \Carbon\Carbon::parse($trainerSessions->min('earliest_created_at'))->format('Y-m-d');
                            $latestDate = \Carbon\Carbon::parse($trainerSessions->max('latest_created_at'))->format('Y-m-d');
                            ?>
                            <div class="date-section">
                                <p>{{ $earliestDate }} <b>to</b> {{ $latestDate }}</p>

                                @foreach ($trainerSessions as $session)
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
                        @foreach ($trainerSessions as $item)
                            @php
                                $totalPrice += $item->total_price;
                                $adminPrice += $item->admin_price;
                            @endphp
                        @endforeach

                        <table class="table borderless display dataTable price-table">
                            <tbody>
                                <tr>
                                    <th scope="row">Total Package Price Over</th>
                                    <td>{{ formatRupiah($totalPrice) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total Admin Price over</th>
                                    <td>{{ formatRupiah($adminPrice) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--column-->
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="myTable">
                        <thead>
                            <tr>
                                <th>Member Data</th>
                                <th>Trainer Name</th>
                                <th>Trainer Package</th>
                                <th>Start Date</th>
                                <th>Expired Date</th>
                                <th>Session</th>
                                <th>Status</th>
                                <th>Staff Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainerSessions as $item)
                                <tr>
                                    <td>
                                        <h6>{{ $item->member_name }},</h6>
                                        <h6>{{ $item->member_code }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->trainer_name }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->package_name }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->start_date }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->expired_date }} | @if ($item->expired_date_status == 'Running')
                                                <span class="badge badge-primary">Running</span>
                                            @else
                                                <span class="badge badge-danger">Over</span>
                                            @endif
                                        </h6>
                                    </td>
                                    <td>
                                        <h6>Session Total : {{ $item->number_of_session }}</h6>
                                        <h6>Remaining Session : {{ $item->remaining_sessions }}</h6>
                                    </td>
                                    <td>
                                        @if ($item->session_status == 'Running')
                                            <span class="badge badge-primary">Running</span>
                                        @else
                                            <span class="badge badge-danger">Over</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->staff_name }}
                                    </td>
                                    <td class="btn-group-vertical">
                                        @if (Auth::user()->role == 'ADMIN')
                                            <a href="{{ route('trainer-session.edit', $item->id) }}"
                                                class="btn light btn-warning btn-xs mb-1">Edit</a>
                                        @endif
                                        <a href="{{ route('trainer-session.show', $item->id) }}"
                                            class="btn light btn-info btn-xs mb-1">Detail</a>
                                        @if (Auth::user()->role == 'ADMIN')
                                            <form action="{{ route('trainer-session.destroy', $item->id) }}"
                                                onclick="return confirm('Delete Data ?')" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"
                                                    class="btn light btn-danger btn-xs mb-1 btn-block">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/column-->
        </div>
    </div>
</div>

@include('admin.trainer-session.check-in-2')
