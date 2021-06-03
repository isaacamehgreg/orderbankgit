@extends('app')
@section('title', 'Waybill - View waybill - '.$waybill->waybill_code)
@section('content')
 <link rel="stylesheet" type="text/css" href="/vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/buttons.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/select.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/fixedHeader.bootstrap4.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@php
    $creator = App\User::find($waybill->creator_id);
    $recipient = App\Recipients::find($waybill->recipient_id);

    // packages amount total
    $packages_amount = array_sum(json_decode($waybill->packages_item_total_price));

@endphp
<style>
h4 {
    font-size: 13px !important;
}
span {
    color: #6c757dc9;
    font-weight: bold;
    font-family: sans-serif;
    font-size: 12px;
}

ul.timeline {
    list-style-type: none;
    position: relative;
}
ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
}

ul.timeline > li {
    margin: 20px 0;
    padding-left: 20px;
}

ul.timeline > li:before {
    content: ' ';
    background: white;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid #22c0e8;
    left: 20px;
    width: 20px;
    height: 20px;
    z-index: 400;
}

ul.timeline > li:nth-of-type(1):before {
    content: ' ';
    background: #22c0e8;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid #22c0e8;
    left: 20px;
    width: 20px;
    height: 20px;
    z-index: 400;
}
</style>
<div class="row">
    <div class="col-xs-3" style="margin-left: 15px;">
        <button class="btn btn-success" data-toggle="modal" data-target="#updatetrackingModal">Update tracking</button>
    </div>
    
    @if(\auth()->user()->role == 1)
    <div class="col-xs-3" style="margin-left: 15px;">
        <a class="btn btn-primary" href="/waybills/edit/{{ $waybill->waybill_code }}">Edit waybill</a>
    </div>

        <div class="col-xs-3" style="margin-left: 15px;">
            <a class="btn btn-danger" href="/waybills/delete/{{ $waybill->waybill_code }}">Delete waybill</a>
        </div>
    @endif
    <div class="col-xl-3 col-lg-4 col-md-8 col-sm-12 col-12">
        <form>
            <div class="form-group">
                <button onclick="printDiv('printableArea')"  class="btn btn-default" style="@if(\auth()->user()->role == 1) width: 320px; @else width: 580px; @endif">Print waybill</button>
            </div>
        </form>
    </div>
    
</div>  
<div class="row" id="printableArea">
    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Shipper</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <span>Address</span>
                        <p>{{ $creator->address }}</p>
                    </div>

                    <div class="col-sm-3">
                        <span>Phone number</span>
                        <p>{{ $creator->phone_number }}</p>
                    </div>

                    <div class="col-sm-3">
                        <span>Email</span>
                        <p>{{ $creator->email_address }}</p>
                    </div>

                    <div class="col-sm-3">
                        <span>Shipper Name</span>
                        <p>{{ $creator->firstname }} {{ $creator->lastname }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Recipient</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <span>Address</span>
                        <p>{{ @$recipient->address }}</p>
                    </div>

                    <div class="col-sm-3">
                        <span>Order Status</span>
                        <p>{{ $waybill->delivery_status }}</p>
                    </div>

                    <div class="col-sm-3">
                        <span>Payment Method</span>
                        <p>{{ ucwords(str_replace('_', ' ', $waybill->payment_method)) }}</p>
                    </div>

                    <div class="col-sm-3">
                        <span>Receiver Name</span>
                        <p>{{ @$recipient->firstname }} {{ @$recipient->lastname }}</p>
                    </div>

                    <div class="col-sm-3">
                        <br>
                        <span>Receiver Phone Number</span>
                        <p>{{ @$recipient->phonenumber }}, {{ @$recipient->phonenumber_two }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">

                <div class="card">
                    <h5 class="card-header">Packages</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <span>No. Of Packages</span>
                                <p>{{ $waybill->packages_count }}</p>
                            </div>

                            <div class="col-sm-6">
                                <span>Packages Weight</span>
                                <p>{{ $waybill->packages_weight }} KG</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-6">

                <div class="card">
                    <h5 class="card-header">Shipping Cost</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <span>Processing Fee</span>
                                <p>N{{ $waybill->shipping_fee }}</p>
                            </div>

                            <div class="col-sm-6">
                                <span>Additional Services</span>
                                <p>N0.0</p>
                            </div>

                            
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="card">
            <h5 class="card-header">Payment</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <span>Original Amount Due</span>
                        <p>N{{ number_format($packages_amount) }}</p>
                    </div>

                    <div class="col-sm-6">
                        <span>Amount Settled By Client</span>
                        <p>N{{ number_format($packages_amount) }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Tracking</h5>
            <div class="card-body" style="padding: 5px;">
            <ul class="timeline">
                @foreach(App\WaybillTracking::where('waybill_id', $waybill->id)->orderBy('id', 'DESC')->get() as $tracking)
                <li>
                    <a>{{ ucwords($tracking->status) }}</a>
                    <h4 style="margin-bottom: 0px;">{{ ucwords($tracking->desc) }}</h4>
                    <a style="color: #70777b; font-size: 12px; font-family: 'Proxima Nova Light'">{{ date('F dS Y, H:i:s A', strtotime($tracking->created_at)) }}</a>
                </li>
                @endforeach
            </ul>
            </div>
        </div>
    </div>

</div>

<div class="modal" id="updatetrackingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tracking Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="tracking_status_form">
             <div id="tracking_status_msg"></div>
              <div class="">
                    <div class="form-group" style="padding: 20px;">
                          <label>Status</label>
                             <select name="tracking_status" id="tracking_status" style="height: 50px;" class="form-control">
                                 <option value="">Choose</option>
                                 <option value="delivered" status="Item/Package delivered successfully to customer">Delivered</option>
                                 <option value="shipped" status="Item sent out for delivery">Shipped</option>
                                 <option value="rescheduled" status="Customer picked another date for his item delivery">Rescheduled</option>
                                 <option value="pending" status="Customer not responding, not picking calls">Pending</option>
                                 <option value="cancelled" status="Customer not interested, delivery didn't take place">Cancelled</option>
                                 <option value="returned to logistics" status="Item went out, delivery failed and half fee is to be charged">Returned To Logistics</option>
                          </select>
                          <label>Description</label>
                          <textarea type="text" name="description" id="desc" class="form-control"></textarea>
                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="addrecipient_close" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="tracking_status_save">Save</button>
      </div>
    </div>
  </div>
</div>
 @endsection
 @section('scripts')
 <script src="/libs/js/axios.min.js"></script>
<script src="/libs/js/sweetalert2.all.min.js"></script>

    <script>
        $('#tracking_status').on('change', function() {
            let status = $('option:selected', this).attr('status');
            $('#desc').html(status);
        });

        $('#tracking_status_save').on('click', function() {
            let tracking_status_msg = $('#tracking_status_msg');

            // forms
            let tracking_status = $('#tracking_status').val();
            let tracking_status_description = $('#desc').val();

            let data = {
                id: '{{ $waybill->id }}',
                tracking_status: tracking_status,
                tracking_status_description: tracking_status_description,
                date: new Date()
            };

            // send request
          axios.post('/api/tracking_status/add', {
             data
          });

                swal.fire("Success!", "Tracking updated!", "success");

                setTimeout(function() {
                    location.reload();
                }, 2000);


         // console.log(data);

    });
    
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
    </script>
 @endsection