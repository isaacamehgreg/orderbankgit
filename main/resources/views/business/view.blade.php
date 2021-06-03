@extends('app')
@section('title', 'Manage Business Account')
@section('content')

<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <form action="" method="get">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Search &nbsp;<i class="fa fa-search"></i> </span>
          </div>
          <input class="form-control" type="text" name="text" value="{{ request('text') }}" placeholder="Search Business..." />
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
                    <h5 class="card-header">Business statistics.</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="#!">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-inline-block">
                                                <h5 class="text-muted">Total Business</h5>
                                                <h3 class="mb-0">{{$businesses->count()}}</h3>
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
                                                <h5 class="text-muted">Subscription Spendings</h5>
                                                <h3 class="mb-0">{{$subscription->sum('price')}}</h3>
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
                            <h5 class="card-header">Here Are The List Of Business</h5>
                            <div class="card-body">
                                    @php
                                        $count = 0;
                                    @endphp

                                <div class="row">
                                    @foreach($businesses as $business)
                                    @php
                                                $count++;
                                            @endphp
                                            <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="card border-dark mb-3">
                                                <div class="card-body bg-light border-primary mb-3">
                                                <div class="row text-center">
                                                <div class="col">{{$count}}</div>
                                                <div class="col"><a href="products/edit/{{ $business->id }}" class="btn btn-sm btn-block btn-primary">UPDATE BUSINESS</a></div>
                                                <div class="col"><input type="checkbox" class="bulk" id="{{ $business->id }}" name="business_id[]" /><b style="color: #5E2CED;"></b></div>
                                                </div>
                                                <hr><br>

                                                <li>Business Name: {{ $business->business_name }}</li>
                                                <li>Business Logo: <img src="{{ url($business->business_logo) }}" alt="{{$business->business_name}}" height="30px" width="30px"></li>
                                                <li>Business Phone Number: {{ $business->business_phone_number }}</li>
                                                <li>Business Email: {{ $business->business_email }}</li>
                                                <li>Business Address: {{ $business->business_address }}</li>
                                                <li>
                                                    @if(Cache::has('user-is-online-' . $business->id))
                                                        Status: <span class="text-success">Online</span>
                                                    @else
                                                        Status: <span class="text-secondary">Offline</span>
                                                    @endif
                                                </li>
                                                <li>
                                                    Last Seen: {{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $business->user->last_seen )) }}
                                                </li>
                                                <li>Account ID: {{ $business->id }}</li>
                                                <li>Wallet Balance: {{ $business->wallet->amount }}</li>
                                                <a href="{{ route('business.access', ['id' => $business->id]) }}" class="btn btn-block btn-success float-left">Access Business</a>
                                                @if($business->user->is_banned == 1)
                                                <a href="{{ url('gadmin/businesses/unban/'.$business->id) }}" class="btn btn-primary btn-block float-left">Unblock Business </a>
                                                @else
                                                <a href="{{ url('gadmin/businesses/ban/'.$business->id) }}" class="btn btn-primary btn-block float-left">Block Business</a>
                                                 @endif
                                                <a href="{{ route('business.delete', ['id' => $business->id]) }}" class="btn btn-block btn-danger float-right">Delete Business</a>
                                                </div>
                                                <div class="btn btn-block btn-primary">{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $business->created_at )) }}</div>
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



