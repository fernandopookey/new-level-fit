<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                {{-- <div class="page-title flex-wrap">
                    <div>
                        <a href="{{ route('trainer-session.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                            New Trainer Session</a>
                    </div>
                    <div>
                        <a href="{{ route('cetak-trainer-session-pdf') }}" target="_blank" class="btn btn-info">Cetak
                            PDF</a>
                    </div>
                </div> --}}
                <div class="page-title flex-wrap">
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkIn2"
                            id="checkInButton">Check
                            In</button>
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
                                <th>No</th>
                                <th>Member Data</th>
                                <th>Trainer Name</th>
                                <th>Trainer Package</th>
                                <th>Start Date</th>
                                <th>Expired Date</th>
                                <th>Session</th>
                                {{-- <th>Number Of Days</th> --}}
                                <th>Status</th>
                                <th>Description</th>
                                <th>Staff Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainerSessions as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <h6>{{ $item->member_name }},</h6>
                                        <h6>{{ $item->member_code }},</h6>
                                        <h6>{{ $item->member_phone }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->trainer_name }},</h6>
                                        <h6>{{ $item->trainer_phone }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->package_name }}, <br /></h6>
                                        <h6>{{ formatRupiah($item->package_price) }},</h6>
                                        <h6>{{ $item->days }}</h6>
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
                                    {{-- <td>
                                        <h6>{{ $item->days }}</h6>
                                    </td> --}}
                                    <td>
                                        @if ($item->session_status == 'Running')
                                            <span class="badge badge-primary">Running</span>
                                        @else
                                            <span class="badge badge-danger">Over</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->description }}</td>
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
