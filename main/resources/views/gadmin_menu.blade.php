<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">Welcome</a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">

	                <li class="nav-divider">
                        Global Admin Panel
                    </li>

                    @if(auth()->user()->is_gadmin === TRUE)
                        <li class="nav-item">
                            <a class="nav-link" href="/gadmin"><i class="fa fa-fw fa-control"></i>Global Admin Panel</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-0" aria-controls="submenu-0"><i class="fa fa-fw fa-user-circle"></i>Businesses</a>
                        <div id="submenu-0" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    @foreach(App\Subscriptions::all() as $plans)
                                        <a class="nav-link" href="/gadmin/businesses?plan={{ str_slug($plans->title) }}&plan_id={{ $plans->id }}"><b>{{ $plans->title }}</b></a>
                                    @endforeach
                                </li>
                                <li class="nav-item">
                                            <a class="nav-link" href="{{ route('business.view') }}"><b>Manage Business</b></a>
                                </li>
                                </ul>
                        </div>
            </li>

                    <li class="nav-item">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-55" aria-controls="submenu-55"><i class="fas fa-fw fa-box"></i>Products</a>
                                <div id="submenu-55" class="submenu collapse" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="/gadmin/products"><b>Manage Products</b></a>
                                        </li>
                                        </ul>
                                </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-fw fa-clock"></i>Delivery Time</a>
                        <div id="submenu-2" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="/gadmin/delivery_time"><b>Manage Delivery Time</b></a>
                                </li>
                                </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-book"></i>Forms</a>
                        <div id="submenu-3" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="/gadmin/forms"><b>Manage Forms</b></a>
                                </li>
                                </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-fw fa-chart-pie"></i>Reports</a>
                        <div id="submenu-4" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="/gadmin/reports/revenue"><b>Revenue</b></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/gadmin/reports/message_logs"><b>Message Logs</b></a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-fw fa-bank"></i>Wallets</a>
                        <div id="submenu-5" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="/gadmin/wallets"><b>Manage Wallets</b></a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-cog"></i>Settings</a>
                        <div id="submenu-6" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="/profile"><b>My Account</b></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/gadmin/staffs"><b>Staff Account</b></a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-fw fa-users"></i>Referrals</a>
                        <div id="submenu-7" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="/gadmin/referrals"><b>Manage Referrals</b></a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-shopping-cart"></i>eCommerce Store</a>
                        <div id="submenu-8" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="/gadmin/stores"><b>Manage Stores</b></a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item ">
                        <a class="nav-link" href="/logout"><i class="fa fa-fw fa-lock"></i>Logout </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
