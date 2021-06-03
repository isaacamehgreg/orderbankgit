@extends('gadmin')
@section('title', 'Reports Overview')
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
            color:#000;
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
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-6">
                    <form action="" method="get">
                        <div class="input-group mb-3">
                        <input class="form-control" type="text" hidden value="true" name="filter" placeholder="Pick date.." />
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Start Date &nbsp;<i class="fa fa-calendar"></i> </span>
                          </div>
                          <input class="form-control" type="date" name="start_date" value="{{ request('start_date') }}" placeholder="Pick date.." />

                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">End Date &nbsp;<i class="fa fa-calendar"></i> </span>
                          </div>
                          <input class="form-control" type="date" name="end_date" value="{{ request('end_date') }}" placeholder="Pick date.." />

                          
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-arrow-right"></i></button>
                            <button class="btn btn-danger" type="button" onclick="location.replace('{{ url()->current() }}')"><i class="fa fa-remove"></i></button>
                          </div>
                        </div>
                    </form>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-6"></div>

           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-6">
                                    <a href="#!">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Today’s User</h5>
                                                    <h3 class="mb-0">{{ $todays_users ?? 0 }}</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-users fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-6">
                                    <a href="#!">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Yesterday’s User</h5>
                                                    <h3 class="mb-0">{{ $yesterdays_users ?? 0 }}</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-users fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
    </div>






         <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><b style="color: #5E2CED;"><b></b>{{ \auth()->user()->firstname }}, Welcome to the Global Admin Panel.</b></h5>
            
                            </div>
                        </div>



         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-6">
                                    <a href="#!">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Most Used Plan</h5>
                                                    <h3 class="mb-0">{{ $most_used_plan ?? '-' }} ({{ $most_used_plan_count ?? 0 }})</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-money fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>


        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-6">
                                    <a href="#!">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Daily Funding</h5>
                                                    <h3 class="mb-0">₦{{ number_format($daily_funding ?? 0) }}</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-money fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-6">
                                    <a href="orders?filter=remitted">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Total Orders</h5>
                                                    <h3 class="mb-0">{{ $total_orders ?? 0 }}</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-ship fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-6">
                                    <a href="orders?filter=remitted">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Delivered Orders</h5>
                                                    <h3 class="mb-0">{{ $delivered_orders ?? 0 }}</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-ship fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

            </div>

@endsection

