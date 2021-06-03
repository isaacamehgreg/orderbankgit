@extends('app')
@section('title', 'WELCOME!')
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
    $business = App\User::find(auth()->user()->business_id);
    @endphp

    <div class="row">

        <div class="offset-xl-7 col-xl-5 col-lg-3 col-md-6 col-sm-12 col-12">
                    </div>

           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-6">
                                    <a href="#!">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Wallet Balance</h5>
                                                    <h3 class="mb-0">₦{{ number_format($business->wallet()) }}</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-credit-card fa-fw fa-sm text-info"></i>
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
                                                    <h5 class="text-muted">Account Status</h5>
                                                    <h3 class="mb-0">{{ @App\Subscriptions::find(App\BusinessSubscription::where('user_id', $business->id)->first()->subscription_id)->title ?? '-' }}</h3>
                                                </div>
                                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-home fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
    </div>





         <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">

                    <h5 class="card-header"><b style="color: #5E2CED;"><b></b>{{ \auth()->user()->firstname }}, you have {{ App\Orders::where('delivery_status', 'New Order')->where('business_id', $business->id)->count() }} new orders in queue.</b></h5>

                  {{--      <hr>
                       <form method="post" action="/todos"  class="form-group">
                           @csrf
                           <div class=""></div>
                        <div class="form-group" >
                            <div class="col-md-4">
                                <h2 style="margin:5px; color: white">What's your To-Dos</h2>
                            <input type="todos" class="form-control" id="todos" placeholder="todos" name="todos">
                        </div>
                        </div>
                        &nbsp; &nbsp; &nbsp; <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                         <br>
                        <br>


--}}
                            </div>
                        </div>

@endsection
