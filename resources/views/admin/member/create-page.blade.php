<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('member-second-store') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control"
                                id="exampleFormControlInput1" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Member Code</label>
                            <div class="d-flex">
                                <input type="text" name="member_code" value="{{ old('member_code') }}"
                                    class="form-control" id="exampleFormControlInput1" autocomplete="off" required>
                            </div>
                            @if (!empty($memberLastCode->member_code))
                                <small>*Last member code {{ $memberLastCode->member_code }}</small>
                            @else
                                <small>*No data</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Gender</label>
                            <select name="gender" class="form-control" aria-label="Default select example" required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
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
                            <label for="exampleFormControlInput1" class="form-label">Source Code</label>
                            <select name="source_code_id" class="form-control" aria-label="Default select example"
                                required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($sourceCode as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Member Package</label>
                            <select name="member_package_id" class="form-control" aria-label="Default select example"
                                required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($memberPackage as $item)
                                    <option value="{{ $item->id }}">{{ $item->package_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label class="form-label">Expired Date</label>
                            <input type="text" name="expired_date" value="{{ old('expired_date') }}"
                                class="form-control" placeholder="Choose expired date" id="mdate">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Method Payment</label>
                            <select name="method_payment_id" class="form-control" aria-label="Default select example"
                                required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($methodPayment as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Sold By</label>
                            <select name="sold_by_id" class="form-control" aria-label="Default select example" required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($soldBy as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Refferal Name</label>
                            <select name="refferal_id" class="form-control" aria-label="Default select example"
                                required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($refferalName as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Status</label>
                            <select name="status" class="form-control" value="{{ old('status') }}"
                                aria-label="Default select example" required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label text-primary">
                                Description
                            </label>
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="6"
                                placeholder="Enter Description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Photo</label>
                            <input class="form-control" type="file" name="photos" onchange="loadFile(event)"
                                id="formFile">
                        </div>
                        <img id="output" class="img-fluid mt-2 mb-4" width="300" />
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('member.index') }}" class="btn btn-info text-right">Member List</a>
                </div>
            </form>
        </div>
    </div>
</div>
