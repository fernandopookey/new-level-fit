<!--**********************************
            Sidebar start
        ***********************************-->
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">home</i>
                    <span class="nav-text">Home</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <li><a href="index.html">Dashboard Light</a></li> --}}
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('member.index') }}">Member List</a></li>
                    <li><a href="{{ route('trainer.index') }}">Trainer List</a></li>
                </ul>

            </li>
            {{-- <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">school</i>
                    <span class="nav-text">Barcode Scan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="student.html">Student</a></li>
                    <li><a href="student-detail.html">Student Detail</a></li>
                    <li><a href="add-student.html">Add New Student</a></li>

                </ul>

            </li> --}}
            {{-- <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Approval</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="teacher.html">Teacher</a></li>
                    <li><a href="teacher-detail.html">Teacher Detail</a></li>
                    <li><a href="add-teacher.html">Add New Teacher</a></li>

                </ul>

            </li> --}}
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Member Trans.</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <li><a href="{{ route('member.create') }}">Member Registration</a></li> --}}
                    {{-- <li><a href="#">Trainer Registration</a></li> --}}
                    <li><a href="{{ route('class.index') }}">Class Recap</a></li>
                    <li><a href="#">Finger Registration</a></li>
                    <li><a href="{{ route('locker-transaction.index') }}">Locker Transaction</a></li>
                    <li><a href="{{ route('member-payment.index') }}">Member Payment</a></li>
                    <li><a href="{{ route('running-session.index') }}">Running Session</a></li>
                    <li><a href="{{ route('studio-booking.index') }}">Studio Booking</a></li>
                    <li><a href="{{ route('studio-transactions.index') }}">Studio Payment</a></li>
                    <li><a href="{{ route('trainer-session.index') }}">Trainer Session</a></li>
                    <li><a href="{{ route('trainer-session-FO.index') }}">Trainer Session FO</a></li>
                    <li><a href="#">Trainer Session PGT</a></li>
                </ul>

            </li>
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons">folder</i>
                    <span class="nav-text">Transaction Guest</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('appointment.index') }}">Appointment</a></li>
                    <li><a href="{{ route('buddy-referral.index') }}">Buddy Refferal</a></li>
                    <li><a href="activity.html">Missed Guest</a></li>
                    <li><a href="{{ route('leads.index') }}">Leads</a></li>
                    <li><a href="activity.html">Trash BTB</a></li>
                    <li><a href="chat.html">Trial Member</a></li>
                </ul>
            </li>
            {{-- <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons"> app_registration </i>
                    <span class="nav-text">Physiotherapy</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="./app-profile.html">Profile</a></li>
                    <li><a href="./edit-profile.html">Edit Profile</a></li>
                    <li><a href="./post-details.html">Post Details</a></li>
                    <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Email</a>
                        <ul aria-expanded="false">
                            <li><a href="./email-compose.html">Compose</a></li>
                            <li><a href="./email-inbox.html">Inbox</a></li>
                            <li><a href="./email-read.html">Read</a></li>
                        </ul>
                    </li>
                    <li><a href="./app-calender.html">Calendar</a></li>
                    <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Shop</a>
                        <ul aria-expanded="false">
                            <li><a href="./ecom-product-grid.html">Product Grid</a></li>
                            <li><a href="./ecom-product-list.html">Product List</a></li>
                            <li><a href="./ecom-product-detail.html">Product Details</a></li>
                            <li><a href="./ecom-product-order.html">Order</a></li>
                            <li><a href="./ecom-checkout.html">Checkout</a></li>
                            <li><a href="./ecom-invoice.html">Invoice</a></li>
                            <li><a href="./ecom-customers.html">Customers</a></li>
                        </ul>
                    </li>
                </ul>
            </li> --}}
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
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Member</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="#">Member</a></li>
                    <li><a href="#">Member Visit</a></li>
                    <li><a href="#">Member Expired</a></li>

                </ul>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons"> extension </i>
                    <span class="nav-text">Report</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="#">Fitness Club</a></li>
                    <li><a href="#">Guest</a></li>
                    <li><a href="#">FC Performance</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('staff.index') }}" href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">person</i>
                    <span class="nav-text">Staff List</span>
                </a>
            </li>
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
                            <li><a href="{{ route('member-package-type.index') }}">Member Package Type</a></li>
                            <li><a href="{{ route('member-package-category.index') }}">Member Package Category</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#">Class Name</a></li>
                    <li><a href="#">Locker Package</a></li>
                    <li><a href="{{ route('method-payment.index') }}">Method Payment</a></li>
                    <li><a href="#">Physiotherapy Package</a></li>
                    <li><a href="{{ route('refferal.index') }}">Refferal</a></li>
                    <li><a href="{{ route('sold-by.index') }}">Sold By</a></li>
                    <li><a href="{{ route('source-code.index') }}">Source Code</a></li>
                    <li><a href="{{ route('studio.index') }}">Studio Name</a></li>
                    <li><a href="{{ route('studio-package.index') }}">Studio Package</a></li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Trainer</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('trainer-package.index') }}">Trainer Package</a></li>
                            <li><a href="{{ route('trainer-package-type.index') }}">Trainer Package Type</a></li>
                            <li><a href="{{ route('trainer-transaction-type.index') }}">Trainer Transaction Type</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{ route('transfer-package.index') }}">Transfer Package</a></li>
                    <li>
                        <a href="{{ route('logout') }}" class="nav-link"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            {{-- <i class="nav-icon fas fa-sign-out-alt"></i> --}}
                            <p>Logout</p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            {{-- <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons">article</i>
                    <span class="nav-text">Pages</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="./page-login.html">Login</a></li>
                    <li><a href="./page-register.html">Register</a></li>
                    <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Error</a>
                        <ul aria-expanded="false">
                            <li><a href="./page-error-400.html">Error 400</a></li>
                            <li><a href="./page-error-403.html">Error 403</a></li>
                            <li><a href="./page-error-404.html">Error 404</a></li>
                            <li><a href="./page-error-500.html">Error 500</a></li>
                            <li><a href="./page-error-503.html">Error 503</a></li>
                        </ul>
                    </li>
                    <li><a href="./page-lock-screen.html">Lock Screen</a></li>
                    <li><a href="./empty-page.html">Empty Page</a></li>
                </ul>
            </li> --}}
        </ul>
        <div class="copyright">
            <p><b>{{ Auth::user()->full_name }}</b></p>
            <p class="fs-12">Made with <span class="heart"></span> by WAn</p>
        </div>
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->
