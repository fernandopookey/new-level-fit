<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('member.update', $member->id) }}" method="POST" enctype="multipart/form-data">
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
                                <input type="text" name="full_name"
                                    value="{{ old('full_name', $member->full_name) }}" class="form-control"
                                    id="exampleFormControlInput1" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Gender</label>
                                <select name="gender" class="form-control" aria-label="Default select example">
                                    <option value="{{ $member->gender }}" selected>
                                        {{ old('gender', $member->gender) }}
                                    </option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number"
                                    value="{{ old('phone_number', $member->phone_number) }}" class="form-control"
                                    id="exampleFormControlInput1" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Source Code</label>
                                <select name="source_code_id" class="form-control" aria-label="Default select example">
                                    <option value="{{ $member->source_code_id }}" selected>
                                        {{ old('source_code_id', $member->sourceCode->name) }}
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
                                <select name="member_package_id" class="form-control" id="single-select">
                                    <option value="{{ $member->member_package_id }}" selected>
                                        {{ old('member_package_id', $member->memberPackage->package_name) }}
                                    </option>
                                    @foreach ($memberPackage as $item)
                                        <option value="{{ $item->id }}">{{ $item->package_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Method Payment</label>
                                <select name="method_payment_id" class="form-control"
                                    aria-label="Default select example">
                                    <option value="{{ $member->method_payment_id }}" selected>
                                        {{ old('method_payment_id', $member->methodPayment->name) }}
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
                                <select name="fc_id" class="form-control" id="single-select2">
                                    {{-- <option value="{{ $member->fitnessConsultant }}" selected>
                                        @if (isset($member->fitnessConsultant->full_name))
                                            {{ old('fc_id', $member->fitnessConsultant->full_name) }}
                                        @else
                                            <- Choose ->
                                        @endif
                                    </option> --}}
                                    @foreach ($fitnessConsultant as $item)
                                        <option value="{{ $item->id }}">{{ $item->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Refferal Name</label>
                                <select name="refferal_id" class="form-control" id="single-select3">
                                    <option value="{{ $member->refferal_id }}" selected>
                                        @if (isset($member->referralName->full_name))
                                            {{ old('refferal_id', $member->referralName->full_name) }}
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
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Status</label>
                                <select name="status" class="form-control" value="{{ old('status') }}"
                                    aria-label="Default select example" required>
                                    <option value="{{ $member->status }}" selected>
                                        {{ old('status', $member->status) }}
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
                                    placeholder="Enter Description">{{ old('description', $member->description) }}</textarea>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Photo</label>
                                <input class="form-control" type="file" name="photos" onchange="loadFile(event)"
                                    id="formFile">
                                <img src="{{ Storage::disk('local')->url($member->photos) }}" class="img-fluid mt-4"
                                    width="200" alt="">
                            </div>
                            <img id="outputEdit" class="img-fluid mb-4" width="200">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('member.index') }}" class="btn btn-info text-right">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
