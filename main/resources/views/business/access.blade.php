@extends('gadmin')
@section('title', 'Reports Overview For Selected User')
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
            <a href="#!">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-inline-block">
                                <h5 class="text-muted">Total Product in store</h5>
                                <h3 class="mb-0">{{ $products->count() }}</h3>
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
                                                    <h5 class="text-muted">Total price Amount for store Products</h5>
                                                    <h3 class="mb-0">{{ $products->sum('price') }}</h3>
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
                                                    <h5 class="text-muted">Total Quantuty for store Products</h5>
                                                    <h3 class="mb-0">{{ $products->sum('qty') }}</h3>
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
                            <h5 class="text-muted">Subscription type</h5>
                            <h3 class="mb-0">{{ $subscriptions->title }}</h3>
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
                    <h5 class="card-header"><b style="color: #5E2CED;"><b></b>Welcome to {{ $businesses->business_name }}'s Dashboard Overview.</b></h5>

                            </div>
                        </div>


                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card" style="background-color: transparent;">
                                        <h5 class="card-header">Here Are The List Of Products</h5>
                                        <div class="card-body">
                                                @php
                                                    $count = 0;
                                                @endphp

                                            <div class="row">
                                                @foreach($products as $product)
                                                @php
                                                            $count++;
                                                        @endphp
                                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="card border-dark mb-3">
                                                            <div class="card-body bg-light border-primary mb-3">
                                                            <div class="row text-center">
                                                            <div class="col">{{$count}}</div>
                                                            <div class="col"><a href="products/edit/{{ $product->id }}" class="btn btn-sm btn-block btn-primary">UPDATE PRODUCT</a></div>
                                                            <div class="col"><input type="checkbox" class="bulk" id="{{ $business->id }}" name="business_id[]" /><b style="color: #5E2CED;"></b></div>
                                                            </div>
                                                            <hr><br>

                                                            <li>Product Name: {{ $product->title }}</li>
                                                            <li>Product Price: {{ $product->price }}</li>
                                                            <li>Product Quantity: {{ $product->qty }}</li>
                                                            <a href="{{ route('business.kill', ['id' => $product->id]) }}" class="btn btn-block btn-danger float-right">Delete Product</a>
                                                            </div>
                                                            <div class="btn btn-block btn-primary">{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $product->created_at )) }}</div>
                                                        </div>
                                                        </div>
                                                @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                </div>
            </div>

@endsection

