<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap justify-content-between">
                    <a href="{{ url('/members/create') }}" class="btn btn-info">Download Excel</a>
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
                                <th>Full Name</th>
                                <th>Phone Number</th>
                                <th>No Member</th>
                                <th>Date of Birth</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="trans-list">
                                            @if ($item->photos)
                                                <img src="{{ Storage::url($item->photos ?? '') }}" class="lazyload"
                                                    width="100" alt="image">
                                            @else
                                                <img src="{{ asset('default.png') }}" width="100" class="img-fluid"
                                                    alt="">
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
                                        <h6>{{ DateFormat($item->created_at, 'DD MMMM YYYY') ?? 'No Data' }}</h6>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ route('edit-member-sell', $item->id) }}"
                                                class="btn light btn-warning btn-xs btn-block mb-1">Edit
                                                Member</a>
                                            <a href="{{ route('members.show', $item->id) }}"
                                                class="btn light btn-info btn-xs btn-block mb-1">Detail Member</a>
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
            <!--/column-->
        </div>
    </div>
</div>
