@inject('carbon', 'Carbon\Carbon')

<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap justify-content-between">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkIn2"
                        id="checkInButton">Check
                        In</button>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="page-title flex-wrap justify-content-between">
                    <a href="{{ route('member-registration.create') }}" target="_blank" class="btn btn-primary">+ New
                        Member
                        Registration</a>
                </div>
            </div>
            <!--column-->
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="table-responsive full-data">
                    {{-- <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="example-student"> --}}
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Member's Data</th>
                                <th>Package Data</th>
                                <th>Start Date</th>
                                <th>Expired Date</th>
                                <th>Description</th>
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
                                        <div class="trans-list">
                                            <img src="{{ Storage::url($item->photos ?? '') }}" class="lazyload"
                                                width="150" alt="image">
                                        </div>
                                    </td>
                                    <td>
                                        <h6>{{ $item->member_name }}</h6>
                                        <h6>{{ $item->member_code }}</h6>
                                        <h6>{{ $item->phone_number }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->package_name }}</h6>
                                        <h6>{{ formatRupiah($item->package_price) }}</h6>
                                        <h6>{{ $item->days }} Days</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->start_date }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->expired_date }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->description }}</h6>
                                    </td>
                                    <td>
                                        @if ($item->status == 'Running')
                                            <span class="badge badge-primary">Running</span>
                                        @else
                                            <span class="badge badge-danger">Over</span>
                                        @endif
                                    </td>
                                    <td>
                                        <h6>{{ $item->staff_name }}</h6>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ route('member-registration.show', $item->id) }}"
                                                class="btn light btn-info btn-xs mb-1 btn-block">Detail</a>
                                            <a href="{{ route('member-registration.edit', $item->id) }}"
                                                class="btn light btn-warning btn-xs mb-1 btn-block">Edit</a>
                                            {{-- <a href="{{ route('print-member-registration-detail-pdf') }}"
                                                class="btn light btn-primary btn-xs mb-1 btn-block"
                                                target="_blank">Detail PDF</a> --}}
                                            <form action="{{ route('member-registration.destroy', $item->id) }}"
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


@include('admin.member-registration.check-in')
@include('admin.member-registration.check-in-2')
