@extends('app')
@section('title', 'Edit Form')
@section('content')
 <link rel="stylesheet" type="text/css" href="/vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/buttons.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/select.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/fixedHeader.bootstrap4.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .select2-container .select2-selection, .select2-selection__rendered, .select2-selection__arrow {
    height: 59px !important;
}
</style>
<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Edit Your Form <a href="/forms" style="color: #fff;" class="btn btn-sm btn-success float-right"><b>Manage forms</b></a></h5>
                            <div class="card-body">
                                <form action="" method="post">
                                    @csrf
                                    @include('messages')

                                    <div class="row">

                                    <div class="col-sm-12 form-group">
                                        <label>Form Name:</label>
                                        <input name="title" value="{{ $form->title }}" class="form-control" />
                                    </div>

                                  {{--  <div class="col-sm-12 form-group">
                                        <label>Form Description:</label>
                                        <textarea name="meta" class="form-control">{{ $form->desc }}</textarea>
                                    </div> --}}
                                    
                                    <div class="col-sm-12 form-group">
                                        <label>Select The Products You Want To Sell:</label>
                                    <select class="js-example-basic-multiple form-control" name="products[]" multiple="multiple" style="padding: 10px !important;">
                                      @foreach(json_decode($form->products, true) as $default)
                                        <option selected value="{{ $default }}">{{ App\Products::find($default)->title }}</option>
                                      @endforeach

                                      @foreach(App\Products::where('business_id', auth()->id())->get() as $product)
                                        <option value="{{ $product->id }}">{{ $product->qty }} {{ $product->title }} ₦{{ $product->price }}</option>
                                      @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-sm-12 form-group">
                                        <label>Select The Delivery Time:</label>
                                    <select class="js-example-basic-multiple form-control" name="delivery_times[]" multiple="multiple" style="padding: 10px !important;">							
                                      
                                      @foreach(App\DeliveryTimes::where('business_id', auth()->id())->get() as $dtime)
                                      @php
	                                    $delivery_time = json_decode($form->delivery_times, true);
	                                    @endphp
	                                    
	                                    @if(in_array($dtime->id, $delivery_time))
                                        	<option selected value="{{ $dtime->id }}">{{ App\DeliveryTimes::find($dtime->id)->value }}</option>
										@else
                                        <option value="{{ $dtime->id }}">{{ $dtime->value }}</option>
                                        @endif
                                      @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label>Select The Form Fields:</label>
                                <select class="js-example-basic-multiple form-control" name="form_fields[]" multiple="multiple" style="padding: 10px !important;">		
                                    
                                    @php
                                    $field = json_decode($form->form_fields) ?? [];
                                    @endphp
                                    
                                    <option @if(in_array('full_name', $field)) selected @endif value="full_name">Full Name</option>
                                    
                                                                      
                                    <option @if(in_array('phone_number_one', $field)) selected @endif value="phone_number_one">Active Phone Number</option>
                                
                                                                  
                                    <option @if(in_array('phone_number_two', $field)) selected @endif value="phone_number_two">Alternative Phone Number</option>
                                
                                                                  
                                    <option @if(in_array('address', $field)) selected @endif value="address">Full Address</option>
                                
                                                                  
                                    <option @if(in_array('state', $field)) selected @endif value="state">State</option>
                                
                                                                  
                                    <option @if(in_array('email', $field)) selected @endif value="email" >Active Email Address</option>
                                  
                                </select>
                            </div>

                        <div class="col-sm-12 form-group">
                                    <label>Form Link (ignore)</label>
                                    <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text" id="btnGroupAddon">{{ url('') }}/form/</div>
                                            </div>
                                            <input type="text" name="link" class="form-control" value="{{ $form->link }}">
                                        </div>
                                </div>
                                
                            

                                <div class="col-sm-12 form-group">
                                        <label>Redirect Link (optional)</label>
                                        <input name="redirect" value="{{ $form->redirect }}" placeholder="eg: Link To Your Thank You Page" class="form-control" />
                                    </div>
                                
                                 

                                    <br>

                                    &nbsp;&nbsp;&nbsp;&nbsp; <button class="btn btn-secondary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
    </div>

@endsection
@section('scripts')


<script src="/libs/js/axios.min.js"></script>
<script src="/libs/js/sweetalert2.all.min.js"></script>

<script>
    // Get area
    let addrecipient_state = $('#addrecipient_state');
    addrecipient_state.on('change', function() {
        let id = addrecipient_state.val();

        axios.get('/api/areas?state_id=' + id)
             .then(function(response) {

                // console.log(response.data);
                $('#addrecipient_area').html(response.data);

             }).catch(function(err) {
                console.log(err);
             });
    });

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
 <script src="/vendor/datatables/js/data-table.js"></script>
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
