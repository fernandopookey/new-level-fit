<!-- Modal Add -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <form action="{{ route('member-package.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Member Package</h1>
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
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Package Name</label>
                                <input type="text" name="package_name" value="{{ old('package_name') }}"
                                    class="form-control" id="exampleFormControlInput1" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Number Of Days</label>
                                <input type="number" name="days" value="{{ old('days') }}" class="form-control"
                                    id="exampleFormControlInput1" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Package Type</label>
                                <select name="package_type_id" class="form-control" aria-label="Default select example"
                                    required>
                                    <option disabled selected value>
                                        <- Choose ->
                                    </option>
                                    @foreach ($memberPackageType as $item)
                                        <option value="{{ $item->id }}">{{ $item->package_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Package Category</label>
                                <select name="package_category_id" class="form-control"
                                    aria-label="Default select example" required>
                                    <option disabled selected value>
                                        <- Choose ->
                                    </option>
                                    @foreach ($memberPackageCategories as $item)
                                        <option value="{{ $item->id }}">{{ $item->package_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Package Price</label>
                                <input type="text" name="package_price" value="{{ old('package_price') }}"
                                    class="form-control rupiah" id="exampleFormControlInput1" autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Admin Price</label>
                                <input type="text" name="admin_price" value="{{ old('admin_price') }}"
                                    class="form-control rupiah" id="exampleFormControlInput1" autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Joining Price</label>
                                <input type="text" name="joining_price" value="{{ old('joining_price') }}"
                                    class="form-control rupiah" id="exampleFormControlInput1" autocomplete="off"
                                    required>
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
