<!--**********************************
            Sidebar start
        ***********************************-->
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            @if (Auth::user()->role == 'ADMIN' || Auth::user()->role == 'CS')
                <li>
                    <a href="{{ route('dashboard') }}" aria-expanded="false">
                        <i class="material-symbols-outlined">home</i>
                        <span class="nav-text">Dashboard</span>
                    </a>

                </li>
            @endif

            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons">article</i>
                    <span class="nav-text">Lead</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('add-data') }}">General Lead</a></li>
                    <li><a href="{{ route('one-day-visit-lead') }}">1 Day Visit Lead</a></li>

                </ul>
            </li>

            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Members</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('members.index') }}">Member List</a></li>
                    <li><a href="{{ route('missed-guest.index') }}">Missed Guest</a></li>
                    <li><a href="{{ route('oneDayVisit') }}">1 Day Visit</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Member CheckIn</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('member-active.index') }}">Member Active</a></li>
                    <li><a href="{{ route('member-pending') }}">Member Pending</a></li>
                    <li><a href="{{ route('member-expired.index') }}">Member Expired</a>
                    </li>

                </ul>
            </li>

            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Trainer</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('trainer-session.create') }}">PT Registration</a></li>
                    <li><a href="{{ route('trainer-session.index') }}">Session Active</a></li>
                    <li><a href="{{ route('trainer-session-over.index') }}">Session Expired</a></li>
                    <li><a href="{{ route('lgt') }}">LGT</a></li>
                </ul>

            </li>

            @if (Auth::user()->role == 'ADMIN')
                <li>
                    <a href="{{ route('staff.index') }}" href="javascript:void(0);" aria-expanded="false">
                        <i class="material-symbols-outlined">person</i>
                        <span class="nav-text">Staff List</span>
                    </a>
                </li>
            @endif
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons"> insert_drive_file </i>
                    <span class="nav-text">Setting</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('member-package.index') }}">Member Package</a></li>
                    <li><a href="{{ route('payment-method.index') }}">Payment Method</a></li>
                    <li><a href="{{ route('trainer-package.index') }}">Trainer Package</a></li>
                </ul>
            </li>
        </ul>
        <div class="copyright">
            <p>Hi, <b>{{ Auth::user()->full_name }}</b></p>
        </div>
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->
