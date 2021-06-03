<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.min.css">
    <link href="/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link href="/vendor/fonts/proxima-nova/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/libs/css/style.css?t={{ time() }}">
    <link rel="stylesheet" href="/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="/vendor/vector-map/jqvmap.css">
    <link href="/vendor/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" type="text/css" href="/vendor/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <title>{{ $form->title }}</title>

    <!-- jquery 3.3.1  -->
    <script src="/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- chart C3 js -->
    <script src="/vendor/charts/c3charts/c3.min.js"></script>
    <script src="/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <!-- chartjs js -->
    <script src="/vendor/charts/charts-bundle/Chart.bundle.js"></script>
    <script src="/vendor/charts/charts-bundle/chartjs.js?v={{ time() }}"></script>
    <!-- sparkline js -->
    <script src="/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- dashboard finance js -->
    <style>
        body {

            background-color: #fff;
        }


        input[type=checkbox]
        {
            /* Double-sized Checkboxes */
            -ms-transform: scale(1); /* IE */
            -moz-transform: scale(1); /* FF */
            -webkit-transform: scale(1); /* Safari and Chrome */
            -o-transform: scale(1); /* Opera */
            padding: 5px;
        }

        input[type="radio"]{
            -webkit-appearance: radio;
        }
    </style>


<body>


<div class="container-fluid">

    <div class="row">

        <div class="col-xl-2"></div>

        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 col-sm-offset-2">

            <div class="card" style="box-shadow: none;">
                <div class="card-body" style="box-shadow: none;">
                    <form action="" method="post">
                        @csrf
                        @include('messages')

                        <span><h1><center><b style="color: #8b0000;">Please Fill This Form Carefully</center></h1></span>
                        <p><center><b style="color: #5E2CED;">Any Single Mistake Won't Allow us To Process Your Info</center></p>
                        <label><b style="color: #8b0000;">Enter Your Correct Contact Details Below:</label>
                        <div class="row">
                            @php
                                $form_check = json_decode($form->form_fields) ?? [];
                            @endphp

                            @if(in_array('full_name', $form_check))
                                <div class="col-sm-12 form-group">
                                    <label>Your Full Name:</label>
                                    <input name="fullname" id="fullname" class="form-control" />
                                </div>
                            @endif

                            @if(in_array('phone_number', $form_check))
                                <div class="col-sm-12 form-group">
                                    <label>Your Active Phone Number:</label>
                                    <input name="phonenumber" id="phonenumber" class="form-control" />
                                </div>
                            @endif

                            @if(in_array('email', $form_check))
                                <div class="col-sm-12 form-group">
                                    <label>Your Active Email Address :</label>
                                    <input name="email" id="email" class="form-control" />
                                </div>
                            @endif

                            <br>

                            &nbsp;&nbsp;&nbsp;&nbsp; <button class="btn btn-secondary" id="submitBtn">SUBMIT NOW</button>

                            <button class="btn btn-secondary" id="submitBtn2" type="button">Loading..</button>
                    </form>


                </div>
                <br><br>

                <h4><center>If you can't order through the form, kindly call or send text message (SMS) Or whatapp message to: {{ App\Business::where('user_id', $form->business_id)->first()->business_phone_number ?? '' }}
                        <br>
                        But if you can, go ahead and fill the form to place your order now</center></h4>
                {{-- <center><p>Powered by <a href="https://orderbank.com.ng">OrderBank</a></p></center> --}}
            </div>
        </div>
    </div>


</div>

</body>


<!-- main js -->
<script src="/libs/js/main-js.js"></script>
<script src="/libs/js/axios.min.js"></script>
<script src="/libs/js/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        $('.loading').hide();

        $('#submitBtn2').hide();
    });


    function totalprice(id, amount) {
        let qty = $('#qty_' + id).val();
        let total = amount * qty;

        $('#total_' + id).attr('value', 'N' + total.format());
    }

    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };

    $('input[type="checkbox"]').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);
    });

    $('#submitBtn').click(function(e) {
        e.preventDefault();

        $('#submitBtn').hide();
        $('#submitBtn2').show();

        let id = '{{ $form->business_id }}';
        let link     = '{{ $form->link }}';
        let fullname = $('#fullname').val();
        let address  = $('#address').val();
        let state    = $('#state').val();
        let phonenumber = $('#phonenumber').val();
        let phonenumbertwo = $('#phonenumbertwo').val();
        let email = $('#email').val();
        let product  = $('.product:checked').val();
        let delivery_time = $('.delivery_time:checked').val();

        let data = {
            id: id,
            link: link,
            fullname: fullname,
            address: address,
            state: state,
            email: email,
            delivery_time: delivery_time,
            phonenumber: phonenumber,
            phonenumbertwo: phonenumbertwo,
            product: product,
            product_qty: $('#qty_' + product).val(),
            product_total_price: $('#total_' + product).val()
        }

        axios.post('{{ url("/api/contact-form/submit/") }}', {
            data
        })
            .then(function (response) {
                let data = response.data;

                if(data.code == 400) {

                    Swal.fire({
                        title: '<strong>The Following Field Is Required.Try Again.</strong>',
                        type: 'error',
                        html:
                        data.message,
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                    });

                    $('#submitBtn').show();
                    $('#submitBtn2').hide();

                    $('.loading').hide();

                } else if(data.code == 200) {
                    window.top.location.href = data.link;
                    Swal.fire({
                        title: '<strong>Your info has been submitted successfully!</strong>',
                        type: 'success',
                        html:
                        data.message,
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,

                    });

                    $('.loading').hide();

                    $('#submitBtn').text('Submit');

                    setTimeout(function() {
                        // location.href = data.link;
                        // window.top.location.href = data.link;
                    }, 100);

                }

                console.log(response.data);

            });
    });
</script>
<!-- morris js -->
<script src="/vendor/charts/morris-bundle/raphael.min.js"></script>
<script src="/vendor/charts/morris-bundle/morris.js"></script>
<!-- daterangepicker js -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

</body>
</html>
