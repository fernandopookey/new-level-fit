<style>
    .fireworks {
        position: relative;
        overflow: hidden;
    }

    .fireworks::after {
        content: "";
        position: absolute;
        width: 100px;
        height: 100px;
        background-image: url('/cake.png');
        background-repeat: no-repeat;
        background-size: contain;
        animation: fireworks 5s linear infinite;
    }

    @keyframes fireworks {
        0% {
            transform: translateY(0) rotateZ(0deg);
            opacity: 0;
        }

        20% {
            opacity: 1;
        }

        50% {
            transform: translateY(-100px) rotateZ(180deg);
            opacity: 0;
        }

        80% {
            transform: translateY(0) rotateZ(360deg);
            opacity: 1;
        }

        100% {
            transform: translateY(0) rotateZ(360deg);
            opacity: 0;
        }
    }
</style>

<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <form action="{{ route('member-active-bulk-delete') }}" method="POST">
                @csrf
                @method('delete')
                <div class="col-xl-12">
                    <div class="page-title flex-wrap justify-content-between">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkIn2"
                            id="checkInButton">Input Member Code</button>
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
                    {{-- <div class="alert alert-warning solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <span>Today is <strong>{{ $birthdayMessage0 }}'s </strong> birthday</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">X
                        </button>
                    </div> --}}
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
                        {{-- <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="example-student"> --}}
                        <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                            id="myTable">
                            <thead>
                                <tr>
                                    @if (Auth::user()->role == 'ADMIN')
                                        <th></th>
                                    @endif
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Member Data</th>
                                    <th>Package Data</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Staff</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($memberRegistrations as $item)
                                    <tr>
                                        @if (Auth::user()->role == 'ADMIN')
                                            <td>
                                                <input type="checkbox" name="selectedMemberActive[]"
                                                    value="{{ $item->id }}">
                                            </td>
                                        @endif
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="trans-list">
                                                @if ($item->photos)
                                                    <img src="{{ Storage::url($item->photos) }}" class="lazyload"
                                                        width="100" alt="image">
                                                @else
                                                    <img src="{{ asset('default.png') }}" class="lazyload"
                                                        width="100" alt="default image">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <h6>{{ $item->member_name }},</h6>
                                            <h6>{{ $item->member_code }},</h6>
                                            <h6>{{ $item->phone_number }}</h6>
                                            {{-- <h6 class="{{ $item->birthdayCelebrating }} text-light">
                                                {{ DateFormat($item->born, 'DD MMMM YYYY') }}
                                            </h6> --}}
                                        </td>
                                        <td>
                                            @php
                                                $daysLeft = Carbon\Carbon::parse($item->expired_date)->diffInDays(Carbon\Carbon::now());
                                            @endphp
                                            @if ($daysLeft <= 5 && $daysLeft == 3)
                                                <span class="badge badge-warning badge-lg">
                                                    <b>{{ $daysLeft }} Days Left</b><br />
                                                    {{ $item->package_name }}, <br />
                                                    {{ formatRupiah($item->package_price) }}, <br />
                                                    {{ $item->member_registration_days }} Days
                                                </span>
                                            @elseif($daysLeft <= 2)
                                                <span class="badge badge-danger badge-lg">
                                                    <b>{{ $daysLeft }} Days Left</b><br />
                                                    {{ $item->package_name }}, <br />
                                                    {{ formatRupiah($item->package_price) }}, <br />
                                                    {{ $item->member_registration_days }} Days
                                                </span>
                                            @else
                                                <span class="badge badge-info badge-lg">
                                                    {{ $item->package_name }}, <br />
                                                    {{ formatRupiah($item->package_price) }}, <br />
                                                    {{ $item->member_registration_days }} Days
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <h6>{{ DateFormat($item->start_date, 'DD MMMM YYYY') }}-{{ DateFormat($item->expired_date, 'DD MMMM YYYY') }}
                                            </h6>
                                        </td>
                                        <td>
                                            {{-- @if ($item->check_in_time == null && $item->check_out_time == null)
                                                <span class="badge badge-primary">Null</span>
                                            @elseif ($item->check_in_time != null && $item->check_out_time == null)
                                                <span class="badge badge-danger">Running</span>
                                            @else
                                                <span class="badge badge-danger">Over</span>
                                            @endif --}}
                                        <td>
                                            <h6>{{ $item->staff_name }}</h6>
                                        </td>
                                        <td>
                                            <div>
                                                @if (Auth::user()->role == 'ADMIN')
                                                    <a href="{{ route('member-active.edit', $item->id) }}"
                                                        class="btn light btn-warning btn-xs mb-1 btn-block">Edit</a>
                                                @endif
                                                <a href="{{ route('membership-agreement', $item->id) }}"
                                                    target="_blank"
                                                    class="btn light btn-secondary btn-xs mb-1 btn-block">Agrement</a>
                                                @if ($item->old_days != 0)
                                                    <a href="{{ route('cuti', $item->id) }}" target="_blank"
                                                        class="btn light btn-secondary btn-xs mb-1 btn-block">Cuti</a>
                                                @endif
                                                <a href="{{ route('member-active.show', $item->id) }}"
                                                    class="btn light btn-info btn-xs mb-1 btn-block">Detail</a>
                                                <button type="button"
                                                    class="btn light btn-light btn-xs mb-1 btn-block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target=".freeze{{ $item->id }}"
                                                    id="checkInButton">Freeze</button>
                                                @if (Auth::user()->role == 'ADMIN')
                                                    <form action="{{ route('member-active.destroy', $item->id) }}"
                                                        onclick="return confirm('Delete Data ?')" method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn light btn-danger btn-xs btn-block mb-1"
                                                            onclick="return confirm('Delete data ?')">Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if (Auth::user()->role == 'ADMIN')
                            <button type="submit" class="btn btn-danger mb-2"
                                onclick="return confirm('Delete selected member active?')">Delete Selected</button>
                        @endif
                    </div>
                </div>
            </form>
            <!--/column-->
        </div>
    </div>
</div>


@include('admin.member-registration.check-in')
@include('admin.member-registration.check-in-2')
