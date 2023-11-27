{{-- MEMBER --}}
<div class="row">
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-primary">
            <div class="card-body p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Total Members</p>
                        <h3 class="text-white">{{ $totalMember }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-success">
            <div class="card-body p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Total Member Registration</p>
                        <h3 class="text-white">{{ $memberRegistration }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-danger">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Member Registration Running</p>
                        <h3 class="text-white">{{ $runningRegistrationsMemberCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-info">
            <div class="card-body p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Member Registration Over</p>
                        <h3 class="text-white">{{ $runningRegistrationsMemberCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TRAINER --}}
<div class="row">
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-primary">
            <div class="card-body p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Total Trainer</p>
                        <h3 class="text-white">{{ $totalTrainers }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-success">
            <div class="card-body p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Total Trainer Session</p>
                        <h3 class="text-white">{{ $totalTrainerSessions }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-danger">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Trainer Session Running</p>
                        <h3 class="text-white">{{ $runningTrainerSessionsCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-info">
            <div class="card-body p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Trainer Approval</p>
                        <h3 class="text-white">10</h3>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>

{{-- TRAINER SESSION --}}
{{-- <div class="row">
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-primary">
            <div class="card-body p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Total Trainer Session</p>
                        <h3 class="text-white">{{ $totalTrainerSession }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-success">
            <div class="card-body p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Running Trainer Session</p>
                        <h3 class="text-white">{{ $runningTrainerSession }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-danger">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-users"></i>
                    </span>
                    <div class="media-body text-white text-end">
                        <p class="mb-1 text-white">Trainer Session Over</p>
                        <h3 class="text-white">{{ $trainerSessionOver }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
