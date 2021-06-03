@extends('app')
@section('title', 'Create Delivery Time')
@section('content')
 <link rel="stylesheet" type="text/css" href="/vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/buttons.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/select.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/fixedHeader.bootstrap4.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Add When You Want To Deliver Your Order <a href="/admin/deliverytime" style="color: #fff;" class="btn btn-sm btn-success float-right"><b>Go back</b></a></h5>
                            <div class="card-body">
                                <form action="" method="post">
                                    @csrf
                                    @include('messages')

                                    <div class="row">

                                    <div class="col-sm-6 form-group">
                                        <label>Note: Start your input with "Deliver" 
                                        <br>
                                        e.g: 
                                        </label>
                                        <ul>
                                        <li> <p>Deliver Within 24hrs(Today or Tomorrow)</li>
                                        
                                          <li> <p>Deliver Within 48hrs(Within 2days)</li>
                                          
                                         <li>  <p>Deliver Within 72hrs (Within 3days)</li>
                                         </p>
                                         <ul>
                                              </div>
                                    </div>
                                   <div class="row">

                                    <div class="col-sm-6 form-group">
                                        <label>Enter Delivery Time:</label>
                                        <input name="time" class="form-control" />
                                        </div>
                                        </div>
                                   

               <div class="row">

                                    <br><br>

                                    &nbsp;&nbsp;&nbsp;&nbsp; <button class="btn btn-primary">Submit</button>
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