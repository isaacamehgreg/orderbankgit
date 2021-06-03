@extends('app')
@section('title', 'Waybill - View waybills')
@section('content')
 <link rel="stylesheet" type="text/css" href="/vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/buttons.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/select.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/fixedHeader.bootstrap4.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">
        <div class="col-xl-6 col-lg-2 col-md-6 col-sm-12 col-6">
            <form action="" method="get">
                <div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="basic-addon1">Filters &nbsp;<i class="fa fa-filter"></i></span>
				  </div>
				  <input class="form-control" type="text" name="daterange" value="{{ request('daterange') }}" id="daterange" />
                  <select name="status" class="form-control" style="height: 50px;">
                     <option value="">Choose Status</option>
                     <option value="delivered" status="Item/Package delivered successfully to customer">Delivered</option>
                     <option value="shipped" status="Item sent out for delivery">Shipped</option>
                     <option value="rescheduled" status="Customer picked another date for his item delivery">Rescheduled</option>
                     <option value="pending" status="Customer not responding, not picking calls">Pending</option>
                     <option value="cancelled" status="Customer not interested, delivery didn't take place">Cancelled</option>
                     <option value="returned to logistics" status="Item went out, delivery failed and half fee is to be charged">Returned To Logistics</option>
                  </select>
				  <div class="input-group-append">
				    <button class="btn btn-primary" type="submit"><i class="fa fa-arrow-right"></i></button>
				    <button class="btn btn-danger" type="button" onclick="location.replace('{{ url()->current() }}')"><i class="fa fa-remove"></i></button>
				  </div>
				</div>
            </form>
        </div>

        <div class="col-xl-6 col-lg-2 col-md-6 col-sm-12 col-6">
            <form action="" method="get">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Search &nbsp;<i class="fa fa-search"></i> </span>
                  </div>
                  <input class="form-control" type="text" name="text" value="{{ request('text') }}" placeholder="Find waybills by..." />
                  <select name="search_type" class="form-control" style="height: 50px;">
                     <option value="number">Waybill Number</option>
                     <option value="area">Area</option>
                  </select>
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-arrow-right"></i></button>
                    <button class="btn btn-danger" type="button" onclick="location.replace('{{ url()->current() }}')"><i class="fa fa-remove"></i></button>
                  </div>
                </div>
            </form>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Waybills</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first" style="font-family: 'Proxima Nova Regular' !important">
                                        <thead>
                                            <tr>
                                                <th>Date created</th>
                                                <th>Waybill Number</th>
                                                <th>Reference Number</th>
                                                <th>Recipient</th>
                                                <th>Shipping Fee</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = 0;
                                            @endphp
                                        	@foreach($waybills as $waybills)
                                        	    @php
                                                    if(!empty(\request()->get('text'))) {
                                                        $waybill = $waybills[0];
                                                    } else {
                                                        $waybill = $waybills;
                                                    }
                                        	    	// get recipient
                                        	    	$recipient = App\Recipients::find($waybill->recipient_id);
                                        	    @endphp
	                                            <tr>
	                                                <td>
                                                        {{ date('F dS Y, H:i:s A', strtotime($waybill->created_at)) }}
                                                    </td>
	                                                <td><a href="{{ url('waybills/view/'.$waybill->waybill_code) }}" style="color: blue;">{{ $waybill->waybill_code }}</a></td>
	                                                <td>{{ $waybill->reference_number }}</td>
	                                                <td>{{ @$recipient->firstname . " " . @$recipient->lastname}}</td>
	                                                <td>N{{ $waybill->shipping_fee }}</td>
	                                                <td>
                                                        @if($waybill->delivery_status == 'delivered')
                                                            <b style="color: green;">{{ ucwords($waybill->delivery_status) }}</b>
                                                        @elseif($waybill->delivery_status == 'returned to logistics')
                                                            <b style="color: red;">{{ ucwords($waybill->delivery_status) }}</b>
                                                        @else
                                                           <b>{{ ucwords($waybill->delivery_status) }}</b>
                                                        @endif
                                                    </td>
	                                            </tr>
                                            @endforeach
                                          
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date created</th>
                                                <th>Waybill Number</th>
                                                <th>Reference Number</th>
                                                <th>Recipient</th>
                                                <th>Shipping Fee</th>
                                                <th>Status</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>

@endsection
@section('scripts')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
 <script src="/vendor/datatables/js/data-table.js?v={{ time() }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>

@endsection