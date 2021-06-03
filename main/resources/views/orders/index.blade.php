@extends('app')
@section('title', 'Orders')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<link href="/css/custom_switch.css" rel="stylesheet">

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
                            <h5 class="card-header">Here Are Your Orders</h5>
                            <div class="card-body">
                            <div class="row">
                              <div class="col-sm-6">

		                            <a href="#!" data-toggle="modal" data-target="#updatetrackingModalBulk" class="btn btn-primary" style="margin-bottom: 10px;" id="bulkupdatebtn">BULK UPDATE</a>
		                   @if(\auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3)
		                        <a href="#!" data-toggle="modal" data-target="#bulkMessageModal" class="btn btn-warning" style="margin-bottom: 10px;" id="bulkupdatebtn">SEND BROADCAST</a>
                                @endif
                                
                                @if(\auth()->user()->role == 1 || auth()->user()->role == 3)
                                <a href="#!" data-toggle="modal" data-target="#deleteModalBulk" class="btn btn-danger" style="margin-bottom: 10px;" id="bulkdeletebtn">BULK DELETE</a>
	                            @endif
                                
                            </div>
                          {{--  <div class="col-sm-3">
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
                            </div> --}}

                            <div class="col-sm-3">
                                <form action="" method="get">
                                    <div class="input-group mb-3">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Search &nbsp;<i class="fa fa-filter"></i></span>
                                      </div>
                                      <input class="form-control" id="filter" type="text" placeholder="" name="order" value="{{ request('order') }}" id="" />


                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>
<div class="" id="cards">
    <div class="scrolling-pagination">
                            <div class="row">
                            @php
                            $count = 0;
                            @endphp
                        @foreach($orders as $order)
                        @php
                            $count++;

                            // customer
                            $customer = App\Customers::find($order->customer_id);
                            $product = App\Products::find($order->product_id);
                        @endphp

                        <div class="col-md-4 col-sm-4">
                            <!-- cards -->
                            <div class="card card-object">
                                <h5 class="card-header text-center">
                                    <div class="row">
                                    <div class="col">{{ $count }}</div>

                                    <div class="col"><a href="#!" data-toggle="modal" data-target="#updatetrackingModal{{ $order->id }}" class="btn btn-sm btn-block btn-primary">UPDATE ORDER STATUS<center>                                             @if($order->delivery_status == 'shipped')

                                            <b style="color: #FFFFFF;">{{ ucwords($order->delivery_status) }}</b>

                                            @elseif($order->delivery_status == '')
                                            <b style="color: #FFFFFF;">{{ ucwords($order->delivery_status) }}</b>

                                              @elseif($order->delivery_status == 'delivered')
                                            <b style="color: #FFFFFF;">{{ ucwords($order->delivery_status) }}</b>

                                             @else

                                                <b style="color: #FFFFFF;">{{ ucwords($order->delivery_status) }}</b>
                                              @endif
</center></a>
</div>
                                    <div class="col"><input type="checkbox" class="bulk" id="{{ $order->id }}" name="order_id[]" /><b style="color: #5E2CED;"></b></div>
                                    </div>
                                </h5>


 <div class="card-body" style="padding: 20px;">

                                  <div class="">

{{-- <h5 class="card-header"> <div style="padding: 20px;"> </div> </h5> --}}
                                        <div style="padding-top: 20px;">
                                            <ul>
                                                <li>Customer Name: {{ $customer->fullname ?? '' }}</li>

                                            <li>Address: {{ $customer->address ?? '' }}</li>

                                            <li>State: {{ $customer->state ?? '' }}</li>

                                            <li>Phone Number: <a href="tel:{{ $customer->phonenumber }}"> {{ $customer->phonenumber }}</a></li>

                                            <li>Alternative Phone No.: <a href="tel:{{ $customer->phonenumber_two }}"> {{ $customer->phonenumber_two }}</a></li>
                                            <li>Order Number: {{ $order->invoice }}</li>
                                            {{--Product ID: {{ @$product->id }}--}}
                                           {{-- <li>Product Quantity: {{ $order->product_qty }}</li> --}}
                                             <li>Product Detail: {{ $order->product_qty }} {{ @$product->title }}</li>
                                             <li>Product Price: ₦{{ $order->product_total_price }}</li>
                                            
                                                </ul>
                                        </div>


                                       {{-- <h5 class="card-header">COMMENT</h5> --}}
                                        <div style="padding: 20px;">
                                            <form action="{{ url()->current() }}/comment" method="post">
                                                @csrf
                                                <input name="order_id" value="{{ $order->id }}" hidden/>
                                                <textarea name="comment" class="form-control" placeholder="What is the current update on this order? Type it in." style="height: 100px;">{{ $order->comment }}</textarea>
                                                <button class="btn btn-sm btn-block btn-primary" type="submit">SUBMIT</button>
                                            </form>
                                        </div>

                                        <div style="padding: 20px; text-align: center;">
                                          @if($order->order_shared_with != 0)

@if($order->order_shared_with == auth()->id()) 
 <div class="custom-switch custom-switch-label-yesno">
  <input class="custom-switch-input" @if($order->order_shared_delivered == 'yes') checked="checked" @endif onclick="switchShareOrder(this.value, {{ $order->id }})" id="example_3" name="" type="checkbox">
<label class="custom-switch-btn" for="example_3"></label>

<div class="custom-switch-content-checked">
    <span class="text-success">Delivered</span>
  </div>

  <div class="custom-switch-content-unchecked">
    <span class="text-danger">Not Delivered</span>
  </div>

@else 

<div class="custom-switch custom-switch-label-yesno">
<input class="custom-switch-input" disabled="disabled" onclick="return false;" @if($order->order_shared_delivered == 'yes') checked="checked" @endif type="checkbox">
@if($order->order_shared_delivered == 'yes')
  <div class="custom-switch-content-checked">
    <span class="text-success">Delivered</span>
  </div>
@else
  <div class="custom-switch-content-unchecked">
    <span class="text-danger">Not Delivered</span>
  </div>
@endif

@endif
  

</div>
<div class="form-group text-center">
  <br>
  @if($order->order_shared_with != auth()->id())

    <h4>This order has been shared with:</h4>
    @php
    $shared_with = App\User::find($order->order_shared_with);
    @endphp
    <h4>Business Name: {{ $shared_with->business()->business_name }}</h4>
    
    <h4>Business Email: {{ $shared_with->email_address }}</h4>
    
    <h4>Business Phone Number: {{ $shared_with->business_phone_number }}</h4>

  @else 
    <h4>This order has been shared by:</h4>
    @php
    $shared_by = App\User::find($order->business_id);
    @endphp
    <h4>Business Name: {{ $shared_by->business()->business_name }}</h4>
    
    <h4>Business Email: {{ $shared_by->email_address }}</h4>
    
    <h4>Business Phone Number: {{ $shared_by->business_phone_number }}</h4>
  @endif
  
  </div>
                                          @endif
                                        </div>


                                       {{-- <h5 class="card-header">DELIVERY DETAILS</h5> --}}
                                        <div style="padding-top: 5px;">
                                            <ul>
                                                
                                            {{-- <li>Email: {{ $customer->email }}</li> --}}


                                                </ul>
                                        </div>
                                       {{-- <h5 class="card-header">STATUS</h5> --}}

                                                                                    {{-- <h5 class="card-header">MANAGE</h5> --}}
                                        <div style="padding: 5px;">

                                            @if(\auth()->user()->role == 1 || auth()->user()->role == 3 || auth()->user()->role == 2)
                                            <a href="/orders/edit/{{ $order->id }}" class="btn btn-sm btn-block btn-info">EDIT ORDER</a>
                                      
                                            @endif
                                            @if(\auth()->user()->role == 1 || auth()->user()->role == 3)
                                            <a href="/orders/delete/{{ $order->id }}" class="btn btn-sm btn-block btn-danger delete" data-confirm="Are you sure to delete this order?">DELETE ORDER</a>
                                            @endif
                                          <a target="_blank" href="/view_invoice/{{ $order->invoice }}/{{ $order->id }}" class="btn btn-sm btn-block btn-success" style="margin-bottom: 10px;">ORDER RECEIPT</a>

<a href="#" data-toggle="modal" data-target="#sendMessage{{ $order->id }}" class="btn btn-sm btn-block btn-warning" style="margin-bottom: 10px;">SEND MESSAGE</a>

                                          <div class="dropdown">
                                            <button class="btn btn-sm btn-block btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SEND ORDER</button>

                                            <textarea style="position: absolute;
opacity: 0;" id="copy_order{{ $order->id }}">
Customer Name: {{ $customer->fullname ?? '' }}
Address: {{ $customer->address }}
State: {{ $customer->state }}
Phone Number: {{ $customer->phonenumber }}
Alternative Phone No.: {{ $customer->phonenumber_two }}
Order Number: {{ $order->invoice }}
Product Quantity: {{ $order->product_qty }}
Product Name: {{ $product->title ?? '' }}
Product Price: ₦{{ $order->product_total_price }}
</textarea>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<a class="dropdown-item" href="#" onclick="myFunction({{ $order->id }})">Copy to Clipboard</a>

<input name="business_id" id="business_id" value="{{ $order->business_id }}" hidden/>
<a class="dropdown-item" href="whatsapp://send?text=Customer Name: {{ $customer->fullname ?? '' }}
Address: {{ $customer->address }}
State: {{ $customer->state }}
Phone Number: {{ $customer->phonenumber }}
Alternative Phone No.: {{ $customer->phonenumber_two }}
Order Number: {{ $order->invoice }}
Product Quantity: {{ $order->product_qty }}
Product Name: {{ $product->title ?? '' }}
Product Price: ₦{{ $order->product_total_price }}" data-action="share/whatsapp/share">Send via WhatsApp</a>

<a class="dropdown-item" a href="sms:?&body=Customer Name: {{ $customer->fullname ?? '' }}
Address: {{ $customer->address }}
State: {{ $customer->state }}
Phone Number: {{ $customer->phonenumber }}
Alternative Phone No.: {{ $customer->phonenumber_two }}
Order Number: {{ $order->invoice }}
Product Quantity: {{ $order->product_qty }}
Product Name: {{ $product->title ?? '' }}
Product Price: ₦{{ $order->product_total_price }}">Send via SMS</a>


<a class="dropdown-item" target="_blank" href="mailto:?subject=Order {{ $order->invoice }}&amp;body=Customer Name: {{ $customer->fullname ?? '' }}

Address: {{ $customer->address }}

State: {{ $customer->state }}

Phone Number: {{ $customer->phonenumber }}

Alternative Phone No.: {{ $customer->phonenumber_two }}

Order Number: {{ $order->invoice }}

Product Quantity: {{ $order->product_qty }}

Product Name: {{ $product->title ?? '' }}

Product Price: ₦{{ $order->product_total_price }}">Send via Email</a>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>


                             <div class="dropdown">
                             <button class="btn btn-sm btn-block btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $order->created_at )) }}</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    
    <div class="dropdown-item">
        <li>When To Deliver: {{ $order->delivery_time }}</li>
        </div>
        
        <div class="dropdown-item">
        <li>Email: {{ $customer->email }}</li>
        </div>
        </div>
        </div>

                            </div>
                            <!-- cards -->
                        </div>







                        <div class="modal" id="sendMessage{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Send Message To {{ $customer->fullname ?? '' }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="" method="post" id="tracking_status_form">
                                       <div id="tracking_status_msg"></div>
                                        <div class="text-center">
                                            <input name="sendmessagechannel" type="checkbox" id="sendmessagechannel{{ $order->id }}" value="all" style="margin-bottom: 10px;" class="sendmessagechannel"> Both.

                                <input name="channel" type="checkbox" id="sendmessagechannel{{ $order->id }}" value="email" style="margin-bottom: 10px;" class="sendmessagechannel"> Email Only.
                                <input name="channel" type="checkbox" id="sendmessagechannel{{ $order->id }}" value="sms" style="margin-bottom: 10px;" class="sendmessagechannel"> SMS Only.
                                        </div>

                                              <div class="form-group" style="padding: 20px;">
                                                <textarea name="message" class="form-control summernote" placeholder="Message" id="sendmessageitem{{ $order->id }}"></textarea>
                                              </div>

                                      </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" id="addrecipient_close" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Close</button>
                                  <button type="button" id="sendMessageBtn{{ $order->id }}" class="btn btn-primary" onclick="sendMessage({{ $order->id }})">Send</button>
                                </div>
                              </div>
                            </div>
                          </div>




                        <div class="modal" id="updatetrackingModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Update The Order Status</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="" method="post" id="tracking_status_form">
                                       <div id="tracking_status_msg"></div>
                                        <div class="">
                                              <div class="form-group" style="padding: 20px;">
                                                    <label>Select The Order Status You Want To Update</label>
                                                       <select name="tracking_status" id="tracking_status{{ $order->id }}" style="height: 50px;" class="form-control tracking_status">
                                                           <option value="">CHOOSE</option>
                                                           
                                                           @if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3)
                                                           <option value="Ready For Delivery" status="Item sent out for delivery">Ready For Delivery</option>
                                                           <option value="cancelled" status="Item went out, delivery failed and half fee is to be charged">Cancelled</option>
                                                           <option value="pending" status="Item went out, delivery failed and half fee is to be charged">Pending</option>
                                                           @endif
                                                           
                                                           @if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3 || auth()->user()->role == 4)
                                                           <option value="delivered" status="Item went out, delivery failed and half fee is to be charged">Delivered</option>
                                                           @endif
                                                           
                                                           
                                                           @if(auth()->user()->role == 1 || auth()->user()->role == 4 || auth()->user()->role == 3)
                                                           <option value="shipped" status="Item/Package delivered successfully to customer">Shipped</option>
                                                           <option value="Payment Received" status="Item went out, delivery failed and half fee is to be charged">Payment Received</option>
                                                           <option value="refunded" status="Item went out, delivery failed and half fee is to be charged">Refunded</option>
                                                           <option value="shared" status="shared">Shared</option>
                                                           @endif

                                                    </select>

                                                    <div class="form-group" id="share_with">
                                                      <label>Share with:</label>
                                                      <input name="share_to" id="share_to{{ $order->id }}" onblur="checkBusinessEmail(this.value, {{ $order->id }})" type="email" class="form-control" placeholder="Type in email address to share with.">
                                                    </div>

                                              </div>
                                          </div>
                                      </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" id="addrecipient_close" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Close</button>
                                  <button type="button" class="btn btn-primary" id="tracking_status_save{{ $order->id }}" onclick="updateOrderStatus({{ $order->id }})">Save</button>
                                </div>
                              </div>
                            </div>
                          </div>



                              <script>

                            </script>

                        @endforeach
                        {{ $orders->appends(request()->query())->links() }}
                            </div>

                            </div>
                        </div>
                        </div>
                    </div>
    </div>

    <div class="modal" id="bulkMessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Send Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="post" id="tracking_status_form">
                   <div id="tracking_status_msg"></div>
                    <div class="">
                          <div class="form-group" style="padding: 20px;">

                                <br>
                                <input name="channel" type="checkbox" id="channel" value="all" style="margin-bottom: 10px;" class="channel"> Both.
                                <input name="channel" type="checkbox" id="channel" value="email" style="margin-bottom: 10px;" class="channel"> Email Only.
                                <input name="channel" type="checkbox" id="channel" value="sms" style="margin-bottom: 10px;" class="channel"> SMS Only.

                                <br>
                                <input name="all" type="checkbox" id="allcustomers" value="" style="margin-bottom: 10px;"> All customers.
                                   <br>
                                   <select name="status" id="statuscustomer" style="height: 50px; margin-bottom: 10px;" class="form-control">
                                       <option value="">Choose Status</option>
                                       
@if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3)
<option value="pending" status="Item went out, delivery failed and half fee is to be charged">Pending ({{ App\Orders::where('delivery_status', 'pending')->count() }})</option>
<option value="Ready For Delivery" status="Item went out, delivery failed and half fee is to be charged">Ready For Delivery ({{ App\Orders::where('delivery_status', 'Ready For Delivery')->count() }})</option>
<option value="cancelled" status="Item went out, delivery failed and half fee is to be charged">Cancelled ({{ App\Orders::where('delivery_status', 'cancelled')->count() }})</option>
@endif


@if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3 || auth()->user()->role == 4)
<option value="delivered" status="Item/Package delivered successfully to customer">Delivered ({{ App\Orders::where('delivery_status', 'delivered')->count() }})</option>
@endif 


@if(auth()->user()->role == 1 || auth()->user()->role == 4 || auth()->user()->role == 3)

<option value="shipped" status="Item sent out for delivery">Shipped ({{ App\Orders::where('delivery_status', 'shipped')->count() }})</option>
<option value="refunded" status="Item went out, delivery failed and half fee is to be charged">Refunded ({{ App\Orders::where('delivery_status', 'refunded')->count() }})</option>
<option value="Payment Received" status="Item went out, delivery failed and half fee is to be charged">Payment Received ({{ App\Orders::where('delivery_status', 'Payment Received')->count() }})</option>
@endif
                                       


                                </select>
                                <textarea name="message" class="form-control summernote" placeholder="Message" id="messagebulk"></textarea>
                                {{-- <label>Attachment (image)</label> --}}
                                {{-- <input type="file" name="attach" id="attach" class="form-control" /> --}}
                          </div>
                      </div>
                  </form>
            </div>
            <div class="modal-footer">
              <button type="button" id="addrecipient_close" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="sendBulkMessageBtn" onclick="sendBulkMessage()">Send</button>
            </div>
          </div>
        </div>
      </div>

<div class="modal" id="updatetrackingModalBulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Bulk Update The Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="bulk_tracking_status_form">
             <div id="bulk_tracking_status_msg"></div>
              <div class="">
	              <div class="form-group" style="padding: 20px;
    margin-bottom: -20px;">
                          <label>Orders</label>
						  <input class="form-control" value="" id="orders_id" readonly />
	              </div>
                    <div class="form-group" style="padding: 20px;">
                          <label>Select The Order Status You Want To Update</label>
                             <select name="bulk_tracking_status" id="bulk_tracking_status" style="height: 50px;" class="form-control bulk_tracking_status">
                                 <option value="">Choose</option>
                                 
                                                           @if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3)
                                                           <option value="Ready For Delivery" status="Item sent out for delivery">Ready For Delivery</option>
                                                           <option value="pending" status="Item went out, delivery failed and half fee is to be charged">Pending</option>
                                                           <option value="cancelled" status="Item went out, delivery failed and half fee is to be charged">Cancelled</option>
                                                           @endif
                                                           
                                                         
                                                           
                                                           @if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3 || auth()->user()->role == 4)
                                                           <option value="delivered" status="Item went out, delivery failed and half fee is to be charged">Delivered</option>
                                                           @endif
                                                           
                                                           @if(auth()->user()->role == 1 || auth()->user()->role == 4 || auth()->user()->role == 3)
                                                           
                                                           <option value="shipped" status="Item/Package delivered successfully to customer">Shipped</option>
                                                           <option value="Payment Received" status="Item went out, delivery failed and half fee is to be charged">Payment Received</option>
                                                           <option value="refunded" status="Item went out, delivery failed and half fee is to be charged">Refunded</option>
                                                           @endif

                          </select>

                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
	      <button type="button" id="clearbulk" class="btn btn-secondary">Clear Bulk</button>
        <button type="button" id="addrecipient_close" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Close</button>
        <button type="button" class="btn btn-primary" id="bulk_tracking_status_save" onclick="updateOrderStatusBulk()">Save</button>
      </div>
    </div>
  </div>
</div>



<div class="modal" id="deleteModalBulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Bulk Delete Orders</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="bulk_delete_status_form">
             <div id="bulk_delete_status_msg"></div>
              <div class="">
                <div class="form-group" style="padding: 20px;
    margin-bottom: -10px;">
                          <label>Orders</label>
              <input class="form-control" value="" id="delete_orders_id" readonly />
                </div>

            </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="clearbulk" class="btn btn-secondary">Clear Bulk</button>
        <button type="button" id="addrecipient_close" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Close</button>
        <button type="button" class="btn btn-primary" id="bulk_delete_status_save" onclick="deleteBulkOrders()">Delete</button>
      </div>
    </div>
  </div>
</div>




</div>

@endsection
@section('scripts')
<script src="/libs/js/axios.min.js"></script>
<script src="/libs/js/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script>

  function myFunction(id) {

 /* Get the text field */
 var copyText = document.getElementById('copy_order' + id)

 /* Select the text field */
 copyText.select();
 copyText.setSelectionRange(0, 99999); /*For mobile devices*/

 /* Copy the text inside the text field */
 document.execCommand("copy");

 /* Alert the copied text */
 alert("Copied the text: " + copyText.value);

 }
</script>

<script>

$('.remit-form').hide();
$('.bulk_remit-form').hide();
const order_ids = [];

$('#allcustomers').on('click', function() {
	if (!this.checked) {
		$('#statuscustomer').show();
	} else {
		$('#statuscustomer').hide();
	}
});

setTimeout(() => {
	let bulk = $('.bulk').val();
	if(bulk == 0) {
		orders_id.pop();
	}
}, 100);

$('.bulk_all').on('change', function() {

	$('input:checkbox').not(this).prop('checked', this.checked);

	// show button
	$('#bulkupdatebtn').show();

	if (this.checked) {

		$('.bulk').each(function() {
			if($(this).attr('id')) {
				order_ids.push($(this).attr('id'));
				$('#orders_id').val(order_ids.length);
        $('#delete_orders_id').val(order_ids.length);
			}

	    });

	}

});

$('#clearbulk').click(function() {
	order_ids.length = 0;
	$('#orders_id').val(order_ids.length);
  $('#delete_orders_id').val(order_ids.length);
	$('input:checkbox').prop('checked', false);

});

$('.bulk_all').on('change', function() {

	var checked = $('input[class^=bulk]:checked').length;
    if (checked == 0) { order_ids.length = 0; $('#orders_id').val(order_ids.length); };

});

$('.bulk').on('change', function() {
	// show button
	$('#bulkupdatebtn').show();
	if(this.checked) {
		order_ids.push($(this).attr('id'));
		$("#orders_id").val(order_ids.length);
    $('#delete_orders_id').val(order_ids.length);
	}

});

$('.bulk').on('change', function() {

	if(!$(this).is(':checked')) {
		order_ids.remove($(this).val());
		$("#orders_id").val(order_ids.length);
    $('#delete_orders_id').val(order_ids.length);
	}

});


$('#allcustomers').on('click', function() {
	if (this.checked) {
		this.val('all');
	} else {
		this.val('');
	}
});

function updateOrderStatusBulk() {

	let tracking_status_msg = $('#bulk_tracking_status_msg');

            // forms
            let tracking_status = $('#bulk_tracking_status').val();
            let tracking_status_description = 'null';
            let remittedvalue = $('#bulk_remittedvalue').val();


            let data = {
                id: order_ids,
                tracking_status,
                tracking_status_description: tracking_status_description,
                remittedvalue: remittedvalue
            };


            console.log(data);
            $('#bulk_tracking_status_save').attr('disabled', 'disabled');

            $('#bulk_tracking_status_save').text('Please wait...');

            // send request
          axios.post('/api/tracking_status/add_bulk', {
             data
          }).then(function (response) {
		    console.log(response);
		    $('#bulk_tracking_status_save').removeAttr('disabled');
		    $('#bulk_tracking_status_save').text('Save');


		    swal.fire("Success!", "Order status for (" + order_ids.length + ") updated!", "success");

                setTimeout(function() {
                    location.reload();
                }, 2000);


		  })
		  .catch(function (error) {
		    console.log(error);
		  });

}

function deleteBulkOrders() {

            let data = {
                id: order_ids
            };


            console.log(data);
            $('#bulk_delete_status_save').attr('disabled', 'disabled');

            $('#bulk_delete_status_save').text('Please wait...');

            // send request
          axios.post('/api/orders/delete_bulk', {
             data
          }).then(function (response) {
        console.log(response);
        $('#bulk_delete_status_save').removeAttr('disabled');
        $('#bulk_delete_status_save').text('Save');


        swal.fire("Success!", "Deleting for (" + order_ids.length + ") done!", "success");

                setTimeout(function() {
                    location.reload();
                }, 4000);


      })
      .catch(function (error) {
        console.log(error);
      });

}


function sendMessage(order_id) {
    let message = $('#sendmessageitem' + order_id).val();
    let channel  = $('.sendmessagechannel:checked').val();
    let business_id = $('#business_id').val();

    let data = {
        order_id: order_id,
        message: message,
        channel: channel,
        business_id: business_id
    }

    $.ajax({
        url: "/api/sendmessage",
        method: "POST",
        data: data,
        beforeSend: function() {
            $('#sendMessageBtn' + order_id).attr('disabled', 'disabled');
            $('#sendMessageBtn' + order_id).text('Please wait...');
        },
        success:function(data) {
            $('#sendMessageBtn' + order_id).removeAttr('disabled');
            $('#sendMessageBtn' + order_id).text('Send');
            swal.fire("Success!", "Message sent!", "success");
        },
        error:function(err) {
            console.log(err)
        }
    })
}

function sendBulkMessage() {
			let status = $('#statuscustomer').val();

            // forms
            let message = $('#messagebulk').val();
            let allcustomers = $('#allcustomers');
            let statuscustomers = $('#statuscustomers').val();
            let attachment = document.querySelector('#attach');
			let channel = $('.channel:checked').val();
            let business_id = $('#business_id').val();

            let data = {
                status: status,
                allcustomers: (allcustomers.is(':checked') ? 'yes' : 'no'),
                statuscustomers: statuscustomers,
                message: message,
                channel: channel,
                business_id: business_id
            };

            console.log(channel);

            // send request
            $.ajax({
	            url: "/api/sendBulkMessage",
	            method: "POST",
	            data: data,
	            beforeSend: function() {
		            $('#sendBulkMessageBtn').attr('disabled', 'disabled');
		            $('#sendBulkMessageBtn').text('Please wait...');
	            },
	            success:function(data) {
		            console.log(data);
		            $('#sendBulkMessageBtn').text('Send');
		            $('#sendBulkMessageBtn').removeAttr('disabled');

					swal.fire("Success!", "Broadcast message sent!", "success");
	            },
	            error:function(err) {
		            console.log(err)
	            }
            })

}


$('.bulk_tracking_status').on('change', function() {
	let value = this.value;

	switch(value) {
		case 'remitted':
			// show form
			$('.bulk_remit-form').show();
			break;
		default:
			$('.bulk_remit-form').hide();

	}
});

$('#share_with').hide();

$('.tracking_status').on('change', function() {
	let value = this.value;

	switch(value) {
		case 'shared':
			// show form
			$('#share_with').show();
			break;
		default:
			$('#share_with').hide();

	}
});

Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

function switchShareOrder(value, id) {
  let data = {
    id: id,
    value: value
  };

  $.ajax({
    url: "/api/shareOrderDelivered",
    data: data,
    success:function(data) {

      if(data == 'success') {
        swal.fire("Success!", "Shared Order Delivered.", "success");
      }

      if(data == 'error') {
        swal.fire("Error!", "Shared Order Not Delivered.", "error");
      }

    },
    error:function(err) {
      console.log(err)
    }
  })
}

function checkBusinessEmail(email, id) {
  let data = {
    email: email
  };

  $.ajax({
    url: "/api/checkBusinessEmail",
    data: data,
    beforeSend:function() {
      $('#tracking_status_save' + id).attr('disabled', 'disabled');
      $('#tracking_status_save' + id).text('Please wait..');
    },
    success:function(data) {

      if(data == 'success') {
        $('#tracking_status_save' + id).removeAttr('disabled')
        $('#tracking_status_save' + id).text('Save');
      }

      if(data == 'error') {
        swal.fire("Error!", "Invalid or Unknown Business Email", "error");
      }

    },
    error:function(err) {
      console.log(err)
    }
  })
}

function updateOrderStatus(id) {

            let tracking_status_msg = $('#tracking_status_msg' + id);

            // forms
            let tracking_status = $('#tracking_status' + id).val();
            let tracking_status_description = 'null';
            let share_to = $('#share_to' + id).val();

			// alert(share_to);

            let data = {
                id: id,
                tracking_status,
                tracking_status_description: tracking_status_description,
                share_to: share_to
            };

            // send request
          axios.post('/api/tracking_status/add', {
             data
          });

                swal.fire("Success!", "Order Status Updated!", "success");

                setTimeout(function() {
                    location.reload();
                }, 2000);


         // console.log(data);

}

$('.channel').on('change', function() {
            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
            $('input[value="' + this.name + '"]').val(this.value);
            console.log(this.value);
});

$('.sendmessagechannel').on('change', function() {
            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
            $('input[value="' + this.name + '"]').val(this.value);
            console.log(this.value);
});

$("#filter").keyup(function() {

// Retrieve the input field text and reset the count to zero
var filter = $(this).val(),
  count = 0;

// Loop through the comment list
$('#cards .card-object').each(function() {


  // If the list item does not contain the text phrase fade it out
  if ($(this).text().search(new RegExp(filter, "i")) < 0) {
    $(this).hide();

    // Show the list item if the phrase matches and increase the count by 1
  } else {
    $(this).show();
    count++;
  }

});

});


</script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
    $('.summernote').summernote({
        height: 100,
    });
</script>
@endsection
