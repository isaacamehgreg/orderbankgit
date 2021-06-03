
<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        admin
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link @if(request()->is('reports')) active @endif" href="/reports"><i class="fa fa-fw fa-user-circle"></i>Dashboard </a>
                    </li>
                    {{-- <li class="nav-item ">
                        <a class="nav-link @if(request()->is('waybill/generate')) active @endif" href="{{ url('waybill/generate') }}"><i class="fa fa-fw fa-barcode"></i>Generate Waybill </a>
                    </li> --}}
                    <li class="nav-item">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i>Orders</a>
                                <div id="submenu-3" class="submenu collapse" style="">
                                    <ul class="nav flex-column">
                                       
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=delivered">Delivered</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=rescheduled">Rescheduled</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=pending">Pending</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=shipped">Shipped</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=notshipped">Not Shipped</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=cancelled">Cancelled</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=ready">Ready</a>
                                        </li>
                                        @if(\auth()->user()->role == 1)
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=remitted">Remitted</a>
                                        </li> 
                                        @endif
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=failed">Failed</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=deleted">Deleted</a>
                                        </li>

                                     </ul>
                                </div>
                    </li>
         
                    <li class="nav-divider">
                        Settings
                    </li>
      
                    <li class="nav-item ">
                        <a class="nav-link @if(request()->is('profile')) active @endif" href="/profile"><i class="fa fa-fw fa-user"></i>My Account </a>
                    </li>
              
                    <li class="nav-item ">
                        <a class="nav-link" href="/logout"><i class="fa fa-fw fa-lock"></i>Logout </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>