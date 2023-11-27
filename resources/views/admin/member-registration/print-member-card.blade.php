<!DOCTYPE html>
<html>

<head>
    <title>Print Member Card</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        writing-mode: vertical-rl;
        /* or vertical-lr */
        text-orientation: mixed;
    }

    .code {
        writing-mode: vertical-rl;
        /* or vertical-lr */
        text-orientation: mixed;
    }
</style>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    {{-- <center>
        <h5>Print Member Card</h5>
    </center> --}}

    <table class='table table-bordered'>
        <tbody>
            {{ $member->id }}
            {{-- <img src="{{ asset('logokecil.png') }}" alt="" /> --}}
            {{-- <h3>{{ $member->member_code }}</h3> --}}
            <img src="{{ public_path('card.jpg') }}" style="width: 100%; height: 90%;" alt="Example Image" />
            <div class="centered">Tes</div>
        </tbody>
    </table>

</body>

</html>
