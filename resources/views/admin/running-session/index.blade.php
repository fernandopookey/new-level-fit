<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap">
                    <div class="input-group search-area mb-md-0 mb-3">
                        <input type="text" class="form-control" placeholder="Search here...">
                        <span class="input-group-text"><a href="javascript:void(0)">
                                <svg width="15" height="15" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.5605 15.4395L13.7527 11.6317C14.5395 10.446 15 9.02625 15 7.5C15 3.3645 11.6355 0 7.5 0C3.3645 0 0 3.3645 0 7.5C0 11.6355 3.3645 15 7.5 15C9.02625 15 10.446 14.5395 11.6317 13.7527L15.4395 17.5605C16.0245 18.1462 16.9755 18.1462 17.5605 17.5605C18.1462 16.9747 18.1462 16.0252 17.5605 15.4395V15.4395ZM2.25 7.5C2.25 4.605 4.605 2.25 7.5 2.25C10.395 2.25 12.75 4.605 12.75 7.5C12.75 10.395 10.395 12.75 7.5 12.75C4.605 12.75 2.25 10.395 2.25 7.5V7.5Z"
                                        fill="#01A3FF" />
                                </svg>
                            </a></span>
                    </div>
                    <div>
                        <a href="{{ route('running-session.create') }}" class="btn btn-primary"><i
                                class="fa fa-plus"></i> New Running Session</a>
                    </div>
                </div>
            </div>
            <!--column-->
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="example-student">
                        <thead>
                            <tr>
                                <th>Member Name</th>
                                <th>Member Code</th>
                                <th>Date Time</th>
                                <th>Trainer Package</th>
                                <th>Session Total</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Status</th>
                                <th>PT Name</th>
                                <th>CS Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($runningSession as $item)
                                <tr>
                                    <td>
                                        {{ !empty($item->members->first_name) ? $item->members->first_name : 'Member has  been deleted' }}
                                        |
                                        {{ !empty($item->members->last_name) ? $item->members->last_name : 'Member has  been deleted' }}
                                    </td>
                                    <td>
                                        {{ !empty($item->members->member_code) ? $item->members->member_code : 'Member has  been deleted' }}
                                    </td>
                                    <td>{{ $item->date_time }}</td>
                                    <td>
                                        {{ !empty($item->trainerPackages->package_name) ? $item->trainerPackages->package_name : 'Trainer has  been deleted' }}
                                    </td>
                                    <td>{{ $item->session_total }}</td>
                                    <td>{{ $item->check_in }}</td>
                                    <td>
                                        {{ !empty($item->check_out) ? $item->check_out : '-' }}
                                    </td>
                                    <td>
                                        @if ($item->status == 'Running')
                                            <div class="badge bg-primary">
                                                Running
                                            </div>
                                        @else
                                            <div class="badge bg-danger">
                                                This Member Has Already Checkout
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ !empty($item->personalTrainers->full_name) ? $item->personalTrainers->full_name : 'Personal Trainer has  been deleted' }}
                                    </td>
                                    <td>
                                        {{ !empty($item->customerServices->full_name) ? $item->customerServices->full_name : 'Personal Trainer has  been deleted' }}
                                    </td>
                                    <td>{{ $item->description }}</td>
                                    <td class="btn-group-vertical">
                                        @if ($item->check_out == null)
                                            <a href="{{ route('running-session.edit', $item->id) }}"
                                                class="btn light btn-warning btn-xs mb-1">Check Out</a>
                                        @else
                                            <button disabled="disabled" class="btn btn-warning btn-xs mb-1">Check
                                                Out</button>
                                            {{-- <p>This Member Has Already Check Out</p> --}}
                                        @endif


                                        <form action="{{ route('running-session.destroy', $item->id) }}"
                                            onclick="return confirm('Delete Data ?')" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn light btn-danger btn-xs">Delete</button>
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
