<div class="tab-pane fade" id="appointment" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <div class="col-xl-12">
                <h4>Administrator PT List</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="col-xl-4">
                    <div class="row">
                        <form action="{{ route('appointment-filter') }}">
                            <div class="mb-2">
                                <label for="">Start Date</label>
                                <input type="date" name="startDate" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label for="">End Date</label>
                                <input type="date" name="endDate" class="form-control" required>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block">Search</button>
                            </div>
                        </form>
                        <div class="mt-2 mb-2">
                            <hr />
                        </div>
                        <small>*Klik tombol dibawah ini untuk melihat semua data</small>
                        <form action="{{ route('all-appointment') }}">
                            <div>
                                <button class="btn btn-primary btn-block">Search All</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
