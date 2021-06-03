@extends('app')
@section('title', 'Manage Products')
@section('content')

<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <form action="" method="get">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Search &nbsp;<i class="fa fa-search"></i> </span>
          </div>
          <input class="form-control" type="text" name="text" value="{{ request('text') }}" placeholder="Search Product..." />
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit"><i class="fa fa-arrow-right"></i></button>
          </div>
        </div>
    </form>
</div>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="row">
                <div class="col-sm-12">
                    <h5 class="card-header">Your Product statistics.</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="#!">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-inline-block">
                                                <h5 class="text-muted">Total Products</h5>
                                                <h3 class="mb-0">{{$products->count()}}</h3>
                                            </div>
                                            <div
                                                class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                <i class="fa fa-list fa-fw fa-sm text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="#!">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-inline-block">
                                                <h5 class="text-muted">Total Quantity</h5>
                                                <h3 class="mb-0">{{$products->sum('qty')}}</h3>
                                            </div>
                                            <div
                                                class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                <i class="fa fa-list fa-fw fa-sm text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="#!">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-inline-block">
                                                <h5 class="text-muted">Total Products Amount</h5>
                                                <h3 class="mb-0">{{$products->sum('price')}}</h3>
                                            </div>
                                            <div
                                                class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                <i class="fa fa-list fa-fw fa-sm text-info"></i>
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
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card" style="background-color: transparent;">
                            <h5 class="card-header">Here Are The List Of Products You Sell<a href='products/add' class="btn btn-sm btn-success float-right"><b>+ ADD PRODUCT</b></a></h5>
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
                                                <div class="col"><input type="checkbox" class="bulk" id="{{ $product->id }}" name="product_id[]" /><b style="color: #5E2CED;"></b></div>
                                                </div>
                                                <hr><br>
                                                
                                                <li>Qty: {{ $product->qty }}</li>
                                                <li>Product: {{ $product->title }}</li>
                                                <li>Price: ₦{{ $product->price }}</li>
                                                {{-- <a href="products/edit/{{ $product->id }}" class="btn btn-block btn-info float-left">Edit</a> --}}
                                                <a href="products/delete/{{ $product->id }}" class="btn btn-block btn-danger float-right">Delete</a>
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

@endsection
@section('scripts')

@endsection



