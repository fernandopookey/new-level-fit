<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('studio-transactions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                id="exampleFormControlInput1" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Booking Date</label>
                            <input type="text" name="booking_date" value="{{ old('booking_date') }}" id="date-format"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                class="form-control" id="exampleFormControlInput1" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Studio Name</label>
                            <input type="text" name="studio_name" value="{{ old('studio_name') }}"
                                class="form-control" id="exampleFormControlInput1" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Studio Package</label>
                            <select name="package_id" class="form-control" aria-label="Default select example" required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($studioPackage as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Role</label>
                            <select name="role" class="form-control" value="{{ old('role') }}"
                                aria-label="Default select example" required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                <option value="Member">Member</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Staff Name</label>
                            <input type="text" name="staff_name" value="{{ old('staff_name') }}" class="form-control"
                                id="exampleFormControlInput1" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-control" value="{{ old('payment_status') }}"
                                aria-label="Default select example" required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('studio-transactions.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
</div>
