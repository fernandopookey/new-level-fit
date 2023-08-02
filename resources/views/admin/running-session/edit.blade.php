<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('running-session.update', $runningSession->id) }}" method="POST"
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
                            <input type="text" name="member_id"
                                value="{{ old('member_id', $runningSession->members->first_name) }} | {{ old('member_id', $runningSession->members->last_name) }}"
                                class="form-control" id="exampleFormControlInput1" autocomplete="off" disabled>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Personal Trainer</label>
                            <input type="text" name="trainer_id"
                                value="{{ old('personal_trainer_id', $runningSession->personalTrainers->full_name) }}"
                                class="form-control" id="exampleFormControlInput1" autocomplete="off" disabled>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Customer Service</label>
                            <input type="text" name="trainer_id"
                                value="{{ old('customer_service_id', $runningSession->customerServices->full_name) }}"
                                class="form-control" id="exampleFormControlInput1" autocomplete="off" disabled>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Trainer Name</label>
                            <input type="text" name="trainer_package_id"
                                value="{{ old('trainer_package_id', $runningSession->trainerPackages->package_name) }}"
                                class="form-control" id="exampleFormControlInput1" autocomplete="off" disabled>
                        </div>
                    </div>
                    <hr />
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Check Out</label>
                            <div class="input-group clockpicker">
                                <input type="text" class="form-control" name="check_out" autocomplete="off"><span
                                    class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Status</label>
                            <select name="status" class="form-control" aria-label="Default select example">
                                {{-- <option value="{{ $runningSession->status }}" selected>
                                    {{ old('status', $runningSession->status) }}
                                </option> --}}
                                <option value="Over">Over</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Check Out</button>
                <a href="{{ route('running-session.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
</div>
