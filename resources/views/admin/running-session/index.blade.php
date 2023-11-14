<div class="row">
    <div class="col-xl-12">
        <div class="row">
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
                                <th>Check In</th>
                                <th>Status</th>
                                <th>Staff Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($runningSession as $item)
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
