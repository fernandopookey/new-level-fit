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
            </div>
            <!--column-->
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="myTable">
                        <thead>
                            <tr>
                                <th>Member Data</th>
                                <th>Trainer Data</th>
                                <th>Start Date</th>
                                <th>Session</th>
                                <th>Check-In</th>
                                <th>Status</th>
                                <th>Staff Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainerSession as $item)
                                <tr>
                                    @php
                                        $remainingSessions = optional($item->trainerSession)->remaining_session ?? 0;
                                        $remainingSessions = $item->trainerSessionCheckIn->count();
                                        $totalSessions = $item->trainerPackages->number_of_session;
                                        $result = $remainingSessions - $totalSessions;
                                    @endphp
                                    <td>
                                        <div class="d-flex">
                                            <h6>Member Name : </h6>
                                            {{ !empty($item->members->full_name) ? $item->members->full_name : 'Member has  been deleted' }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Member Code : </h6>
                                            {{ !empty($item->members->member_code) ? $item->members->member_code : 'Member has  been deleted' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <h6>Trainer Name : </h6>
                                            {{ !empty($item->personalTrainers->full_name) ? $item->personalTrainers->full_name : 'Trainer has  been deleted' }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Trainer Package : </h6>
                                            {{ !empty($item->trainerPackages->package_name) ? $item->trainerPackages->package_name : 'Trainer has  been deleted' }}
                                        </div>
                                    </td>
                                    <td>{{ $item->start_date }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <h6>Session Total : </h6>
                                            {{ !empty($item->trainerPackages->number_of_session) ? $item->trainerPackages->number_of_session : 'Trainer package has  been deleted' }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Remaining Session : {{ abs($result) }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#">Lihat</a>
                                    </td>
                                    <td>
                                        @if ($result == 0)
                                            <div class="badge bg-danger">
                                                Trainer session is Over
                                            </div>
                                        @else
                                            <div class="badge bg-primary">
                                                Running
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ !empty($item->users->full_name) ? $item->users->full_name : 'User has  been deleted' }}
                                    </td>
                                    <td class="btn-group-vertical">
                                        @if ($result == 0)
                                            <button type="button" class="btn light btn-primary btn-xs mb-1 btn-block"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}"
                                                disabled>Check
                                                In</button>
                                        @else
                                            <button type="button" class="btn light btn-primary btn-xs mb-1 btn-block"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $item->id }}">Check
                                                In</button>
                                        @endif
                                        <a href="{{ route('trainer-session.edit', $item->id) }}"
                                            class="btn light btn-warning btn-xs mb-1">Edit</a>
                                        <a href="{{ route('trainer-session.show', $item->id) }}"
                                            class="btn light btn-info btn-xs mb-1">Detail</a>
                                        {{-- <a class="btn btn-info  btn-xs"
                                            onclick="openTrainerSessionDetail(<?php echo $item->id; ?>)"><i
                                                class="fa fa-search"></i>Detail</a> --}}
                                        <form action="{{ route('trainer-session.destroy', $item->id) }}"
                                            onclick="return confirm('Delete Data ?')" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit"
                                                class="btn light btn-danger btn-xs mb-1">Delete</button>
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

@include('admin.trainer-session.check-in')
