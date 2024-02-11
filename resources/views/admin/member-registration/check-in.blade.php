@foreach ($memberRegistrations as $item)
    <div class="modal fade freeze{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('member-registration-freeze', $item->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Check In Member</h1>
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
                                    <h5>Member Name</h5>
                                    <input type="text" name="member_code" id="memberCode"
                                        value="{{ old('member_id', $item->member_name) }}" class="form-control"
                                        style="background-color: rgb(231, 229, 229);" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <h5>Member Code</h5>
                                    <input type="text" name="member_code" id="memberCode"
                                        value="{{ old('member_id', $item->member_code) }}" class="form-control"
                                        style="background-color: rgb(231, 229, 229);" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <h5>Member Package</h5>
                                    <input type="text" name="member_code" id="memberCode"
                                        value="{{ old('member_id', $item->package_name) }}" class="form-control"
                                        style="background-color: rgb(231, 229, 229);" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <h5>Days Of Member Package</h5>
                                    <input type="text" name="member_code" id="memberCode"
                                        value="{{ old('member_id', $item->member_registration_days) }}"
                                        class="form-control" style="background-color: rgb(231, 229, 229);" disabled>
                                </div>
                            </div>
                            {{-- <div class="col-xl-12">
                                <div class="mb-3">
                                    <h5>Days Off</h5>
                                    <input type="number" name="days_off" id="memberCode" class="form-control"
                                        autocomplete="off" required>
                                </div>
                            </div>
                            value="2024-03-01"
                            --}}

                            {{-- <div class="col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label> --}}
                            <input type="hidden" name="start_date"
                                value="{{ DateFormat($item->start_date, 'YYYY-MM-DD') }}"
                                class="form-control mdate-custom" required autocomplete="off" readonly>
                            {{-- </div>
                            </div> --}}
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label">Expired Date</label>
                                    <input type="date" name="expired_date"
                                        value="{{ old('expired_date', $item->expired_date) }}"
                                        class="form-control mdate-custom2" required autocomplete="off">
                                </div>
                            </div>
                            {{-- <div class="col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="text" name="start_date" value="{{ old('start_date') }}"
                                        class="form-control editDate2 mdate-custom" placeholder="Choose start date"
                                        required>
                                </div>
                            </div>
                            --}}
                            {{-- <div class="col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Start Time</label>
                                    <div class="input-group clockpicker2" data-placement="left" data-align="top"
                                        data-autobtn-close="true">
                                        <input type="text" class="form-control editTime2" name="start_time"
                                            autocomplete="off" required>
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
