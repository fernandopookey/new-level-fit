<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap justify-content-between">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkIn2"
                        id="checkInButton">Input Card Number</button>
                    <a href="{{ url('/member-active/excel') }}" class="btn btn-info">Download Excel</a>
                </div>
            </div>
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Phone Number</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Staff</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($memberRegistrations as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <h6>{{ $item->member_name }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->phone_number }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ DateFormat($item->start_date, 'DD MMMM YYYY') }}-{{ DateFormat($item->expired_date, 'DD MMMM YYYY') }}
                                        </h6>
                                    </td>
                                    <td>
                                        @if ($item->status == 'Running')
                                            <span class="badge badge-info badge-lg badge-sm">Running</span>
                                        @else
                                            <span class="badge badge-danger badge-lg badge-sm">Expired</span>
                                        @endif
                                    </td>
                                    <td>
                                        <h6>{{ $item->staff_name }}</h6>
                                    </td>
                                    <td>
                                        @php
                                            $now = \Carbon\Carbon::now()->tz('asia/jakarta');
                                        @endphp
                                        @if (Auth::user()->role == 'ADMIN')
                                            <a href="{{ route('member-active.edit', $item->id) }}"
                                                class="btn light btn-warning btn-xs mb-1 btn-block">Edit</a>
                                        @endif
                                        <a href="{{ route('member-active.show', $item->id) }}"
                                            class="btn light btn-info btn-xs mb-1 btn-block">Detail</a>
                                        <button type="button" class="btn light btn-light btn-xs mb-1 btn-block"
                                            data-bs-toggle="modal" data-bs-target=".freeze{{ $item->id }}"
                                            id="checkInButton">Freeze</button>
                                        <a href="{{ route('renewal', $item->id) }}"
                                            class="btn light btn-dark btn-xs mb-1 btn-block">Renewal</a>
                                        @if (Auth::user()->role == 'ADMIN')
                                            <form action="{{ route('member-active.destroy', $item->id) }}"
                                                method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"
                                                    class="btn light btn-danger btn-xs btn-block mb-1"
                                                    onclick="return confirm('Delete {{ $item->member_name }} member package ?')">Delete</button>
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
