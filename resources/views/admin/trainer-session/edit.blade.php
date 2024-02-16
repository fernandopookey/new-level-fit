<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('trainer-session.update', $trainerSession->id) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
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
                            <label for="exampleFormControlInput1" class="form-label">Member Name</label>
                            <select id="single-select" name="member_id" class="form-control" disabled>
                                <option value="{{ $trainerSession->member_id }}" selected>
                                    {{ old('member_id', $trainerSession->members->full_name) }}
                                </option>
                                @foreach ($members as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->first_name }} | {{ $item->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Trainer Name</label>
                            <select id="single-select2" name="trainer_id" class="form-control">
                                <option value="{{ $trainerSession->trainer_id }}" selected>
                                    {{ old('trainer_id', $trainerSession->personalTrainers->full_name) }}
                                </option>
                                @foreach ($personalTrainers as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Trainer Package</label>
                            <select id="single-select2" name="trainer_package_id" class="form-control" disabled>
                                <option value="{{ $trainerSession->trainer_package_id }}" selected>
                                    {{ old('trainer_package_id', $trainerSession->trainerPackages->package_name) }}
                                </option>
                                @foreach ($trainerPackages as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->package_name }} | {{ formatRupiah($item->package_price) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="text" name="start_date"
                                value="{{ old('start_date', DateFormat($trainerSession->start_date, 'DD MMMM YYYY')) }}"
                                class="form-control mdate-custom">
                            {{-- <input type="text" name="start_date"
                                value="{{ old('start_date', date('Y-m-d', strtotime($trainerSession->start_date))) }}"
                                class="form-control mdate-custom" id="mdate"> --}}
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="mb-3">
                            <label class="form-label">Start Time</label>
                            <div class="input-group clockpicker" data-placement="left" data-align="top"
                                data-autobtn-close="true">
                                <input type="text" class="form-control" name="start_time"
                                    value="{{ old('start_time', date('H:i', strtotime($trainerSession->start_date))) }}"
                                    autocomplete="off">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Method Payment</label>
                            <select id="single-select10" name="method_payment_id" class="form-control">
                                <option value="{{ $trainerSession->method_payment_id }}" selected>
                                    {{ old('method_payment_id', $trainerSession->methodPayment->name) }}
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
                            <select id="single-select8" name="fc_id" class="form-control" required>
                                <option value="{{ $trainerSession->fc_id }}" selected>
                                    {{ old('fc_id', $trainerSession->fitnessConsultants->full_name) }}
                                </option>
                                @foreach ($fitnessConsultants as $item)
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
                                placeholder="Enter Description">{{ old('description', $trainerSession->description) }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('trainer-session.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
</div>
