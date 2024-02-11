<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="teacher-deatails">
                <h3 class="heading">Member's Data:</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th><b>Full Name</b></th>
                            <th>{{ $memberRegistration->member_name }}</th>
                        </tr>
                        <tr>
                            <th><b>Phone Number</b></th>
                            <th>{{ $memberRegistration->phone_number }}</th>
                        </tr>
                        <tr>
                            <th><b>Nick Name</b></th>
                            <th>{{ $memberRegistration->nickname }}</th>
                        </tr>
                        <tr>
                            <th><b>Member Code</th>
                            <th>{{ $memberRegistration->member_code }}</th>
                        </tr>
                        <tr>
                            <th><b>Gender</b></th>
                            <th>{{ $memberRegistration->gender }}</th>
                        </tr>
                        <tr>
                            <th><b>Date of Birth</b></th>
                            <th>{{ $memberRegistration->born }}</th>
                        </tr>
                        <tr>
                            <th><b>Email</b></th>
                            <th>{{ $memberRegistration->email }}</th>
                        </tr>
                        <tr>
                            <th><b>Instagram</b></th>
                            <th>{{ $memberRegistration->ig }}</th>
                        </tr>
                        <tr>
                            <th><b>Emergency Contact</b></th>
                            <th>{{ $memberRegistration->emergency_contact }}</th>
                        </tr>
                        <tr>
                            <th><b>Address</b></th>
                            <th>{{ $memberRegistration->address }}</th>
                        </tr>
                        <tr>
                            <th><b>Description</b></th>
                            <th>{{ $memberRegistration->description }}</th>
                        </tr>
                        <tr>
                            <th><b>Start Date</b></th>
                            <th>{{ $memberRegistration->start_date }}</th>
                        </tr>
                        <tr>
                            <th><b>Expired Date</b></th>
                            <th>{{ $memberRegistration->expired_date }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="card-body">
            <div class="">
                <h3 class="heading">Package Info:</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th><b>Package Name</b></th>
                            <th>{{ $memberRegistration->package_name }}</th>
                        </tr>
                        <tr>
                            <th><b>Number Of Days</th>
                            <th>{{ $memberRegistration->days }} Days</th>
                        </tr>
                        <tr>
                            <th><b>Package Price</b></th>
                            <th>{{ formatRupiah($memberRegistration->package_price) }}</th>
                        </tr>
                        <tr>
                            <th><b>Method Payment</b></th>
                            <th>{{ $memberRegistration->method_payment_name }}</th>
                        </tr>

                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <h3 class="heading">Check In:</h3>
            <form action="{{ route('bulk-delete-member-registration') }}" method="POST">
                @csrf
                @method('delete')
                <table class="table">
                    <thead>
                        <tr>
                            @if (Auth::user()->role == 'ADMIN')
                                <td>Checklist</td>
                            @endif
                            <th>No</th>
                            <th>Check In Date</th>
                            <th>Staff</th>
                            @if (Auth::user()->role == 'ADMIN')
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($memberRegistrationCheckIn as $item)
                            <tr>
                                @if (Auth::user()->role == 'ADMIN')
                                    <td><input type="checkbox" name="selectedItems[]" value="{{ $item->id }}"></td>
                                @endif
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->check_in_date }}</td>
                                <td>{{ $item->users->full_name }}</td>
                                @if (Auth::user()->role == 'ADMIN')
                                    <td>
                                        <form action="{{ route('member-check-in.destroy', $item->id) }}"
                                            onclick="return confirm('Delete Data ?')" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit"
                                                class="btn light btn-danger btn-xs mb-1">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (Auth::user()->srole == 'ADMIN')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Delete Data Checklist ?')">Delete Check</button>
                @endif
            </form>
        </div>
    </div>
</div>

@if ($memberRegistration->status == 'Running')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('member-active.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
@else
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('member-expired.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
@endif
