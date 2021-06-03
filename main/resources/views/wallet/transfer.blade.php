@extends('app')
@section('title', 'Fund Your Wallet')
@section('content')
 <link rel="stylesheet" type="text/css" href="/vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/buttons.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/select.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/fixedHeader.bootstrap4.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Transfer Wallet Funds <br> (Send to another OrderBank Customer Easily!)<a href="/wallet" style="color: #fff;" class="btn btn-sm btn-success float-right"><b>Go back</b></a></h5>

                            <div class="card-body">
                                <form action="" method="post">

                                    @csrf
                                    @include('messages')

                                    <div class="row">
                                    <div class="col-sm-12 form-group">
                                     <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary" onclick="fund(10000)">N10,000</button>
                                        <button type="button" class="btn btn-secondary" onclick="fund(30000)">N30,000</button>
                                        <button type="button" class="btn btn-info" id="custom">Custom</button>
                                      </div>
</div>
                                    <div class="col-sm-12 form-group">
                                        <label>Amount</label>
                                        <input name="amount" id="amount" class="form-control" />
                                         {{-- <small>You will be charged 0.5% as VAT for this transfer</small> --}}
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label>Account ID / E-mail Address / Phone Number</label>
                                        <input name="account" id="" class="form-control" />
                                         <small>Provide the correct account identifier for your recipient.</small>
                                    </div>
                                  
                                    &nbsp;&nbsp;&nbsp;&nbsp; <button type="submit" class="btn btn-primary">Transfer</button>
                                </form>
                            </div>
                        </div>
                    </div>

                   
</div>
@endsection
@section('scripts')
<script>

    function fund(amount) {
        $('#amount').val(amount);
    }

    $('#custom').on('click', function() {
        $('#amount').focus();
    });

    function percentCalculation(a, b){
    var c = (parseFloat(a)*parseFloat(b))/100;
    return parseFloat(c);
    }

    
            
</script>
</script>

<script src="/libs/js/axios.min.js"></script>
<script src="/libs/js/sweetalert2.all.min.js"></script>


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
