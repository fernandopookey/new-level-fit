<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap justify-content-between">
                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                        data-bs-target=".bd-example-modal-lg">+ New Member</button>
                    <a href="{{ route('member-report') }}" target="_blank" class="btn btn-info">Print PDF</a>
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
                                <th>Image</th>
                                <th>Member Name</th>
                                <th>Member Code</th>
                                <th>gender</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Description</th>
                                <th>Staff</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="trans-list">
                                            @if ($item->count())
                                                <img src="{{ Storage::url($item->photos ?? '') }}" class="lazyload"
                                                    width="150" alt="image">
                                            @else
                                                <img src="{{ asset('default.png') }}" class="img-fluid" alt="">
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <h6>{{ $item->full_name }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->member_code }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->gender }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->phone_number }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->address }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->description }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->users->full_name }}</h6>
                                    </td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn light btn-warning btn-xs btn-block mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target=".bd-example-modal-lg-edit{{ $item->id }}">Edit
                                                Member</button>
                                            <form action="{{ route('member.destroy', $item->id) }}"
                                                onclick="return confirm('Delete Data ?')" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"
                                                    class="btn light btn-danger btn-xs btn-block mb-1">Delete</button>
                                            </form>
                                        </div>
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


@include('admin.members.create')
@include('admin.members.edit')
