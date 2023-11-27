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
            {{-- <li>
                <a href="{{ route('class.index') }}" aria-expanded="false">
                    <i class="material-icons">folder</i>
                    <span class="nav-text">Class Recap</span>
                </a>

            </li> --}}
            @if (Auth::user()->role == 'ADMIN')
                <li>
                    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="material-symbols-outlined">person</i>
                        <span class="nav-text">Member</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('members.index') }}">Members</a></li>
                        <li><a href="{{ route('member-registration.index') }}">Member Registration List</a></li>
                        <li><a href="{{ route('member-registration.create') }}">Create Member Registration</a></li>
                        {{-- <li><a href="{{ route('member-payment.index') }}">Member Payment</a></li> --}}
                        {{-- <li><a href="#">Member Visit</a></li> --}}
                        {{-- <li><a href="#">Member Expired</a></li> --}}

                    </ul>
                </li>
            @endif
            {{-- <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Session</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('class.index') }}">Class Recap</a></li>
                    <li><a href="{{ route('locker-transaction.index') }}">Locker Transaction</a></li>
                    <li><a href="{{ route('studio-booking.index') }}">Studio Booking</a></li>
                    <li><a href="{{ route('studio-transactions.index') }}">Studio Payment</a></li>
                </ul>
            </li> --}}
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Trainer</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <li><a href="{{ route('trainer.create') }}">Trainer Registration</a></li> --}}
                    {{-- <li><a href="{{ route('trainer.index') }}">Trainer List</a></li> --}}
                    <li><a href="{{ route('trainer-session.index') }}">Trainer Session</a></li>
                    {{-- <li><a href="{{ route('trainer-session-FO.index') }}">Trainer Session GO</a></li> --}}
                    {{-- <li><a href="#">Trainer Session PGT</a></li> --}}
                    {{-- <li><a href="{{ route('running-session.index') }}">Running Session</a></li> --}}
                </ul>

            </li>
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons"> assessment </i>
                    <span class="nav-text">Report Over</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('member-registration-over.index') }}">Member Registration Over</a></li>
                    <li><a href="{{ route('trainer-session-over.index') }}">Trainer Session Over</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('running-session.index') }}" aria-expanded="false">
                    <i class="material-icons"> assessment </i>
                    <span class="nav-text">Running Session</span>
                </a>
                {{-- <ul aria-expanded="false">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('member.index') }}">Member List</a></li>
                        <li><a href="{{ route('trainer.index') }}">Trainer List</a></li>
                    </ul> --}}

            </li>
            {{-- <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons">folder</i>
                    <span class="nav-text">Transaction Guest</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('appointment.index') }}">Appointment</a></li>
                    <li><a href="{{ route('buddy-referral.index') }}">Buddy Referral</a></li>
                    <li><a href="{{ route('leads.index') }}">Leads</a></li>
                </ul>
            </li> --}}
            {{-- @if (Auth::user()->role == 'ADMIN')
                <li>
                    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="material-icons"> assessment </i>
                        <span class="nav-text">Transaction Cafe</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="#">Transaction POS</a></li>
                        <li><a href="#">Transaction Purchase</a></li>
                        <li><a href="#">Product</a></li>
                        <li><a href="#">Distributor</a></li>
                        <li><a href="#">Report POS</a></li>
                        <li><a href="#">History POS</a></li>
                    </ul>
                </li>
            @endif --}}
            {{-- <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons"> extension </i>
                    <span class="nav-text">Report</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('report-gym.index') }}">GYM Club</a></li>
                </ul>
            </li> --}}
            @if (Auth::user()->role == 'ADMIN')
                <li>
                    <a href="{{ route('staff.index') }}" href="javascript:void(0);" aria-expanded="false">
                        <i class="material-symbols-outlined">person</i>
                        <span class="nav-text">Staff List</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role == 'ADMIN')
                <li>
                    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <i class="material-icons"> insert_drive_file </i>
                        <span class="nav-text">Setting</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Member</a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('member-package.index') }}">Member Package</a></li>
                                {{-- <li><a href="{{ route('member-package-type.index') }}">Member Package Type</a></li>
                                <li><a href="{{ route('member-package-category.index') }}">Member Package Category</a>
                                </li> --}}
                            </ul>
                        </li>
                        {{-- <li><a href="#">Class Name</a></li> --}}
                        {{-- <li><a href="#">Locker Package</a></li> --}}
                        <li><a href="{{ route('payment-method.index') }}">Payment Method</a></li>
                        {{-- <li><a href="#">Physiotherapy Package</a></li> --}}
                        {{-- <li><a href="{{ route('referral.index') }}">Referral</a></li> --}}
                        {{-- <li><a href="{{ route('sold-by.index') }}">Sold By</a></li> --}}
                        {{-- <li><a href="{{ route('studio.index') }}">Studio Name</a></li>
                        <li><a href="{{ route('studio-package.index') }}">Studio Package</a></li> --}}
                        <li>
                            <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Trainer</a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('trainer-package.index') }}">Trainer Package</a></li>
                                {{-- <li><a href="{{ route('trainer-package-type.index') }}">Trainer Package Type</a></li>
                                <li><a href="{{ route('trainer-transaction-type.index') }}">Trainer Transaction
                                        Type</a>
                                </li> --}}
                            </ul>
                        </li>
                        {{-- <li><a href="{{ route('transfer-package.index') }}">Transfer Package</a></li> --}}
                    </ul>
                </li>
            @endif
        </ul>
        <div class="copyright">
            <p>Hi, <b>{{ Auth::user()->full_name }}</b></p>
        </div>
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->
