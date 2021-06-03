@php
function getOrderStatusCount($order_status) {
    $count = App\Orders::where('delivery_status', $order_status)->where('business_id', auth()->id())->count();
    return $count;
}

function getOrderStatusSharedCount($order_status) {
    $count = App\Orders::where('delivery_status', $order_status)->where('business_id', auth()->id())->orWhere('order_shared_with', auth()->id())->count();
    return $count;
}
@endphp
<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">WELCOME!</a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
	               <li class="nav-divider">
                        Account ID: {{ auth()->id() }}
                    </li>

                    @if(auth()->user()->role == 3)
                    <b style='color: white; margin-left: 15px;'>ADMINISTRATIVE OFFICER</b>
                    @endif
                    @if(auth()->user()->role == 4)
                    <b style='color: white; margin-left: 15px;'>ACCOUNTANT OFFICER</b>
                    @endif

                    @if(auth()->user()->is_gadmin == 1)
                        <li class="nav-item">
                            <a class="nav-link" href="/gadmin"><i class="fa fa-fw fa-tasks"></i>Global Admin Panel</a>
                        </li>
                    @endif
                    <li class="nav-item ">
                        <a class="nav-link @if(request()->is('reports')) active @endif" href="/reports"><i class="fa fa-fw fa-user-circle"></i>Dashboard </a>
                    </li>
                    <li class="nav-item">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i>Orders</a>
                                <div id="submenu-3" class="submenu collapse" style="">
                                    <ul class="nav flex-column">
                                    @if(auth()->user()->subscriptionStatus() == 'Active')
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=new">New Orders ({{ getOrderStatusCount('New Order') }})</a>
                                        </li>
                                         <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=shipped">Shipped ({{ getOrderStatusCount('shipped') }})</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=Ready For Delivery">Ready For Delivery ({{ getOrderStatusCount('Ready For Delivery') }})</a>
                                        </li>


                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=delivered">Delivered ({{ getOrderStatusCount('delivered') }})</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=cancelled">Cancelled ({{ getOrderStatusCount('cancelled') }})</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=pending">Pending ({{ getOrderStatusCount('pending') }})</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=Payment Received">Payment Received ({{ getOrderStatusCount('Payment Received') }})</a>
                                        </li>


                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=refunded">Refunds ({{ getOrderStatusCount('refunded') }})</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=shared">Shared ({{ getOrderStatusSharedCount('shared') }})</a>
                                        </li>

                                        <li class="nav-item">
                                                    <a class="nav-link" href="/orders?filter=all"><b>View All Orders</b></a>
                                                </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders/new">Input New Order</a>
                                        </li>

                                        


                                    @endif

                                            </ul>
                                </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#!" data-toggle="collapse" aria-expanded="false"
                           data-target="#getstarted-submenu" aria-controls="submenu-3">
                           <i class="fas fa-fw fa-car"></i>

                           Get Started</a>
                        <div id="getstarted-submenu" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/products">Products</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link"
                                       href="/admin/deliverytime">Delivery Time</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#!" data-toggle="collapse" aria-expanded="false"
                           data-target="#addons-submenu" aria-controls="submenu-3">
                           <i class="fas fa-fw fa-shopping-cart"></i>❤️Start Selling Now🔥</a>
                        <div id="addons-submenu" class="submenu collapse" style="">
                            <ul class="nav flex-column">

                                <li class="nav-item">
                                    <a class="nav-link collapsed" href="/admin/forms">Order Form</a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link"
                                       href="https://orderbank.com.ng/dashboard">Sales Funnel</a>
                                </li>
                                
                                <li class="nav-item ">
                                    <a class="nav-link"
                                       href="https://store.orderbank.com.ng/dashboard">Ecommerce Store</a>
                                </li>
                                
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed @if(request()->is('wallet') || request()->is('wallet')) active @endif"
                           href="#" data-toggle="collapse" aria-expanded="false"
                           data-target="#wallet-submenu" aria-controls="wallet-submenu">
                            <i class="fa fa-fw fa-dollar"></i>Wallets (₦{{ number_format(auth()->user()->wallet()) }})
                        </a>
                        <div id="wallet-submenu" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item ">
                                    <a class="nav-link" href="/wallet/fund">Fund</a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link @if(request()->is('wallet/usage')) active @endif" href="/wallet/usage">Usage</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/wallet">History</a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="/wallet/transfer">Transfer</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/wallet/withdraw">Withdrawal</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed @if(request()->is('settings') || request()->is('settings') || request()->is('users*')) active @endif"
                           href="#" data-toggle="collapse" aria-expanded="false"
                           data-target="#settings-submenu" aria-controls="settings-submenu">
                            <i class="fa fa-fw fa-cogs"></i>Settings
                        </a>
                        <div id="settings-submenu" class="submenu collapse" style="">
                            <ul class="nav flex-column">

                                <li class="nav-item ">
                                    <a class="nav-link @if(request()->is('/message/history')) active @endif"
                                       href="/message/history">Notifications</a>
                                </li>
<li class="nav-item ">
                                    <a class="nav-link" href="/referral">Referral</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link @if(request()->is('customers')) active @endif" href="/admin/customers">All Customers </a>
                                </li>
                                 <li class="nav-item ">
                                    <a class="nav-link @if(request()->is('users') || request()->is('users*')) active @endif" href="/users">Staff Account </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link @if(request()->is('profile')) active @endif" href="/profile">My Account </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link @if(request()->is('subscription') || request()->is('subscription*')) active @endif" href="/subscription">Subscription </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link @if(request()->is('business') || request()->is('business*')) active @endif" href="/business">Business Settings </a>
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
