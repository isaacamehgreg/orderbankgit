@extends('gadmin')
@section('title', 'Businesses')
@section('content')

<div class="row">
        

  {{--       <div class="col-xl-6 col-lg-2 col-md-6 col-sm-12 col-6">
            <form action="" method="get">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Search &nbsp;<i class="fa fa-search"></i> </span>
                  </div>
                  <input class="form-control" type="text" name="text" value="{{ request('text') }}" placeholder="Find orders by..." />
                  <select name="search_type" class="form-control" style="height: 50px;">
                     <option value="number">Order Number</option>
                  </select>
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-arrow-right"></i></button>
                    <button class="btn btn-danger" type="button" onclick="location.replace('{{ url()->current() }}')"><i class="fa fa-remove"></i></button>
                  </div>
                </div>
            </form>
        </div>
 --}}
        <div class="col-xl-12">
	        @include('messages')

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Businesses under {{ $plan->title ?? '-' }}</h5>
                            <div class="card-body">
                            <div class="row">
                           
                        
                            
                              <div class="col-sm-12">
                              <form action="" method="get">
                                  <div class="input-group mb-3">
                            <div class="input-group-prepend">
                             {{-- <span class="input-group-text" id="basic-addon1">Filters &nbsp;<i class="fa fa-filter"></i></span>--}}
                            </div>
                
                         
                          {{--  <input class="form-control" type="text" name="daterange" value="{{ request('daterange') }}" id="daterange" />--}}
                            {{--         <select name="status" class="form-control" style="height: 50px;">
                                       <option value="">Choose Delivery Time</option>
                                       @foreach(App\DeliveryTimes::where('business_id', auth()->id())->get() as $times)
                                        <option value="{{ $times->value }}">{{ $times->value }}</option>
                                       @endforeach
                                    </select> --}}
                                    
                           {{-- <div class="input-group-append">
                              <button class="btn btn-primary" type="submit"><i class="fa fa-arrow-right"></i></button>
                              <button class="btn btn-danger" type="button" onclick="location.replace('{{ url()->current() }}')"><i class="fa fa-remove"></i></button>
                            </div>--}}
                          </div>
                              </form>
                            </div>
                        </div>
                          
                                <div class="table-responsive" style="padding: 1px;"> 
                                    <table class="table table-striped table-bordered first" style="font-family: 'Proxima Nova Regular' !important">
                                        
                                        <thead>
                                            <tr>
	                                            
                                             {{--   <th><b style="color: #5E2CED;">Date</th>--}}
                                               {{-- <th>Order No.</th>--}}
                                                <th><b style="color: #5E2CED;">CUSTOMER DETAILS</th>
                                                <th><b style="color: #5E2CED;">BUSINESS DETAILS</th>
                                                <th><b style="color: #5E2CED;">SUBSCRIPTION PLAN</th>
                                              <th><b style="color: #5E2CED;">REMARK</th> 
                                                <th><b style="color: #5E2CED;">MANAGE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                          	@foreach($businesses as $business)
                                              @php
                                                  $count = 0;

                                                  // customer
                                                  $profile = App\Business::where('user_id', $business->id)->first();

                                                  $subscription = App\BusinessSubscription::where('subscription_id', $plan->id)->where('user_id', $business->id)->first();
                                              @endphp
                                              <tr>
                            
											  	
                                          	   {{--<td>{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $order->created_at )) }}</td>--}}
                                              {{-- <td><a target="_blank" href="/
                                              
                                              
                                              
                                              _invoice/{{ $order->invoice }}/{{ $order->id }}">{{ $order->invoice }}</a></td>--}}
                                               <td>
                                                  <ul>
                                                      <li>Customer Name: {{ $business->firstname ?? '[empty]' }}</li>
                            
                                                  <li>Address: {{ $business->address ?? '[empty]' }}</li>
                                                  
                                                  <li>Phone Number: {{ $business->phone_number ?? '[empty]' }}</li>
                                                 
                                                 <li> Email: {{ $business->email_address ?? '[empty]' }} </li>
                                                      </ul>
                                                </td>

                                                <td>
                                                   {{--Product ID: {{ @$product->id }}--}}
                                                 <ul>
                                                   <li>Business Name: {{ $profile->business_name ?? '[empty]' }}</li>
                                                   <li>Business Phone Number: {{ $profile->business_phone_number ?? '[empty]' }}</li>
                                                   <li>Business Email Address: {{ $profile->business_email ?? '[empty]' }}</li>
                                                   </ul>
                                                </td>     
                                                <td>
                                                <ul>
                                                <li>Subscribed On: {{ $subscription->created_at }} </li>
                                                <li>Expires On: {{ date('Y-m-d H:i:s', $subscription->end_at) }}</li>
                                                <li>Plan Name: {{ $plan->title }}</li>
                                                </ul>
                                                </td>

                                                <td>
	                                               {{-- <form action="{{ url()->current() }}/comment" method="post">
		                                                @csrf
		                                                <input name="order_id" value="{{ $order->id }}" hidden/>
		                                                <textarea name="comment" class="form-control" placeholder="Enter remark for this order" style="height: 100px;
    width: 150px;">{{ $order->comment }}</textarea>
		                                                <button class="btn btn-sm btn-block btn-primary" type="submit">SUBMIT</button>
                                                    </form> --}}
                                                    -
                                                </td>
                                            
                                                <td>
                                                  <a href="{{ url('gadmin/businesses/update/business_details/'.$business->id) }}" class="btn btn-success">UPDATE BUSINESS DETAILS</a>
                                                  
                                                  <a href="{{ url('gadmin/businesses/update/profile_details/'.$business->id) }}" class="btn btn-secondary">UPDATE USER PROFILE</a>

                                                 
                                                  <a href="{{ url('gadmin/businesses/delete/'.$business->id) }}" class="btn btn-danger delete" data-confirm="Are you sure to delete this order?">DELETE BUSINESS</a>
                                                
                                                @if($business->is_banned)
                                                <a href="{{ url('gadmin/businesses/unban/'.$business->id) }}" class="btn btn-primary">UNBAN</a>
                                                @else
                                                <a href="{{ url('gadmin/businesses/ban/'.$business->id) }}" class="btn btn-primary">BAN</a>
                                                 @endif                     

                                                </td>
                                              </tr>





    <script>
        
  </script>

                                           @endforeach
                                          
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>

@endsection
@section('scripts')
<script src="/libs/js/axios.min.js"></script>
<script src="/libs/js/sweetalert2.all.min.js"></script>
@endsection
