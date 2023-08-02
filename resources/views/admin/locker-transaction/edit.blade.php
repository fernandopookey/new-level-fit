<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('locker-transaction.update', $lockerTransaction->id) }}" method="POST"
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
                            <select id="single-select" name="member_id" class="form-control">
                                <option value="{{ $lockerTransaction->member_id }}" selected>
                                    {{ old('member_id', $lockerTransaction->members->first_name) }}
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
                            <label for="exampleFormControlInput1" class="form-label">Active Period</label>
                            <input name="active_period" class="datepicker-default form-control"
                                value="{{ old('active_period', $lockerTransaction->active_period) }}" id="datepicker"
                                required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Locker Package</label>
                            <select id="single-select2" name="locker_package" class="form-control">
                                <option value="{{ $lockerTransaction->locker_package }}" selected>
                                    {{ old('locker_package', $lockerTransaction->lockerPackage->package_name) }}
                                </option>
                                @foreach ($lockerPackage as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->package_name }} | {{ formatRupiah($item->package_price) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Status</label>
                            <select id="single-select2" name="status" value="{{ old('status') }}"
                                aria-label="Default select example" class="form-control" required>
                                <option value="{{ $lockerTransaction->status }}" selected>
                                    {{ old('status', $lockerTransaction->status) }}
                                </option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">CS Name</label>
                            <select id="single-select3" name="cs_name" class="form-control">
                                <option value="{{ $lockerTransaction->cs_name }}" selected>
                                    {{ old('cs_name', $lockerTransaction->cs->full_name) }}
                                </option>
                                @foreach ($cs as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->full_name }}
                                    </option>
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
                                placeholder="Enter Description">{{ old('description', $lockerTransaction->description) }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('locker-transaction.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
</div>
