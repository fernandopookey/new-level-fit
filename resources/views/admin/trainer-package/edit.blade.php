<!-- Modal Edit -->
@foreach ($trainerPackage as $item => $value)
    <div class="modal fade bd-example-modal-lg" id="modalEdit{{ $value->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('trainer-package.update', $value->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Trainer Package</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
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
                                    <label for="exampleFormControlInput1" class="form-label">Package Name</label>
                                    <input type="text" name="package_name"
                                        value="{{ old('package_name', $value->package_name) }}" class="form-control"
                                        id="exampleFormControlInput1" autocomplete="off" required>
                                </div>
                            </div>
                            {{-- <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Package Type</label>
                                    <select name="package_type_id" class="form-control"
                                        aria-label="Default select example">
                                        <option value="{{ $value->package_type_id }}" selected>
                                            {{ old('package_type_id', $value->trainerPackageType->package_type_name) }}
                                        </option>
                                        @foreach ($trainerPackageType as $item)
                                            <option value="{{ $item->id }}">{{ $item->package_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Number Of Session</label>
                                    <input type="number" name="number_of_session"
                                        value="{{ old('number_of_session', $value->number_of_session) }}"
                                        class="form-control" id="exampleFormControlInput1" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Number Of Days</label>
                                    <input type="number" name="days" value="{{ old('days', $value->days) }}"
                                        class="form-control" id="exampleFormControlInput1" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Package Price</label>
                                    <input type="text" name="package_price"
                                        value="{{ old('package_price', $value->package_price) }}"
                                        class="form-control rupiah" id="exampleFormControlInput1" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Admin Price</label>
                                    <input type="text" name="admin_price"
                                        value="{{ old('admin_price', $value->admin_price) }}"
                                        class="form-control rupiah" id="exampleFormControlInput1" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label text-primary">
                                        Description
                                    </label>
                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="6"
                                        placeholder="Enter Description">{{ old('description', $value->description) }}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-6 mt-4">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="status" value=""
                                            id="flexCheckDefault" {{ $value->status == 'LGT' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            LGT
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
