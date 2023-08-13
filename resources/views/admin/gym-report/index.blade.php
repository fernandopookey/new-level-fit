<div class="tab-content" id="myTabContent-1">
    <div class="tab-pane fade show active" id="DefaultTab1" role="tabpanel" aria-labelledby="home-tab">
        <div class="card-body pt-0">
            <!-- Nav tabs -->
            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#appointment">
                            Appointment
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#classInstructor">
                            Locker
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#member">
                            Member
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#csPos">
                            Member Expired
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#fitnessConsultant">
                            Member Get Member
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#personalTrainer">
                            Personal Trainer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ptLeader">
                            Personal Trainer GO
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#physiotherapy">
                            Physiotherapy
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#physiotherapy">
                            Recap Session
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#physiotherapy">
                            Studio
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    @include('admin.gym-report.appointment-list.index')
                    @include('admin.gym-report.member-list.index')
                </div>
            </div>
        </div>
    </div>
</div>
