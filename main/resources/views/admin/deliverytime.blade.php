@extends('app')
@section('title', 'Manage Delivery Time')
@section('content')

<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <form action="" method="get">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Search &nbsp;<i class="fa fa-search"></i> </span>
                  </div>
                  <input class="form-control" type="text" name="text" value="{{ request('text') }}" placeholder="Search Delivery Times..." />
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
                            <h5 class="card-header">Your Delivery Times statistics.</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <a href="#!">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-inline-block">
                                                        <h5 class="text-muted">Number Of Delivery Times</h5>
                                                        <h3 class="mb-0">{{$deliverytime->count()}}</h3>
                                                    </div>
                                                    <div
                                                        class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                        <i class="fa fa-list fa-fw fa-sm text-info"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <a href="#!">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-inline-block">
                                                        <h5 class="text-muted">Total Delivery Time</h5>
                                                        <h3 class="mb-0">44</h3>
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
                            <h5 class="card-header">Here Are The List Of Your Delivery Time <a href='deliverytime/add' class="btn btn-sm btn-success float-right"><b>+ ADD DELIVERY TIME</b></a></h5>
                            <div class="card-body">
                            @php
                                    $count = 0;
                                @endphp
                                <div class="row">
                                        	@foreach($deliverytime as $deliverytimes)
                                            @php
                                                $count++;
                                            @endphp
                                            <div class="col-sm-12 col-md-6 col-lg-4">
                                                <div class="card border-dark mb-3">
                                                    <div class="card-body bg-light border-primary mb-3">
                                                    <div class="row text-center">
                                                    <div class="col">{{$count}}</div>
                                                    <div class="col"><a href="deliverytime/edit/{{ $deliverytimes->id }}" class="btn btn-sm btn-block btn-primary">UPDATE DELIVERY TIME</a></div>
                                                    <div class="col"><input type="checkbox" class="bulk" id="{{ $deliverytimes->id }}" name="deliverytime_id[]" /><b style="color: #5E2CED;"></b></div>
                                                    </div><hr><br>

                                                    Deliverytime: {{ $deliverytimes->value }}
                                                    <br>
                                                    <br>
                                                   {{-- <a href="deliverytime/edit/{{ $deliverytimes->id }}" class="btn btn-block btn-info">Edit</a> --}}
                                                        <a href="deliverytime/delete/{{ $deliverytimes->id }}" class="btn btn-block btn-danger delete" data-confirm="Are you sure to delete this order?">Delete</a>
                                                        @if($deliverytimes->hide == 0)

                                                        <a href="deliverytime/hide/{{ $deliverytimes->id }}" class="btn btn-block btn-success">Hide</a>

                                                        @else

                                                        <a href="deliverytime/unhide/{{ $deliverytimes->id }}" class="btn btn-block btn-warning">Unhide</a>
                                                        @endif

                                                    </div>

                                                    <div class="btn btn-block btn-primary">{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $deliverytimes->created_at )) }}</div>
                                                </div>
                                                </div>
                                            @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
    </div>

@endsection
@section('scripts')

@endsection
