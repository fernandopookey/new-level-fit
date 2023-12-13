{{-- Button --}}
<div class="row">
    <div class="card">
        <div class="card-body">
            <button class="btn btn-primary" onclick="showForm('memberForm')">Add Member</button>
            <button class="btn btn-primary" onclick="showForm('memberRegistrationForm')">Add Member Registration</button>
            <button class="btn btn-primary" onclick="showForm('trainerSessionForm')">Add Trainer Session</button>
        </div>
    </div>
</div>

{{-- Create Member Data --}}
<div class="row" id="memberForm">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h3>Create Member</h3>
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
                            <label for="exampleFormControlTextarea1" class="form-label text-primary">
                                Address
                            </label>
                            <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="6"
                                placeholder="Enter Address">{{ old('address') }}</textarea>
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
                        <img id="output" class="img-fluid mt-2 mb-4" width="200" />
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('members.index') }}" class="btn btn-info text-right">Member
                        List</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Create Member Registration --}}
<div class="row mt-4" id="memberRegistrationForm">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('member-second-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h3>Create Member Registration</h3>
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
                            <label for="exampleFormControlInput1" class="form-label">Member's Name</label>
                            <select id="single-select4" name="member_id" class="form-control" required>
                                <option>
                                    <- Choose ->
                                </option>
                                @foreach ($members as $item)
                                    <option value="{{ $item->id }}">{{ $item->full_name }} |
                                        {{ $item->member_code ?? 'No member code' }} | {{ $item->phone_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Member Package</label>
                            <select id="single-select" name="member_package_id" class="form-control" required>
                                <option>
                                    <- Choose ->
                                </option>
                                @foreach ($memberPackage as $item)
                                    <option value="{{ $item->id }}">{{ $item->package_name }} |
                                        {{ $item->days }} Days |
                                        {{ formatRupiah($item->package_price) }} |
                                        {{ formatRupiah($item->admin_price) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="text" name="start_date" value="{{ old('start_date') }}"
                                class="form-control editDate" placeholder="Choose start date" id="mdate"
                                required>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="mb-3">
                            <label class="form-label">Start Time</label>
                            <div class="input-group clockpicker" data-placement="left" data-align="top"
                                data-autobtn-close="true">
                                <input type="text" class="form-control editTime" name="start_time"
                                    autocomplete="off" required>
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                            {{-- <input type="text" name="start_time" value="{{ old('start_time') }}"
                                class="form-control" placeholder="Choose start date" id="mdate" required> --}}
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Method Payment</label>
                            <select id="single-select2" name="method_payment_id" class="form-control" required>
                                <option>
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
                            <label for="exampleFormControlTextarea1" class="form-label text-primary">
                                Description
                            </label>
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="6"
                                placeholder="Enter Description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('member-registration.index') }}" class="btn btn-info text-right">Member
                        Registration
                        List</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Create Trainer Session --}}
<div class="row mt-4" id="trainerSessionForm">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('trainer-session.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h3>Create Trainer Session</h3>
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
                            <label for="exampleFormControlInput1" class="form-label">Member Name</label>
                            <select id="single-select5" name="member_id" class="form-control">
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($members as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->full_name }} | {{ $item->member_code ?? 'No member code' }} |
                                        {{ $item->phone_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Trainer Name</label>
                            <select id="single-select6" name="trainer_id" class="form-control">
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($personalTrainers as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->full_name }} | {{ $item->phone_number }} | {{ $item->gender }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Trainer Package</label>
                            <select id="single-select3" name="trainer_package_id" class="form-control">
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($trainerPackages as $item)
                                    <option value="{{ $item->id }}"
                                        data-session="{{ $item->number_of_session }}">
                                        {{ $item->package_name }} | {{ $item->days }} Days |
                                        {{ formatRupiah($item->package_price) }} |
                                        {{ formatRupiah($item->admin_price) }} |
                                        {{ $item->number_of_session }} Sessions
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="text" name="start_date" value="{{ old('start_date') }}"
                                class="form-control editDate" placeholder="Choose start date" id="mdate2"
                                required>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="mb-3">
                            <label class="form-label">Start Time</label>
                            <div class="input-group clockpicker2" data-placement="left" data-align="top"
                                data-autobtn-close="true">
                                <input type="text" class="form-control editTime" name="start_time2"
                                    autocomplete="off" required>
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                            {{-- <input type="text" name="start_time" value="{{ old('start_time') }}"
                                class="form-control" placeholder="Choose start date" id="mdate" required> --}}
                        </div>
                    </div>
                    {{-- <div class="col-xl-6">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="text" name="start_date" value="{{ old('start_date') }}"
                                class="form-control" id="mdate2">
                        </div>
                    </div> --}}
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label text-primary">
                                Description
                            </label>
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="6"
                                placeholder="Enter Description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('trainer-session.index') }}" class="btn btn-info text-right">Trainer Session
                        List</a>
                </div>
            </form>
        </div>
    </div>
</div>
