<!DOCTYPE html>
<html>

<head>
    <title>Members Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Members Report</h4>
        </h5>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Member Name</th>
                <th>Member Code</th>
                <th>Phone Number</th>
                <th>Start Date</th>
                <th>Expired Date</th>
                <th>Member Package</th>
                <th>Source Code</th>
                <th>Method Payment</th>
                <th>Sold By</th>
                <th>Referral Name</th>
                {{-- <th>Status</th> --}}
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($members as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->full_name }}</td>
                    <td>{{ $item->member_code }}</td>
                    <td>{{ $item->phone_number }}</td>
                    <td>{{ $item->start_date }}</td>
                    <td>{{ $item->expired_date }}</td>
                    <td>
                        {{ !empty($item->memberPackage->package_name) ? $item->memberPackage->package_name : 'Member Package name has  been deleted' }}
                    </td>
                    <td>
                        {{ !empty($item->sourceCode->name) ? $item->sourceCode->name : 'Source code name has  been deleted' }}
                    </td>
                    <td>
                        {{ !empty($item->methodPayment->name) ? $item->methodPayment->name : 'Method payment has  been deleted' }}
                    </td>
                    <td>
                        {{ !empty($item->users->full_name) ? $item->users->full_name : 'User has  been deleted' }}
                    </td>
                    <td>
                        {{ !empty($item->referralName->full_name) ? $item->referralName->full_name : 'Referral name has  been deleted' }}
                    </td>
                    {{-- <td>{{ $item->status }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
