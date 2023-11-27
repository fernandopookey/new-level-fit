<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('member-registration.update', $memberRegistration->id) }}" method="POST"
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
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                                <select id="single-select4" name="member_id" class="form-control" required disabled>
                                    <option value="{{ $memberRegistration->members->member_id }}" selected>
                                        {{ old('member_id', $memberRegistration->members->full_name) }} |
                                        {{ old('member_id', $memberRegistration->members->member_code) }} |
                                        {{ old('member_id', $memberRegistration->members->gender) }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Member Package</label>
                                <select name="member_package_id" class="form-control" id="single-select" disabled>
                                    <option value="{{ $memberRegistration->member_package_id }}" selected>
                                        {{ old('member_package_id', $memberRegistration->memberPackage->package_name) }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="text" name="start_date"
                                    value="{{ old('start_date', $memberRegistration->start_date) }}"
                                    class="form-control" placeholder="Choose start date" id="mdate" required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Method Payment</label>
                                <select name="method_payment_id" class="form-control" id="single-select5" disabled>
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
                                <label for="exampleFormControlInput1" class="form-label">Refferal Name</label>
                                <select name="refferal_id" class="form-control" id="single-select3" disabled>
                                    <option value="{{ $memberRegistration->refferal_id }}" selected>
                                        @if (isset($memberRegistration->referralName->full_name))
                                            {{ old('refferal_id', $memberRegistration->referralName->full_name) }}
                                        @else
                                            <- Choose ->
                                        @endif
                                    </option>
                                    @foreach ($referralName as $item)
                                        <option value="{{ $item->id }}">{{ $item->full_name }} | Fitness
                                            Consultant</option>
                                    @endforeach
                                    @foreach ($members as $item)
                                        <option value="{{ $item->id }}">{{ $item->full_name }} | Member</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Status</label>
                                <select name="status" class="form-control" value="{{ old('status') }}"
                                    aria-label="Default select example" required>
                                    <option value="{{ $member->status }}" selected>
                                        {{ old('status', $member->status) }}
                                    </option>
                                    <option value="Running">Running</option>
                                    <option value="Over">Over</option>
                                </select>
                            </div>
                        </div> --}}
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
                    <a href="{{ route('member-registration.index') }}" class="btn btn-info text-right">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
