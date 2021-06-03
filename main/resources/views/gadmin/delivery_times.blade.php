@extends('gadmin')
@section('title', 'Delivery Times')
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
                            <h5 class="card-header">Delivery Times</h5>
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
                                               <th><b style="color: #5E2CED;">DATE CREATED</th>
                                                <th><b style="color: #5E2CED;">DELIVERY TIME</th>
                                                <th><b style="color: #5E2CED;">BUSINESS DETAILS</th>
                                              
                                                <th><b style="color: #5E2CED;">MANAGE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                          	@foreach($delivery_times as $time)
                                              @php
                                                  $count = 0;

                                                  // customer
                                                  $profile = App\Business::where('user_id', $time->business_id)->first();

                                              @endphp
                                               <tr>

                                                <td>{{ $time->created_at }}</td>
                                                
                                               <td>{{ $time->value}}</td>
                                               
                                              
                                                <td>
                                                   {{--Product ID: {{ @$product->id }}--}}
                                                 <ul>
                                                   <li>Business Name: {{ $profile->business_name ?? '[empty]' }}</li>
                                                   <li>Business Phone Number: {{ $profile->business_phone_number ?? '[empty]' }}</li>
                                                   <li>Business Email Address: {{ $profile->business_email ?? '[empty]' }}</li>
                                                   </ul>
                                                </td>     
                                            
                                            
                                                <td>

                                                  <a href="{{ url('gadmin/delivery_time/edit/'.$time->id) }}" class="btn btn-success">EDIT</a>

                                                  <a href="{{ url('gadmin/delivery_time/delete/'.$time->id) }}" class="btn btn-danger delete" data-confirm="Are you sure to delete this delivery time?">DELETE</a>
                                                  
                                                  <a href="" class="btn btn-secondary">HIDE</a>
                                                                                               
                                                  <a href="" class="btn btn-primary">DISABLE</a>
                                                                      
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
