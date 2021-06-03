@extends('gadmin')
@section('title', 'Global Sales Report (Revenue/Statistics)')
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
    <div class="row">
     
        <div class="offset-xl-7 col-xl-5 col-lg-3 col-md-6 col-sm-12 col-12">
            <form action="" method="get">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Filters &nbsp;<i class="fa fa-filter"></i></span>
                  </div>
                  <input class="form-control" type="text" name="daterange" value="{{ request('daterange') }}" id="daterange" />
                  
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-arrow-right"></i></button>
                    <button class="btn btn-danger" type="button" onclick="location.replace('{{ url()->current() }}')"><i class="fa fa-remove"></i></button>
                  </div>
                </div>
            </form>
        </div>
    </div> 
   

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="row">
                    <div class="col-sm-12">
                        <h5 class="card-header">Here’s what’s happening with your sales today.</h5>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="orders?filter=all">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Total Orders</h5>
                                                    <h3 class="mb-0"> ₦{{ number_format($all_value) }}</h3>
                                                    <h3 class="mb-0">{{ $orders_ingested }} Orders</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-list fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="orders?filter=new">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">New Orders</h5>
                                                    <h3 class="mb-0"> ₦{{ number_format($new_value) }}</h3>
                                                    <h3 class="mb-0">{{ $orders_new }} Orders</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-play fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                                
                                 <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="orders?filter=shipped">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Shipped</h5>
                                                    <h3 class="mb-0"> ₦{{ number_format($shipped_value) }}</h3>
                                                    <h3 class="mb-0"> {{ $orders_in_transit }} Orders</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-ship fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                           <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="orders?filter=ready">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Ready</h5>
                                                    <h3 class="mb-0"> ₦{{ number_format($orders_ready) }}</h3>
                                                    <h3 class="mb-0"> {{ $orders_ready_stat }} Orders</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-arrow-left fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> 
                                
                               

                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="orders?filter=delivered">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Delivered</h5>
                                                    <h3 class="mb-0"> ₦{{ number_format($delivered_value) }}</h3>
                                                    <h3 class="mb-0"> {{ $orders_delivered }} Orders</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-check fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="orders?filter=cancelled">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Cancelled</h5>
                                                    <h3 class="mb-0"> ₦{{ number_format($cancelled_value) }}</h3>
                                                    <h3 class="mb-0"> {{ $orders_cancelled }} Orders</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-times fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="orders?filter=pending">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Pending</h5>
                                                    <h3 class="mb-0"> ₦{{ number_format($pending_value) }}</h3>
                                                    <h3 class="mb-0"> {{ $orders_pending }} Orders</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-stop fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                     
                                      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="orders?filter=remitted">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Remittance</h5>
                                                    <h3 class="mb-0"> ₦{{ number_format($orders_remitted) }}</h3>
                                                    <h3 class="mb-0"> {{ $orders_remitted_stat }} Orders</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-bank fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>  
                               

                               
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="orders?filter=refunded">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Refunded</h5>
                                                    <h3 class="mb-0"> ₦{{ number_format($refunded_value) }}</h3>
                                                    <h3 class="mb-0"> {{ $orders_refunded }} Orders</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-arrow-right fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> 
                                
                                
                               
                                

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
@endsection
@section('scripts')

<!-- gauge js -->
<script src="/vendor/gauge/gauge.min.js"></script>


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

@endsection