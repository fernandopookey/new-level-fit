<div class="col-xl-3 wow fadeInUp mb-4" data-wow-delay="1.5s">
    <div class="table-responsive full-data">
        <a href="{{ route('report-gym.index') }}" class="btn btn-primary">Back</a>
    </div>
</div>


<div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
    <div class="table-responsive full-data">
        <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
            id="example-student">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Appointment Date</th>
                    <th>Full Name</th>
                    <th>Appointment Code</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Source</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>FC Name</th>
                    <th>Staff Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointment as $item)
                    <tr>
                        <td>{{ $item->date_time }}</td>
                        <td>{{ $item->appointment_date }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->appointment_code }}</td>
                        <td>{{ $item->phone_number }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->source }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            {{ !empty($item->fitnessConsultants->full_name) ? $item->fitnessConsultants->full_name : 'Fitness Consultant name has  been deleted' }}
                        </td>
                        <td>
                            {{ !empty($item->customerServices->full_name) ? $item->customerServices->full_name : 'Customer Service name has  been deleted' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
