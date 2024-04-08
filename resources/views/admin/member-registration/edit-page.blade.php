<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('member-active.update', $memberRegistration->id) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="modal-body">
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
                        {{-- <input type="date" id="input1">
                        <input type="date" id="input2"> --}}
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                                <select id="single-select4" name="member_id" class="form-control" required disabled>
                                    <option value="{{ $memberRegistration->member_id }}" selected>
                                        {{ old('member_id', $memberRegistration->members->full_name) }} |
                                        {{ old('member_id', $memberRegistration->members->member_code) }} |
                                        {{ old('member_id', $memberRegistration->members->phone_number) }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Member Package</label>
                                <select name="member_package_id" class="form-control" id="single-select">
                                    <option value="{{ $memberRegistration->member_package_id }}" selected>
                                        {{ old('member_package_id', $memberRegistration->memberPackage->package_name) }}
                                        |
                                        {{ old('member_package_id', FormatRupiah($memberRegistration->package_price)) }}
                                        |
                                        {{ old('member_package_id', FormatRupiah($memberRegistration->admin_price)) }}
                                    </option>
                                    @foreach ($memberPackage as $item)
                                        <option value="{{ $item->id }}">{{ $item->package_name }} |
                                            {{ formatRupiah($item->package_price) }} |
                                            {{ formatRupiah($item->admin_price) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6" id="parentInput1">
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="text" name="start_date" id="input1"
                                    value="{{ old('start_date', DateFormat($memberRegistration->start_date, 'DD MMMM YYYY')) }}"
                                    class="form-control mdate-custom" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6" id="parentInput2">
                            <div class="mb-3">
                                <label class="form-label">Expired Date</label>
                                <input type="text" name="expired_date" id="input2"
                                    value="{{ old('expired_date', DateFormat($memberRegistrations->expired_date, 'DD MMMM YYYY')) }}"
                                    class="form-control mdate-custom" required autocomplete="off">
                            </div>
                        </div>
                        <input type="hidden" id="expired_time" class="form-control editTime" name="expired_time"
                            autocomplete="off">
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Method Payment</label>
                                <select name="method_payment_id" class="form-control" id="single-select5">
                                    <option value="{{ $memberRegistration->method_payment_id }}" selected>
                                        {{ old('method_payment_id', $memberRegistration->methodPayment->name) }}
                                    </option>
                                    @foreach ($methodPayment as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Fitness Consultant</label>
                                <select id="single-select3" name="fc_id" class="form-control">
                                    <option value="{{ $memberRegistration->fc_id }}" selected>
                                        {{ old('fc_id', $memberRegistration->fitnessConsultant->full_name) }}
                                    </option>
                                    @foreach ($fitnessConsultant as $item)
                                        <option value="{{ $item->id }}">{{ $item->full_name }} |
                                            {{ $item->phone_number }}</option>
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
                                    placeholder="Enter Description">{{ old('description', $memberRegistration->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('member-active.index') }}" class="btn btn-info text-right">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
