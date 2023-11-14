@inject('carbon', 'Carbon\Carbon')

<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap justify-content-end">
                    <a href="{{ route('cetak-member-pdf') }}" target="_blank" class="btn btn-info">Cetak PDF</a>
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
                                <th>Image</th>
                                <th>Member Profile</th>
                                <th>Member Package</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>
                                        <div class="trans-list">

                                            @if ($member->count())
                                                <img src="{{ Storage::url($member->photos ?? '') }}" class="lazyload"
                                                    width="200" alt="image">
                                            @else
                                                {{-- <div class="justify-content-center align-items-center"
                                                    style="width: 300px; height: 235px;">
                                                    <p>Tidak Ada Gambar</p>
                                                </div> --}}
                                                <img src="{{ asset('default.png') }}" class="img-fluid" alt="">
                                            @endif

                                            {{-- <img src="{{ Storage::url($member->photos) }}" alt="" width="200"
                                                class="me-3 img-fluid"> --}}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <h6>Member Name : </h6> {{ $member->full_name }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Gender : </h6> {{ $member->gender }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Member Code : </h6> {{ $member->member_code }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Phone Number : </h6> {{ $member->phone_number }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Start Date : </h6> {{ $member->start_date }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Expired Date : </h6> {{ $member->expired_date }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <h6>Member Package : </h6>
                                            {{ !empty($member->memberPackage->package_name) ? $member->memberPackage->package_name : 'Member Package name has  been deleted' }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Source Code : </h6>
                                            {{ !empty($member->sourceCode->name) ? $member->sourceCode->name : 'Source code name has  been deleted' }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Method Payment : </h6>
                                            {{ !empty($member->methodPayment->name) ? $member->methodPayment->name : 'Method payment has  been deleted' }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Sold by : </h6>
                                            {{ !empty($member->users->full_name) ? $member->users->full_name : 'User has  been deleted' }}
                                        </div>
                                        <div class="d-flex">
                                            <h6>Referral Name : </h6>
                                            {{ !empty($member->referralName->full_name) ? $member->referralName->full_name : 'Referral name has  been deleted' }}
                                        </div>
                                        {{-- <div class="d-flex">
                                            <h6>Remaining Time : </h6>
                                            {{ $durationInDays }}
                                        </div> --}}
                                    </td>
                                    <td>
                                        <h6>{{ $member->description }}</h6>
                                    </td>
                                    <td>
                                        @if ($carbon::now()->tz('Asia/Jakarta') < $member->expired_date)
                                            <div class="badge bg-primary">
                                                Active
                                            </div>
                                        @elseif ($carbon::now()->tz('Asia/Jakarta') > $member->expired_date)
                                            <div class="badge bg-danger">
                                                Member package period is over
                                            </div>
                                        @endif

                                        {{-- <?php if ($member->status == 'Active'){ ?>
                                        <div class="badge bg-primary">
                                            Active
                                        </div>
                                        <?php }else{ ?>
                                        <div class="badge bg-danger">
                                            Member package period is over
                                        </div>
                                        <?php } ?> --}}
                                    </td>
                                    <td>
                                        <div>
                                            {{-- <button type="button" class="btn light btn-warning btn-xs mb-1 btn-block"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $member->id }}">Edit</button> --}}
                                            <a href="{{ route('member.edit', $member->id) }}"
                                                class="btn light btn-warning btn-xs mb-1 btn-block">Edit</a>
                                            <form action="{{ route('member.destroy', $member->id) }}"
                                                onclick="return confirm('Delete Data ?')" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"
                                                    class="btn light btn-danger btn-xs btn-block">Delete</button>
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
{{-- @include('admin.member.create')
@include('admin.member.edit') --}}
