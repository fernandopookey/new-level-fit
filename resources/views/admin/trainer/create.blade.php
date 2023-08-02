<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('trainer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Trainer</h1>
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
                                <label for="exampleFormControlInput1" class="form-label">Trainer Name</label>
                                <input type="text" name="trainer_name" value="{{ old('trainer_name') }}"
                                    class="form-control" id="exampleFormControlInput1" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Member Name</label>
                                <select name="member_id" class="form-control" aria-label="Default select example"
                                    required>
                                    <option disabled selected value>
                                        <- Choose ->
                                    </option>
                                    @foreach ($members as $item)
                                        <option value="{{ $item->id }}">{{ $item->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Trainer Package</label>
                                <select name="trainer_package_id" class="form-control"
                                    aria-label="Default select example" required>
                                    <option disabled selected value>
                                        <- Choose ->
                                    </option>
                                    @foreach ($trainerPackage as $item)
                                        <option value="{{ $item->id }}">{{ $item->package_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Transaction Type</label>
                                <select name="transaction_type_id" class="form-control"
                                    aria-label="Default select example" required>
                                    <option disabled selected value>
                                        <- Choose ->
                                    </option>
                                    @foreach ($trainerTransactionType as $item)
                                        <option value="{{ $item->id }}">{{ $item->transaction_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Method Payment</label>
                                <select name="method_payment_id" class="form-control"
                                    aria-label="Default select example" required>
                                    <option disabled selected value>
                                        <- Choose ->
                                    </option>
                                    @foreach ($methodPayment as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">FC Name</label>
                                <select name="fc_id" class="form-control" aria-label="Default select example"
                                    required>
                                    <option disabled selected value>
                                        <- Choose ->
                                    </option>
                                    @foreach ($fc as $item)
                                        <option value="{{ $item->id }}">{{ $item->full_name }}</option>
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
                                    placeholder="Enter Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Photo</label>
                                <input class="form-control" type="file" name="photos" onchange="loadFile(event)"
                                    id="formFile">
                            </div>
                            <img id="output" class="img-fluid mt-2 mb-4" width="200" />
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
