<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <form action="{{ route('members-bulk-delete') }}" method="POST" id="deleteMembersForm">
                @csrf
                @method('delete')
                {{-- <div class="col-xl-12">
                    <div class="page-title flex-wrap justify-content-between">
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                            data-bs-target=".bd-example-modal-lg">+ New Member</button>
                        <a href="{{ route('member-report') }}" target="_blank" class="btn btn-info">Print PDF</a>
                    </div>
                </div> --}}
                <!--column-->
                <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                    <div class="table-responsive full-data">
                        <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                            id="myTable">
                            <thead>
                                <tr>
                                    @if (Auth::user()->role == 'ADMIN')
                                        <th></th>
                                    @endif
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Full Name</th>
                                    <th>Phone Number</th>
                                    <th>Member Code</th>
                                    <th>Date of Birth</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $item)
                                    <tr>
                                        @if (Auth::user()->role == 'ADMIN')
                                            <td><input type="checkbox" name="selected_members[]"
                                                    value="{{ $item->id }}" />
                                            </td>
                                        @endif
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="trans-list">
                                                @if ($item->photos)
                                                    <img src="{{ Storage::url($item->photos ?? '') }}" class="lazyload"
                                                        width="100" alt="image">
                                                @else
                                                    <img src="{{ asset('default.png') }}" width="100"
                                                        class="img-fluid" alt="">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <h6>{{ $item->full_name }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $item->phone_number ?? 'No Data' }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $item->member_code ?? 'No Data' }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ DateFormat($item->born, 'DD MMMM YYYY') ?? 'No Data' }}</h6>
                                        </td>
                                        <td>
                                            <div>
                                                {{-- <button type="button"
                                                    class="btn light btn-warning btn-xs btn-block mb-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target=".bd-example-modal-lg-edit{{ $item->id }}">Edit
                                                    Member</button> --}}
                                                <button type="button" class="btn light btn-info btn-xs btn-block mb-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target=".bd-example-modal-lg-detail{{ $item->id }}">Detail
                                                    Member</button>
                                                @if (Auth::user()->role == 'ADMIN')
                                                    <form action="{{ route('member.destroy', $item->id) }}"
                                                        onclick="return confirm('Delete Data ?')" method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn light btn-danger btn-xs btn-block mb-1">Delete</button>
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
                                onclick="return confirm('Delete selected members?')">Delete Selected</button>
                        @endif
                    </div>
                </div>
            </form>
            <!--/column-->
        </div>
    </div>
</div>


@include('admin.members.create')
@include('admin.members.detail')
