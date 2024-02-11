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
                                                <img src="{{ Storage::url($item->photos ?? '') }}" class="lazyload"
                                                    width="150" alt="image">
                                            </div>
                                        </td>
                                        <td>
                                            <h6>{{ $item->member_name }},</h6>
                                            <h6>{{ $item->member_code }},</h6>
                                            <h6>{{ $item->phone_number }}</h6>
                                        </td>
                                        <td>
                                            @php
                                                $daysLeft = Carbon\Carbon::parse($item->expired_date)->diffInDays(Carbon\Carbon::now());
                                            @endphp
                                            @if ($daysLeft <= 5)
                                                <span class="badge badge-warning badge-lg">
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
                                            @if ($item->status == 'Running')
                                                <span class="badge badge-primary">Running</span>
                                            @else
                                                <span class="badge badge-danger">Over</span>
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
                                                <a href="{{ route('membership-agreement', $item->id) }}"
                                                    target="_blank"
                                                    class="btn light btn-secondary btn-xs mb-1 btn-block">Agrement</a>
                                                @if ($item->old_days != 0)
                                                    <a href="{{ route('cuti', $item->id) }}" target="_blank"
                                                        class="btn light btn-secondary btn-xs mb-1 btn-block">Cuti</a>
                                                @endif
                                                {{-- <a href="{{ route('member-active.show', $item->id) }}"
                                                class="btn light btn-info btn-xs mb-1 btn-block">Detail</a> --}}
                                                <button type="button" class="btn light btn-info btn-xs btn-block mb-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target=".bd-example-modal-lg-detail{{ $item->id }}">Detail
                                                    Member</button>
                                                <button type="button" class="btn light btn-light btn-xs mb-1 btn-block"
                                                    data-bs-toggle="modal" data-bs-target=".freeze{{ $item->id }}"
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
