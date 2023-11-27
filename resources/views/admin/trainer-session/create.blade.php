<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('trainer-session.store') }}" method="POST" enctype="multipart/form-data">
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
                            <select id="single-select" name="member_id" class="form-control">
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($members as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->full_name }} | {{ $item->member_code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Trainer Name</label>
                            <select id="single-select2" name="trainer_id" class="form-control">
                                <option disabled selected value>
                                    <- Choose ->
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
                            <select id="single-select3" name="trainer_package_id" class="form-control">
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($trainerPackages as $item)
                                    <option value="{{ $item->id }}" data-session="{{ $item->number_of_session }}">
                                        {{ $item->package_name }} | {{ formatRupiah($item->package_price) }} |
                                        {{ $item->number_of_session }} Sessions
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="text" name="start_date" value="{{ old('start_date') }}"
                                class="form-control" id="mdate">
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
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('trainer-session.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
</div>
