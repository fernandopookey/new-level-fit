<!-- Modal Add -->
<div class="modal fade" id="modalAddPersonalTrainer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <form action="{{ route('personal-trainer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Personal Trainer</h1>
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
                                <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}"
                                    class="form-control" id="exampleFormControlInput1" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Role</label>
                                <select name="role" class="form-control" aria-label="Default select example">
                                    <option disabled selected value>
                                        <- Choose ->
                                    </option>
                                    <option value="Personal Trainer">Personal Trainer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Gender</label>
                                <select name="gender" class="form-control" aria-label="Default select example"
                                    required>
                                    <option disabled selected value>
                                        <- Choose ->
                                    </option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
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

<!-- Modal Edit -->
@foreach ($personalTrainer as $item)
    <div class="modal fade" id="modalEditPersonalTrainer{{ $item->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <form action="{{ route('personal-trainer.update', $item->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Personal Trainer</h1>
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
                                    <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                                    <input type="text" name="full_name"
                                        value="{{ old('full_name', $item->full_name) }}" class="form-control"
                                        id="exampleFormControlInput1" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Role</label>
                                    <select name="role" class="form-control" aria-label="Default select example">
                                        <option value="{{ $item->role }}" selected>
                                            {{ old('role', $item->role) }}
                                        </option>
                                        <option value="Personal Trainer">Personal Trainer</option>
                                    </select>
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



<div class="tab-pane fade" id="personalTrainer" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <div class="col-xl-12">
                <h4>Personal Trainer List</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-title flex-wrap">
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalAddPersonalTrainer">
                                + New Personal Trainer
                            </button>
                        </div>
                    </div>
                </div>
                <!--column-->
                <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                    <div class="table-responsive full-data">
                        <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                            id="myTable">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($personalTrainer as $item)
                                    <tr>
                                        <td>{{ $item->full_name }}</td>
                                        <td>{{ $item->gender }}</td>
                                        <td>{{ $item->role }}</td>
                                        <td>
                                            <div>
                                                <button type="button"
                                                    class="btn light btn-warning btn-xs mb-1 btn-block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEditPersonalTrainer{{ $item->id }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route('personal-trainer.destroy', $item->id) }}"
                                                    onclick="return confirm('Delete Data ? ')" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn light btn-danger btn-xs btn-block">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/column-->
            </div>
        </div>
    </div>
</div>
