@foreach ($members as $member => $item)
    <div class="modal fade bd-example-modal-lg-edit{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('members.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
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
                                    <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                                    <input type="text" name="full_name"
                                        value="{{ old('full_name', $item->full_name) }}" class="form-control"
                                        id="exampleFormControlInput1" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number"
                                        value="{{ old('phone_number', $item->phone_number) }}" class="form-control"
                                        id="exampleFormControlInput1" autocomplete="off" required>
                                </div>
                            </div>

                            @if ($item->status == 'sell')
                                <input type="hidden" name="status" value="sell">
                            @else
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Status</label>
                                        <select name="gender" class="form-control" aria-label="Default select example">
                                            <option value="sell">Sell</option>
                                            <option value="missed_guest">Missed Guest</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-xl-6" id="nickname">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Nick Name</label>
                                    <input type="text" name="nickname" value="{{ old('nickname', $item->nickname) }}"
                                        class="form-control" id="exampleFormControlInput1" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xl-6" id="born">
                                <div class="mb-3">
                                    <label class="form-label">Born</label>
                                    <input type="text" name="born" value="{{ old('born', $item->born) }}"
                                        class="form-control" placeholder="Choose born date" id="mdate">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Member Code</label>
                                    <input type="text" name="member_code"
                                        value="{{ old('member_code', $item->member_code) }}" class="form-control"
                                        id="exampleFormControlInput1" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $item->email) }}"
                                        class="form-control" id="exampleFormControlInput1" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Instagram</label>
                                    <input type="text" name="ig" value="{{ old('ig', $item->ig) }}"
                                        class="form-control" id="exampleFormControlInput1" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Emergency
                                        Contact</label>
                                    <input type="text" name="emergency_contact"
                                        value="{{ old('emergency_contact', $item->emergency_contact) }}"
                                        class="form-control" id="exampleFormControlInput1" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Gender</label>
                                    <select name="gender" class="form-control" aria-label="Default select example">
                                        <option value="{{ $item->gender }}" selected>
                                            {{ old('gender', $item->gender) }}
                                        </option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label text-primary">
                                        Address
                                    </label>
                                    <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="6"
                                        placeholder="Enter Address">{{ old('address', $item->address) }}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Photo</label>
                                    <input class="form-control" type="file" name="photos"
                                        onchange="loadFile(event)" id="formFile">
                                </div>
                                <img id="output" class="img-fluid mt-2 mb-4" width="200" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
