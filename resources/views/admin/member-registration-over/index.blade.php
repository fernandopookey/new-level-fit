@inject('carbon', 'Carbon\Carbon')

<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap justify-content-between">
                    <div>
                        <a href="{{ route('print-member-registration-over-pdf') }}" target="_blank"
                            class="btn btn-info">Cetak
                            PDF</a>
                    </div>
                    <div>
                        @if (!empty($memberRegistrationsOver))
                            <?php
                            $earliestDate = \Carbon\Carbon::parse($memberRegistrationsOver->min('earliest_created_at'))->format('Y-m-d');
                            $latestDate = \Carbon\Carbon::parse($memberRegistrationsOver->max('latest_created_at'))->format('Y-m-d');
                            ?>
                            <div class="date-section">
                                <p>{{ $earliestDate }} <b>to</b> {{ $latestDate }}</p>

                                @foreach ($memberRegistrationsOver as $session)
                                    <!-- Your display logic for each session goes here -->
                                @endforeach
                            </div>
                        @else
                            <p>No trainer sessions found.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="page-title flex-wrap">
                    <div>
                        @php
                            $totalPrice = 0;
                            $adminPrice = 0;
                        @endphp
                        @foreach ($memberRegistrationsOver as $item)
                            @php
                                $totalPrice += $item->total_price;
                                $adminPrice += $item->admin_price;
                            @endphp
                        @endforeach

                        <table class="table borderless display dataTable price-table">
                            <tbody>
                                <tr>
                                    <th scope="row">Total Package Price Over</th>
                                    <td>: {{ formatRupiah($totalPrice) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total Admin Price over</th>
                                    <td>: {{ formatRupiah($adminPrice) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                            @foreach ($memberRegistrationsOver as $item)
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
