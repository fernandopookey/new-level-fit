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
                            <select id="single-select" name="trainer_id" class="form-control">
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
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="text" name="start_date"
                                value="{{ old('start_date', $trainerSession->start_date) }}" class="form-control"
                                id="mdate">
                        </div>
                    </div>
                    {{-- <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Remaining Session</label>
                            <input class="form-control" type="number" name="remaining_session"
                                value="{{ old('remaining_session', $trainerSession->remaining_session) }}" required>
                        </div>
                    </div> --}}
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Status</label>
                            <select id="single-select2" name="status" value="{{ old('status') }}"
                                aria-label="Default select example" class="form-control" required>
                                <option value="{{ $trainerSession->status }}" selected>
                                    {{ old('status', $trainerSession->status) }}
                                </option>
                                <option value="Running">Running</option>
                                <option value="Over">Over</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('trainer-session.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
</div>
