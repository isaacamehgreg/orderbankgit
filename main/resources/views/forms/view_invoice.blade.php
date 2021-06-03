<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
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

    <title>Order</title>
    
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

    .card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 0px;
  }
body {

    background-color: #5E2CED;
}

#invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #5E2CED
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}

</style>

    <body>

    <br><br><Br>
        <div class="container-fluid">
            <div class="row">
<div class="col-xl-1 col-lg-12 col-md-12 col-sm-12 col-12 col-sm-offset-2">
</div>
        <div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12 col-sm-offset-2">
                        <div class="card" id="printableArea">
                            <div class="card-body">
                                
                                    <div id="invoice">

    <div class="toolbar hidden-print">
        <Center> <div class="thanks">ORDER RECEIPT</div> </Center>
        <div class="text-right">
            <button id="printInvoice" class="btn btn-info" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
<!--             <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
 -->        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto" >
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a href="#!">
                            <img src="{{ url($business->business_logo ?? '/asset/images/white.png') }}" style="width: 100px;" data-holder-rendered="true" />
                        </a>
                    </div>
                    <div class="col company-details">
                        <h2 class="name">
                            <a href="#!">
                            {{ $business->business_name ?? '' }}
                            </a>
                        </h2>
                        <div> 
                            {{ $business->business_address ?? '' }}
                        </div>
                        <div>{{ $business->business_phone_number ?? '' }}</div>
                        <div>{{ $business->business_email }}</div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">ORDER TO:</div>
                        <h2 class="to">{{ ucwords($customer->fullname) }}</h2>
                        <div class="address">{{ $customer->address }}, {{ $customer->state }}</div>
                        <div class="email"><a href="#!">{{ $customer->phonenumber }}, {{ $customer->phonenumber_two }}</a></div>
                    </div>
                    <div class="col invoice-details">
                        <h3 class="invoice-id">Order Number: #{{ $order->invoice }}</h3>
                        <div class="date">Date Order Was Placed: {{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $order->created_at )) }}</div>
                        <div class="date">Delivery Date: {{ $order->delivery_time }}</div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>PRODUCT QUANTITY</th>
                            <th class="text-left">PRODUCT NAME</th>
                            <th class="text-right">=</th>
                            <th class="text-right">PRODUCT PRICE</th>
                           -- <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td class="no">{{ $order->product_qty }}</td>
                            <td class="text-left"><h3>
                                <a href="#!">
                                {{ ucwords($product->title) }}
                                </a>
                                </h3>
                               
                            </td>
                            <td class="unit">=</td>
                            <td class="qty">₦{{ number_format($product->price) }}</td>
                            <td class="total">₦{{ number_format($order->product_total_price) }}</td>
                        </tr>
                        
                    </tbody>
                    <tfoot>
           
                        
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td>₦{{ number_format($order->product_total_price) }}</td>
                        </tr>
                    </tfoot>
                </table>
                <br><br>
                <div class="thanks">Thank You!</div>
                <!-- <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                </div> -->
            </main>
            <footer>
                This Order Receipt Was Created On A Computer And Is Valid Without The Signature And Seal.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>                              
                            </div>
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
   function printDiv(divName) {

     $('.hidden-print').hide();
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
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
