<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap">
                    <div>
                        <a href="{{ route('trainer-session.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                            New Trainer Session</a>
                    </div>
                    <div>
                        <a href="{{ route('cetak-trainer-session-pdf') }}" target="_blank" class="btn btn-info">Cetak
                            PDF</a>
                    </div>
                </div>
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
                                <th>Member Data</th>
                                <th>Trainer Name</th>
                                <th>Trainer Package</th>
                                <th>Start Date</th>
                                <th>Session Total</th>
                                <th>Remaining Session</th>
                                <th>Status</th>
                                <th>Description</th>
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
                                        <h6>{{ $item->number_of_session }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->remaining_sessions }}</h6>
                                    </td>
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
                                        <a href="{{ route('trainer-session.edit', $item->id) }}"
                                            class="btn light btn-warning btn-xs mb-1">Edit</a>
                                        <a href="{{ route('trainer-session.show', $item->id) }}"
                                            class="btn light btn-info btn-xs mb-1">Detail</a>
                                        <form action="{{ route('trainer-session.destroy', $item->id) }}"
                                            onclick="return confirm('Delete Data ?')" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit"
                                                class="btn light btn-danger btn-xs mb-1 btn-block">Delete</button>
                                        </form>
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
