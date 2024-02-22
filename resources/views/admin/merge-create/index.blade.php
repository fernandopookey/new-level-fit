{{-- Row bawah ini untuk tabel members --}}
<div class="row" id="memberForm">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('member-second-store') }}" method="POST" enctype="multipart/form-data"
                id="addMemberForm">
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
                            <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                class="form-control" id="exampleFormControlInput1" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="sell"
                                    value="missed_guest" checked>
                                <label class="form-check-label" for="sell">
                                    Missed Guest
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="missed"
                                    value="sell">
                                <label class="form-check-label" for="missed">
                                    Sell
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6" id="nickname">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Nick Name</label>
                                <input type="text" name="nickname" value="{{ old('nickname') }}" class="form-control"
                                    id="exampleFormControlInput1" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6" id="born">
                            <div class="mb-3">
                                <label class="form-label">Born</label>
                                <input type="text" name="born" value="{{ old('born') }}"
                                    class="form-control mdate-custom" placeholder="Choose born date">
                            </div>
                        </div>
                        <div class="col-xl-6" id="member_code">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Member Code</label>
                                <div class="d-flex">
                                    <input type="text" name="member_code" value="{{ old('member_code') }}"
                                        class="form-control" id="exampleFormControlInput1" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6" id="email">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email</label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                    id="exampleFormControlInput1" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6" id="ig">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Instagram</label>
                                <input type="text" name="ig" value="{{ old('ig') }}" class="form-control"
                                    id="exampleFormControlInput1" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6" id="emergency_contact">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Emergency Contact</label>
                                <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}"
                                    class="form-control" id="exampleFormControlInput1" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6" id="gender">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Gender</label>
                                <select name="gender" class="form-control" aria-label="Default select example">
                                    <option disabled selected value>
                                        <- Choose ->
                                    </option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6" id="formFile">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Photo</label>
                                <input class="form-control" type="file" name="photos" onchange="loadFile(event)"
                                    id="formFile">
                            </div>
                            <img id="output" class="img-fluid mt-2 mb-4" width="100" />
                        </div>
                        <div class="col-xl-6" id="address">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label text-primary">
                                    Address
                                </label>
                                <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="6"
                                    placeholder="Enter Address">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Row bawah ini untuk tabel member_registrations --}}
                <div class="row mt-4">
                    <div class="col-xl-6" id="member_package">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Member Package</label>
                            <select id="single-select2" name="member_package_id" class="form-control" required>
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
                    <div class="col-xl-6" id="start_date">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="text" name="start_date" value="{{ old('start_date') }}"
                                class="form-control editDate mdate-custom3" placeholder="Choose start date" required>
                        </div>
                    </div>
                    <input type="hidden" class="form-control editTime" name="start_time" autocomplete="off">
                    <div class="col-xl-6" id="method_payment">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Method Payment</label>
                            <select id="single-select3" name="method_payment_id" class="form-control" required>
                                <option>
                                    <- Choose ->
                                </option>
                                @foreach ($methodPayment as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6" id="fitness_consultant">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Fitness Consultant</label>
                            <select id="single-select4" name="fc_id" class="form-control" required>
                                <option>
                                    <- Choose ->
                                </option>
                                @foreach ($fitnessConsultant as $item)
                                    <option value="{{ $item->id }}">{{ $item->full_name }} |
                                        {{ $item->phone_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6" id="description">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label text-primary">
                                Description
                            </label>
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="6"
                                placeholder="Enter Description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label text-primary">
                                Description
                            </label>
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="6"
                                placeholder="Enter Description">{{ old('description') }}</textarea>
                        </div>
                    </div> --}}
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Save</button>
                    {{-- <a href="{{ route('member-active.index') }}" class="btn btn-info text-right">Member
                        Registration
                        List</a> --}}
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitButton').addEventListener('click', function() {
        document.getElementById('addMemberForm').submit();
    });
</script>
