<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('running-session.store') }}" method="POST" enctype="multipart/form-data">
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
                            <select id="single-select" name="member_id" class="form-control" required
                                autocomplete="off">
                                <option disabled selected value>
                                    <- Choose ->
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
                            <label for="exampleFormControlInput1" class="form-label">Date Time</label>
                            <input type="text" id="date-format" class="form-control" name="date_time" required
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Trainer Package</label>
                            <select id="single-select2" name="trainer_package_id" class="form-control" required
                                autocomplete="off">
                                <option disabled selected value>
                                    <- Choose ->
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
                            <label for="exampleFormControlInput1" class="form-label">Session Total</label>
                            <input class="form-control" type="number" name="session_total" required autocomplete="off">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Check In</label>
                            <div class="input-group clockpicker">
                                <input type="text" class="form-control" name="check_in" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Status</label>
                            <select name="status" value="{{ old('status') }}" aria-label="Default select example"
                                class="form-control" required autocomplete="off">
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                <option value="Running">Running</option>
                                {{-- <option value="Over">Over</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Personal Trainer</label>
                            <select id="single-select3" name="personal_trainer_id" class="form-control" required
                                autocomplete="off">
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
                            <label for="exampleFormControlInput1" class="form-label">Customer Service</label>
                            <select id="single-select4" name="customer_service_id" class="form-control" required
                                autocomplete="off">
                                <option disabled selected value>
                                    <- Choose ->
                                </option>
                                @foreach ($customerServices as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Description</label>
                            <textarea class="form-control" name="description" cols="10" rows="5" autocomplete="off"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('running-session.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
</div>
