<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="teacher-deatails">
                <h3 class="heading">Member:</h3>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><b>Full Name</b></th>
                            <th scope="col">{{ $trainerSession->members->full_name }}</th>
                        </tr>
                        <tr>
                            <th scope="col"><b>Member Code</b></th>
                            <th scope="col">{{ $trainerSession->members->member_code }}</th>
                        </tr>
                        <tr>
                            <th scope="col"><b>Phone Number</b></th>
                            <th scope="col">{{ $trainerSession->members->phone_number }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="teacher-deatails">
                <h3 class="heading">Trainer Session Detail:</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><b>Trainer Name</b></th>
                            <th scope="col">{{ $trainerSession->personalTrainers->full_name }}</th>
                        </tr>
                        <tr>
                            <th scope="col"><b>Active Period</b></th>
                            <th scope="col">{{ $trainerSession->active_period }}</th>
                        </tr>
                        <tr>
                            <th scope="col"><b>Session Total</b></th>
                            <th scope="col">{{ $trainerSession->trainerPackages->number_of_session }}</th>
                        </tr>
                        <tr>
                            <th scope="col"><b>Remaining Session</b></th>
                            <th scope="col">{{ $trainerSession->trainerPackages->number_of_session }}</th>
                        </tr>
                        <tr>
                            <th scope="col"><b>Status</b></th>
                            <th scope="col">{{ $trainerSession->status }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="teacher-deatails">
                <h3 class="heading">Trainer Session Check In:</h3>
                <table class="table">
                    <tbody>
                        @foreach ($trainerSessionCheckIn as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->check_in_date }}</td>
                                <td>
                                    <form action="{{ route('trainer-session-check-in.destroy', $item->id) }}"
                                        onclick="return confirm('Delete Data ?')" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn light btn-danger btn-xs mb-1">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('trainer-session.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>
