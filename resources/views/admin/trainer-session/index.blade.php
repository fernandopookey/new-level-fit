<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap">
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkIn2"
                            id="checkInButton" onclick="manipulateView()">Input Member Code</button>
                    </div>
                </div>
            </div>
            @if ($birthdayMessage2)
                <div class="alert alert-success solid alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span>2 days to <strong>{{ $birthdayMessage2 }}'s </strong> birthday</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">X
                    </button>
                </div>
            @endif
            @if ($birthdayMessage1)
                <div class="alert alert-primary solid alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span>1 days to <strong>{{ $birthdayMessage1 }}'s </strong> birthday</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">X
                    </button>
                </div>
            @endif
            @if ($birthdayMessage0)
                <div class="alert alert-warning solid alert-dismissible fade show fireworks">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span>Today is <strong>{{ $birthdayMessage0 }}'s </strong> birthday</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">X
                    </button>
                </div>
            @endif
            <!--column-->
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Member Data</th>
                                <th>Last Check In</th>
                                <th>Date</th>
                                <th>Session & Status</th>
                                <th>Trainer & Staff</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainerSessions as $item)
                                <tr>
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
                                        <h6>{{ $item->member_phone }}</h6>
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <h6>{{ DateFormat($item->start_date, 'DD MMMM YYYY') }}- <br />
                                            {{ DateFormat($item->expired_date, 'DD MMMM YYYY') }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6>Session Total : {{ $item->number_of_session }}</h6>
                                        <h6>Remaining Session : {{ $item->remaining_sessions }}</h6>
                                        <h6>Status:
                                            @if ((!$item->check_in_time && !$item->check_out_time) || ($item->check_in_time && $item->check_out_time))
                                                <span class="badge badge-info">Not Start</span>
                                            @elseif ($item->check_in_time && !$item->check_out_time)
                                                <span class="badge badge-primary">Running</span>
                                            @endif
                                        </h6>
                                    </td>
                                    <td>
                                        <h6>Trainer : {{ $item->trainer_name }},</h6>
                                        <h6>Staff : {{ $item->staff_name }}</h6>
                                    </td>
                                    <td class="btn-group-vertical">
                                        <a href="{{ route('PTSecondCheckIn', $item->id) }}"
                                            class="btn light btn-info btn-xs mb-1 btn-block">Check In</a>
                                        @if (Auth::user()->role == 'ADMIN')
                                            <a href="{{ route('trainer-session.edit', $item->id) }}"
                                                class="btn light btn-warning btn-xs mb-1">Edit</a>
                                        @endif
                                        <a href="{{ route('pt-agreement', $item->id) }}" target="_blank"
                                            class="btn light btn-secondary btn-xs mb-1 btn-block">Agrement</a>
                                        @if ($item->old_days != 0)
                                            <a href="{{ route('cutiTrainerSession', $item->id) }}" target="_blank"
                                                class="btn light btn-secondary btn-xs mb-1 btn-block">Cuti</a>
                                        @endif
                                        <a href="{{ route('trainer-session.show', $item->id) }}"
                                            class="btn light btn-info btn-xs mb-1">Detail</a>
                                        <button type="button" class="btn light btn-dark btn-xs mb-1 btn-block"
                                            data-bs-toggle="modal" data-bs-target=".freeze{{ $item->id }}"
                                            id="checkInButton">Freeze</button>
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
@include('admin.trainer-session.check-in')
