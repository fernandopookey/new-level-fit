<div>
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
    @if (session('memberPhoto'))
        <img src="{{ session('memberPhoto') }}" alt="Member Photo">
    @endif
    @if (session('memberName'))
        <p>{{ session('memberName') }}</p>
    @endif
    @if (session('nickName'))
        <p>{{ session('nickName') }}</p>
    @endif
    @if (session('memberCode'))
        <p>{{ session('memberCode') }}</p>
    @endif
    @if (session('phoneNumber'))
        <p>{{ session('phoneNumber') }}</p>
    @endif
    @if (session('born'))
        <p>{{ session('born') }}</p>
    @endif
    @if (session('gender'))
        <p>{{ session('gender') }}</p>
    @endif
    @if (session('email'))
        <p>{{ session('email') }}</p>
    @endif
    @if (session('ig'))
        <p>{{ session('ig') }}</p>
    @endif
    @if (session('eContact'))
        <p>{{ session('eContact') }}</p>
    @endif
    @if (session('address'))
        <p>{{ session('address') }}</p>
    @endif

</div>

<script>
    var message = "{{ $message }}";
    var memberPhoto = "{{ $memberPhoto }}";
    var memberName = "{{ $memberName }}";
    var nickName = "{{ $nickName }}";
    var memberCode = "{{ $memberCode }}";
    var phoneNumber = "{{ $phoneNumber }}";
    var born = "{{ $born }}";
    var gender = "{{ $gender }}";
    var email = "{{ $email }}";
    var ig = "{{ $ig }}";
    var eContact = "{{ $eContact }}";
    var address = "{{ $address }}";

    var contentHTML = `
        <div style="text-align: center;">
            <div style="background-color: rgb(0, 201, 33); font-size: 20px; color: rgb(255, 255, 255); text-align: center; border-radius: 7px;">
                <p>${message}</p>
            </div>
            <div class="trans-list" style="margin-top: 10px;">
                @if ($memberPhoto)
                    <img src="{{ Storage::url($memberPhoto) }}" class="lazyload" style="width: 100px;" alt="image">
                @else
                    <img src="{{ asset('default.png') }}" class="lazyload" style="width: 100px;" alt="default image">
                @endif
            </div>
            <h2 style="margin-top: 10px;">${memberName}</h2>
            <table class="table" style="margin: auto;">
                <thead>
                    <tr>
                        <th><b>Nick Name</b></th>
                        <td>${nickName}</td>
                    </tr>
                    <tr>
                        <th><b>Member Code</b></th>
                        <td>${memberCode}</td>
                    </tr>
                    <tr>
                        <th><b>Phone Number</b></th>
                        <td>${phoneNumber}</td>
                    </tr>
                    <tr>
                        <th><b>Date of Birth</b></th>
                        <td>${born}</td>
                    </tr>
                    <tr>
                        <th><b>Gender</b></th>
                        <td>${gender}</td>
                    </tr>
                    <tr>
                        <th><b>Email</b></th>
                        <td>${email}</td>
                    </tr>
                    <tr>
                        <th><b>Instagram</b></th>
                        <td>${ig}</td>
                    </tr>
                    <tr>
                        <th><b>Emergency Contact</b></th>
                        <td>${eContact}</td>
                    </tr>
                    <tr>
                        <th><b>Address</b></th>
                        <td>${address}</td>
                    </tr>
                </thead>
            </table>
        </div>
    `;

    function openNewWindow(contentHTML, width, height) {
        var leftPosition = (screen.width - width) / 2;
        var topPosition = (screen.height - height) / 2;

        var newWindow = window.open('', '_blank', 'width=' + width + ', height=' + height + ', left=' + leftPosition +
            ', top=' + topPosition);
        newWindow.document.write(contentHTML);

        setTimeout(function() {
            window.location.href = "{{ route('trainer-session.index') }}";
        }, 0);
    }

    document.addEventListener("DOMContentLoaded", function() {
        openNewWindow(contentHTML, 600, 500);
    });
</script>
