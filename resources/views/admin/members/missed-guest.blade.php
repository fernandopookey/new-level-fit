<div class="row">
    <div class="col-xl-12">
        <div class="row">
            @csrf
            @method('delete')
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
                                                <img src="{{ Storage::url($item->photos) }}" class="lazyload"
                                                    width="100" alt="image">
                                            @else
                                                <img src="{{ asset('default.png') }}" class="img-fluid" width="100"
                                                    alt="">
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <h6>{{ $item->full_name }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->phone_number }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ isset($item->member_code) ? $item->member_code : '-' }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6>{{ isset($item->description) ? $item->description : '-' }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6>{{ isset($item->user_full_name) ? $item->user_full_name : '-' }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6>{{ DateFormat($item->created_at, 'DD MMMM YYYY') }}</h6>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ route('members.edit', $item->id) }}"
                                                class="btn light btn-warning btn-xs btn-block mb-1">Edit</a>
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
                </div>
            </div>
            <!--/column-->
        </div>
    </div>
</div>
