@extends('app')
@section('title', 'Dashboard Overview')
@section('content')
    <style>

        .chart_card {
            padding: 20px;
            margin-left: -30px;
            margin-top: 10px;
        }

        @media only screen and (max-width: 600px) {
            .chart_card {
                margin-left: 0px;
                margin-top: 0px;
                padding: 40px;
            }

        }

        input.form-control {
            background-color:white;
            color:white;
            text-decoration-color: white;
        }
        form.form-group{
            background-color:#5E2CED;
            color:white;
            font-size: 50px;

        }
        button.btn-block{
            color: #0b2e13;
        }

        .btn-group.special {
  display: flex;
}

.special .btn {
  flex: 1
}

    </style>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @if ($message = Session::get('success'))
        <script>
            swal("Success", "{{ $message }}", "success");
        </script>
    @endif


    @if ($message = Session::get('error'))
        <script>
            swal("Error", "{{ $message }}", "error");
        </script>
    @endif

    @php
    $notif = App\Notifications::where('user_id', auth()->id())->get();
    @endphp

    <div class="row">
        <div class="col-lg-12">
                    @foreach($notif as $item)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <a href="/api/clearNotifications/{{ auth()->id() }}">CLEAR ALL NOTIFICATIONS</a>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endforeach
            
            @foreach($notif as $item)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ $item->content }} <a href="{{ $item->link }}">View order.</a>
              <button type="button" class="close" onclick="delNotif({{ $item->id }})" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endforeach
        </div> 


<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="btn-group special" role="group" aria-label="Basic example">
                    <a href="?daterange=today" class="btn btn-primary-outline" style="@if(\request()->get('daterange') == 'today') background: #6049ed; color: #fff; @else color: #000; @endif border: 1px solid #6049ed; ">Today</a>
                    <a href="?daterange=yesterday" class="btn btn-primary-outline" style="@if(\request()->get('daterange') == 'yesterday') background: #6049ed; color: #fff; @else color: #000; @endif border: 1px solid #6049ed; ">Yesterday</a>

                    </div>
                  <br>
                </div>


                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="btn-group special" role="group" aria-label="Basic example">


                    <a href="?daterange=week" class="btn btn-primary-outline" style="@if(\request()->get('daterange') == 'week') background: #6049ed; color: #fff; @else color: #000; @endif border: 1px solid #6049ed;">This Week</a>
                    <a href="?daterange=month" class="btn btn-primary-outline" style="@if(\request()->get('daterange') == 'month' || \request()->get('daterange') == '') background: #6049ed; color: #fff; @else color: #000; @endif border: 1px solid #6049ed;">This Month</a>
                {{-- <a href="?daterange=year" class="btn btn-primary-outline" style="@if(\request()->get('daterange') == 'year') background: #6049ed; color: #fff; @else color: #000; @endif border: 1px solid #6049ed;">This Year</a> --}}
                  </div>
                  <br>
                </div>


                    <br>


                           <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">New Orders</h5>
                                            <h2 class="mb-0">₦{{ number_format($new_value ?? 0) }}</h2>
                                        <h4 class="mb-0">{{ count($total_new_orders) ?? 0 }} Orders</h4>

                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                            <i class="fa fa-shopping-cart fa-fw fa-sm text-info"></i>
                                        </div>
                                    </div>
                                </div>

                        </div>

                           <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Sales Revenue</h5>
                                            <h2 class="mb-0">₦{{ number_format($month_sales ?? 0) }}</h2>
                                            <h4 class="mb-0">{{ $month_orders }} Orders</h4>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                            <i class="fa fa-money fa-fw fa-sm text-info"></i>
                                        </div>
                                    </div>
                                </div>

                        </div>
                           <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Payment Received</h5>
                                            <h2 class="mb-0">₦{{ number_format($total_orders_remitted ?? 0) }}</h2>
                                            <h4 class="mb-0">{{ $orders_remitted_stat }} Orders</h4>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                            <i class="fa fa-bank fa-fw fa-sm text-info"></i>
                                        </div>
                                    </div>
                                </div>
                        </div>

<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12"></div>
<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12"> </div>

    </div>



<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<div class="btn-group special" role="group" aria-label="Basic example">
        <a href="/revenue" class="btn btn-success" style=" border: 1px solid success; color: #FFFFFF;">VIEW CONSOLIDATED REVENUE STATEMENT</a>
             </div>
      </div>

<br>
         <div class="row">



                           <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted"><b style="color: #5E2CED;">Wallet Balance</b></h5>
                                                    <h4 class="mb-0">₦{{ number_format(auth()->user()->wallet()) }}</h4>
                                                 {{--   @foreach($most_ordered_states as $states)
                                                        <h4 class="mb-0"> &bull;	{{ $states['state'] }}</h4>
                                                        <h5 class="mb-0">Sales:₦{{ $states['sales'] ?? 0 }}</h5>
                                                            <h5 class="mb-0">Orders:{{ $states['count'] }}</h5>
                                                    @endforeach --}}
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-credit-card fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                           <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">

                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted"><b style="color: #5E2CED;">Account Status</b></h5>
                                                    <h4 class="mb-0">{{auth()->user()->subscription() != "" ? auth()->user()->subscription() : "-"}}</h4>
                                               {{--    @foreach($top_selling_products as $item)
                                                        <a href="{{ url('form/'.$item['link']) }}">
                                                        <h4 class="mb-0">&bull;	{{ substr(App\Products::find(json_decode($item['products'])[0])->title, 0, 25) }}</h4></a>
                                                        <h5 class="mb-0">Sales:₦{{ $item['sales'] ?? 0 }}</h5>
                                                            <h5 class="mb-0">Orders:{{ ''.$item['views'].'' }}</h5>
                                                    @endforeach --}}
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-home fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>

                                </div>


                           <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    
                                        @php 
                                        $num_referred_users = App\Models\Referral::where('referrer_id', auth()->id())->count();
                                        @endphp
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted"><b style="color: #5E2CED;"><b>Total Referrals</b></h5>
                                                    <h4 class="mb-0">{{$num_referred_users ?? 0}}</h4>
                                             {{--       @foreach($frequent_customers_count as $item)
                                                        <h4 class="mb-0">&bull;	 {{ $item['phonenumber'] }}</h4>
                                                            <h5 class="mb-0">Sales:₦ {{ $item['total_order_amount'] ?? 0 }}</h5>
                                                            <h5 class="mb-0">Orders:{{ $item['total_order']}}</h5>
                                                    @endforeach --}}
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-user-circle fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                                               
                                       </div>
                                   
                                </div>

            </div>

<br>
                                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<div class="btn-group special" role="group" aria-label="Basic example">
        <a href="/admin/products/add" class="btn btn-primary-outline" style=" border: 1px solid #6049ed; color: #6049ed;">+ Add Product</a>
        <a href="/admin/deliverytime/add" class="btn btn-primary-outline" style=" border: 1px solid #6049ed; color: #6049ed;">+ Delivery Times</a>
             </div>
      </div>

      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<div class="btn-group special" role="group" aria-label="Basic example">
      <a href="/forms/create" class="btn btn-primary-outline" style="border: 1px solid #6049ed; color: #6049ed;">+ Order Form</a>
        <a href="/orders/new" class="btn btn-primary-outline" style="border: 1px solid #6049ed; color: #6049ed;">+ New Order</a>
</div>
      </div>

      <br>

<!-- gauge js -->
<script src="/vendor/gauge/gauge.min.js"></script>
@if (\Illuminate\Support\Facades\Session::get('onboard') == 'yes')
        <script>
            swal({
                title: 'Welcome to OrderBank!',
                icon: 'success',
                text: "You are automatically subscribed to the Basic Plan. Your business can process up to 20 orders for free. "+
                    "Upgrade to increase your limits or jump right to your dashboard.",
                showCloseButton: true,
                buttons: {
                    confirm: {
                        text: "Upgrade",
                        value: "upgrade"
                    },
                    cancel: "See Dashboard",
                }
            }).then((value) => {
                switch(value) {
                    case "cancel":
                    default:
                        break;
                    case "upgrade":
                        window.location.href = "{{url("/subscription")}}";
                        break;
                }
            })
        </script>
    @endif
<script>
if ($('#chartjs_line').length) {
        var ctx = document.getElementById('chartjs_line').getContext('2d');

        var myChart = new Chart(ctx, {
                type: 'line',

                data: {
                    labels: [],
                    datasets: [{
                        label: 'Delivered',
                        data: [{{ implode(',', $delivered_chart) }}],

                        backgroundColor: "transparent",
                        borderColor: "green",
                        borderWidth: 2
                    }, {
                        label: 'Shipped',
                        data: [{{ implode(',', $in_transit_chart) }}],
                        backgroundColor: "transparent",
                        borderColor: "blue",
                        borderWidth: 2
                    },
                    {
                        label: 'Cancelled',
                        data: [{{ implode(',', $cancelled_chart) }}],
                        backgroundColor: "transparent",
                        borderColor: "red",
                        borderWidth: 2
                    }, {
                        label: 'Rescheduled',
                        data: [{{ implode(',', $rescheduled_chart) }}],
                        backgroundColor: "transparent",
                        borderColor: "teal",
                        borderWidth: 2
                    },
                    {
                        label: 'Pending',
                        data: [{{ implode(',', $pending_chart) }}],
                        backgroundColor: "transparent",
                        borderColor: "black",
                        borderWidth: 2
                    }, {
                        label: 'Refunded',
                        data: [{{ implode(',', $refunded_chart) }}],
                        backgroundColor: "transparent",
                        borderColor: "purple",
                        borderWidth: 2
                    },

                    ]

                },
                options: {
                    legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },

                    scales: {
                        xAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d',
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d',
                            }
                        }]
                    }
                }



        });
}


var opts2 = {
        angle: 0.35, // The span of the gauge arc
        lineWidth: 0.1, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
            length: 0.6, // // Relative to gauge radius
            strokeWidth: 0.115, // The thickness
            color: 'purple' // Fill color
        },
        limitMax: false, // If false, max value increases automatically if value > maxValue
        limitMin: false, // If true, the min value of the gauge will be fixed
        colorStart: '#c125ff', // Colors
        colorStop: '#c125ff', // just experiment with them
        strokeColor: '#e4e4ee', // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true, // High resolution support
        // renderTicks is Optional
        renderTicks: {
            divisions: 5,
            divWidth: 1.1,
            divLength: 0.7,
            divColor: '#333333',
            subDivisions: 3,
            subLength: 0.5,
            subWidth: 0.6,
            subColor: '#666666'
        }

    };
    var target2 = document.getElementById('gauge2'); // your canvas element
    var gauge2 = new Donut(target2).setOptions(opts2); // create sexy gauge!
    gauge2.maxValue = {{ $shipped_value }}; // set max gauge value
    gauge2.setMinValue(0); // Prefer setter over gauge.minValue = 0
    gauge2.animationSpeed = 32; // set animation speed (32 is default value)
    gauge2.set({{ $delivered_value }}); // set actual value


       var opts3 = {
        angle: 0.35, // The span of the gauge arc
        lineWidth: 0.1, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
            length: 0.6, // // Relative to gauge radius
            strokeWidth: 0.115, // The thickness
            color: '#2e2f39' // Fill color
        },
        limitMax: false, // If false, max value increases automatically if value > maxValue
        limitMin: false, // If true, the min value of the gauge will be fixed
        colorStart: '#6dff1b', // Colors
        colorStop: '#06ff00', // just experiment with them
        strokeColor: '#e4e4ee', // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true, // High resolution support
        // renderTicks is Optional
        renderTicks: {
            divisions: 5,
            divWidth: 1.1,
            divLength: 0.7,
            divColor: '#333333',
            subDivisions: 3,
            subLength: 0.5,
            subWidth: 0.6,
            subColor: '#666666'
        }

    };
    var target3 = document.getElementById('gauge3'); // your canvas element
    var gauge3 = new Donut(target3).setOptions(opts3); // create sexy gauge!
    gauge3.maxValue = {{ \App\Orders::all()->count() }}; // set max gauge value
    gauge3.setMinValue(0); // Prefer setter over gauge.minValue = 0
    gauge3.animationSpeed = 32; // set animation speed (32 is default value)
    gauge3.set({{ $orders_delivered }}); // set actual value


</script>
    <script type="text/javascript">
        document.getElementById().disabled=true;
    </script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>


            var ctx = document.getElementById('myChart').getContext('2d');

            var myChart = new Chart(ctx, {
                    type: 'line',

                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Delivered',
                            data: [{{ implode(',', $delivered_chart) }}],

                            backgroundColor: "transparent",
                            borderColor: "green",
                            borderWidth: 2
                        }, {
                            label: 'Shipped',
                            data: [{{ implode(',', $in_transit_chart) }}],
                            backgroundColor: "transparent",
                            borderColor: "blue",
                            borderWidth: 2
                        },
                        {
                            label: 'Cancelled',
                            data: [{{ implode(',', $cancelled_chart) }}],
                            backgroundColor: "transparent",
                            borderColor: "red",
                            borderWidth: 2
                        }, {
                            label: 'Ready For Delivery',
                            data: [{{ implode(',', $ready_chart) }}],
                            backgroundColor: "transparent",
                            borderColor: "teal",
                            borderWidth: 2
                        },
                        {
                            label: 'Pending',
                            data: [{{ implode(',', $pending_chart) }}],
                            backgroundColor: "transparent",
                            borderColor: "black",
                            borderWidth: 2
                        }, {
                            label: 'Refunded',
                            data: [{{ implode(',', $refunded_chart) }}],
                            backgroundColor: "transparent",
                            borderColor: "purple",
                            borderWidth: 2
                        },

{
                            label: 'Payment Received',
                            data: [{{ implode(',', $remitted_chart) }}],
                            backgroundColor: "transparent",
                            borderColor: "Navy blue",
                            borderWidth: 2
                        },

                        ]

                    },
                    options: {
                        legend: {
                            display: true,
                            position: 'bottom',

                            labels: {
                                fontColor: '#71748d',
                                fontFamily: 'Circular Std Book',
                                fontSize: 14,
                            }
                        },

                        scales: {
                            xAxes: [{
                                ticks: {
                                    fontSize: 14,
                                    fontFamily: 'Circular Std Book',
                                    fontColor: '#71748d',
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    fontSize: 14,
                                    fontFamily: 'Circular Std Book',
                                    fontColor: '#71748d',
                                }
                            }]
                        }
                    }



            });


function delNotif(id) {
    let data = {
    id: id
  };

  $.ajax({
    url: "/api/delNotification",
    data: data,
    success:function(data) {

      

    },
    error:function(err) {
      console.log(err)
    }
  })
}

</script>

@endsection

