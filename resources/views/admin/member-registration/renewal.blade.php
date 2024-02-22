<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('renewMemberRegistration', $memberRegistration->id) }}" method="POST"
                enctype="multipart/form-data">
                {{-- @method('PUT') --}}
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
                        {{-- <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Full Name</label> --}}
                        {{-- <input type="hidden" name="member_id"
                                    value="{{ $memberRegistration->members->member_id }}"> --}}
                        <input type="hidden" name="member_id" value="{{ $memberRegistration->id }}">
                        <input type="hidden" value="{{ $memberRegistration->members->full_name }}" class="form-control"
                            readonly>
                        {{-- </div>
                        </div> --}}
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Member Package</label>
                                <select name="member_package_id" class="form-control" id="single-select">
                                    <option value="{{ $memberRegistration->member_package_id }}" selected>
                                        {{ old('member_package_id', $memberRegistration->memberPackage->package_name) }}
                                    </option>
                                    @foreach ($memberPackage as $item)
                                        <option value="{{ $item->id }}">{{ $item->package_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="text" name="start_date"
                                    value="{{ old('start_date', date('Y-m-d', strtotime($memberRegistration->start_date))) }}"
                                    class="form-control" id="mdate" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="mb-3">
                                <label class="form-label">Start Time</label>
                                <div class="input-group clockpicker" data-placement="left" data-align="top"
                                    data-autobtn-close="true">
                                    <input type="text" class="form-control" name="start_time"
                                        value="{{ old('start_time', date('H:i', strtotime($memberRegistration->start_date))) }}"
                                        autocomplete="off">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                </div>
                            </div>
                        </div>
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
                        <div class="col-xl-6" id="fitness_consultant">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Fitness Consultant</label>
                                <select id="single-select3" name="fc_id" class="form-control" required>
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
                    <button type="submit" class="btn btn-primary">Renewal</button>
                    <a href="{{ route('member-active.index') }}" class="btn btn-info text-right">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
