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
                            <h5 class="card-header">Add Money To Your Wallet <br> (For SMS and Account Upgrade/Subscription)<a href="/wallet" style="color: #fff;" class="btn btn-sm btn-success float-right"><b>Go back</b></a></h5>
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
                                         <small>You will be charged 7.5% as VAT for this funding</small>
                                    </div>
                                  
                                    &nbsp;&nbsp;&nbsp;&nbsp; <button type="button" class="btn btn-primary" onclick="pay()">Pay</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
<div class="modal fade" id="confirmPaymentModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="confirmPaymentModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="justify-content: center;">
          <h5 class="modal-title text-center" id="exampleModalLabel"><center>Confirming Payment</center></h5>
          
        </div>
        <div class="modal-body">
          <center><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></center>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="paymentPaidModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="paymentPaidModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="justify-content: center;">
            <button type="button" class="close" data-dismiss="modal" onclick="location.reload()">&times;</button>
          <h5 class="modal-title text-center" id="exampleModalLabel"><center>Payment Confirmed</center></h5>
          
        </div>
        <div class="modal-body">
          <center><h5>Your Wallet has been credited. Thank You!</center>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="paymentFailedModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="paymentFailedModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="justify-content: center;">
            <button type="button" class="close" data-dismiss="modal" onclick="location.reload()">&times;</button>
          <h5 class="modal-title text-center" id="exampleModalLabel"><center>Payment Failed</center></h5>
          
        </div>
        <div class="modal-body">
          <center><h5>Your payment was not successful, kindly retry or contact us with the reference number: <span id="referenceS"></span></center>
        </div>
      </div>
    </div>
  </div>
    </div>

@endsection
@section('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>

    function fund(amount) {
        $('#amount').val(amount);
    }

    function focus() {
        $('#amount').focus();
    }

    $('#custom').on('click', function() {
      $('#amount').focus();
    });

    function percentCalculation(a, b){
    var c = (parseFloat(a)*parseFloat(b))/100;
    return parseFloat(c);
    }

    function pay() {
            var reference = '';
            let amount = (parseFloat($('#amount').val()));

            if (isNaN(amount)) {
               alert('Amount should not be empty.');
               return false;
            }

            if (amount <= 499) {
               alert('Amount should be greater than or equal to 500 Naira');
               return false;
            }
            // Generate History and return reference.
            $.ajax({
                url: "/wallet/fundPost",
                method: "POST",
                data: {
                    user: '{{ auth()->id() }}',
                    amount: amount,
                    type: 'credit',
                    reference: reference
                },
                success: function(data) {   

                    var handler = PaystackPop.setup({

                    key: "pk_live_dd6353d10918b9001033b999af3af190eac897ba",
                    email: "{{ auth()->user()->email_address }}",
                    amount: (parseFloat(amount + percentCalculation(amount, 7.5)) * 100),
                    currency: "NGN",
                    ref: data,
                    callback: function(response) {
                        
                        location.href = "/wallet/verify-payment/" + response.reference;
                        
                        // // call up a modal to confirm payment
                        // $('#confirmPaymentModal').modal('show');
        
                        // // now verify the payment
                        // $.ajax({
                        //     url: "/wallet/verify-payment/" + response.reference,
                        //     method: "POST",
                        //     data: {
                                
                        //     },
                        //     success: function(data) {
                        //         console.log(data)
                        //       if (data.status == 'success') {
                        //             $('#confirmPaymentModal').modal('hide');
                        //             alert('Wallet funded');
                        //             location.href = '/wallet';
                        //       } else {
                        //         $('#referenceS').html(reference);
                        //         $('#confirmPaymentModal').modal('hide');
                        //         $('#paymentFailedModal').modal('show');
                        //       }
                        //     },
                        //     error: function(err) {
                        //         console.log(err)
                        //     }

                        // });

                        // alert('success. transaction ref is ' + response.reference);
                    },
                    onClose: function(response) {
                        
                        location.href = "/wallet/verify-payment/" + response.reference;
                    }
                    });

                    handler.openIframe();
             
                },
                error: function(err) {
                    console.log(err)
                }

            });
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
