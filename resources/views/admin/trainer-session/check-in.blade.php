@foreach ($trainerSession as $trainerSession => $value)
    <div class="modal fade" id="modalEdit{{ $value->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('trainer-session-check-in.store') }}" method="POST" enctype="multipart/form-data">
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
                            <input type="hidden" name="trainer_session_id" value="{{ $value->id }}">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <h4>Member Name</h4>
                                    {{ old('member_id', $value->members->full_name) }}
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <h4>Trainer Name</h4>
                                    {{ old('member_id', $value->personalTrainers->full_name) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Check In</button>
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
