@php
function getOrderStatusCount($order_status) {
    $count = App\Orders::where('delivery_status', $order_status)->where('business_id', auth()->user()->business_id ?? auth()->id())->count();
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
                   {{-- <li class="nav-divider">
                        Account ID: {{ auth()->id() }}
                    </li> --}}
                    <b style='color: white; margin-left: 15px; margin-top: 20px;'>Administrative Officer</b>
                    <li class="nav-item ">
                        <a class="nav-link @if(request()->is('staffpanel')) active @endif" href="/staffpanel"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i>Orders</a>
                                <div id="submenu-3" class="submenu collapse" style="">
                                    <ul class="nav flex-column">
                                    @php
                                    $business = App\User::find(auth()->user()->business_id);
                                    @endphp
                                    @if($business->subscriptionStatus() == 'Active')
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=new">New Orders ({{ getOrderStatusCount('New Order') }})</a>
                                        </li>
                                         <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=shipped">Shipped ({{ getOrderStatusCount('shipped') }})</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=Ready%20For%20Delivery">Ready For Delivery ({{ getOrderStatusCount('Ready For Delivery') }})</a>
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
                                            <a class="nav-link" href="/orders?filter=Payment%20Received">Payment Received ({{ getOrderStatusCount('Payment Received') }})</a>
                                        </li>
                                        
                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders?filter=refunded">Refunded ({{ getOrderStatusCount('refunded') }})</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="/orders/new">Input New Order</a>
                                        </li>
                                        
                                          {{-- <li class="nav-item">
                                                    <a class="nav-link" href="/orders?filter=all"><b>View All Orders</b></a>
                                                </li> --}}

                                    @endif

                   
                    <li class="nav-item">
                        
                        <div id="settings-submenu" class="submenu collapse" style="">
                            <ul class="nav flex-column">
                                







                                                                                 </ul>
                                </div>
                    </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="/logout"><i class="fa fa-fw fa-lock"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>


