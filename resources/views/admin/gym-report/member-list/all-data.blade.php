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
                    <th>Member Name</th>
                    <th>Member Code</th>
                    <th>Gender</th>
                    <th>Phone Number</th>
                    <th>Member Package</th>
                    <th>Source Code</th>
                    <th>Method Payment</th>
                    <th>Sold By</th>
                    <th>Referral</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member as $item)
                    <tr>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->member_code }}</td>
                        <td>{{ $item->gender }}</td>
                        <td>{{ $item->phone_number }}</td>
                        <td>
                            {{ !empty($item->memberPackage->package_name) ? $item->memberPackage->package_name : 'Member package has  been deleted' }}
                        </td>
                        <td>
                            {{ !empty($item->sourceCode->name) ? $item->sourceCode->name : 'Source code name has  been deleted' }}
                        </td>
                        <td>
                            {{ !empty($item->methodPayment->name) ? $item->methodPayment->name : 'Method Payment name has  been deleted' }}
                        </td>
                        <td>
                            {{ !empty($item->soldBy->name) ? $item->soldBy->name : 'Sold by name has  been deleted' }}
                        </td>
                        <td>
                            {{ !empty($item->refferalName->name) ? $item->refferalName->name : 'Referral name has  been deleted' }}
                        </td>
                        <td>{{ $item->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
