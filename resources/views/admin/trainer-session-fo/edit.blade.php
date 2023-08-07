<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('trainer-session-FO.update', $trainerSessionFO->id) }}" method="POST"
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
                            <label for="exampleFormControlInput1" class="form-label">Active Period</label>
                            <input class="form-control input-daterange-datepicker" type="text" name="active_period"
                                value="{{ old('active_period', $trainerSessionFO->active_period) }}" disabled>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Member Name</label>
                            <select id="single-select" name="member_id" class="form-control" disabled>
                                <option value="{{ $trainerSessionFO->member_id }}" selected>
                                    {{ old('member_id', $trainerSessionFO->members->first_name) }}
                                    {{ old('member_id', $trainerSessionFO->members->last_name) }}
                                </option>
                                @foreach ($members as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->first_name }} {{ $item->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Trainer Name</label>
                            <select id="single-select2" name="trainer_id" class="form-control" disabled>
                                <option value="{{ $trainerSessionFO->trainer_id }}" selected>
                                    {{ old('trainer_id', $trainerSessionFO->trainers->trainer_name) }}
                                </option>
                                @foreach ($trainers as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->trainer_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr />
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Remaining Session</label>
                            <input class="form-control" type="number" name="remaining_session"
                                value="{{ old('remaining_session', $trainerSessionFO->remaining_session) }}" required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Status</label>
                            <select name="status" value="{{ old('status') }}" aria-label="Default select example"
                                class="form-control" required>
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('trainer-session-FO.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
</div>
