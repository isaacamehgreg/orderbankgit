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

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">

 <link rel="stylesheet" type="text/css" href="/vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/buttons.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/select.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/fixedHeader.bootstrap4.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

    <title>OrderBank | Global Admin Panel | @yield('title')</title>
    <style>
        .dashboard-header .navbar {
            padding: 0px;
            border-bottom: 1px solid #5E2CED;
            -webkit-box-shadow: 0px 0px 28px 0px rgba(82, 63, 105, 0.13);
            box-shadow: 0px 0px 28px 0px rgba(82, 63, 105, 0.13);
            -webkit-transition: all 0.3s ease;
            min-height: 60px;
        }

        .fixed-top {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
        }

        .bg-white {
            background-color: #6149ed !important;
        }

        .sidebar-dark {
            background-color: #5E2CED;
        }

        .dashboard-main-wrapper {
            min-height: 100%;
            padding-top: 20px;
            position: relative;
        }


        @media only screen and (max-width: 480px) {
            .nav-left-sidebar .navbar {
                padding: 14px;
                margin-top: 40px;
            }

            .dashboard-main-wrapper {
                min-height: 100%;
                padding-top: 20px;
                position: relative;
            }

            .ss {
                margin-top: 0px !important:;
            }

        }

        .ss {
            margin-top: 40px;
        }

        .sidebar-dark.nav-left-sidebar .navbar-nav .nav-link {
            color: #fff !important;
        }


        .sidebar-dark.nav-left-sidebar .nav-link i {
            color: #ffffff !important;
        }


        .select2-container .select2-selection,
        .select2-selection__rendered,
        .select2-selection__arrow {
            height: 39px !important;
            line-height: 39px !important;
            border-radius: none !important;
        }

        .label-as-badge {
    border-radius: 1em;
}
    </style>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
@if ($message = Session::get('success'))
    <script>
        swal("Success", "{{ $message }}", "success");
    </script>
@endif


@if ($message = Session::get('error'))
    <script>
        swal("Error", "{{ $message }}", "error");
    </script>
@endif


@if ($message = Session::get('warning'))
    <script>
        swal("Warning", "{{ $message }}", "warning");
    </script>
@endif


@if ($message = Session::get('info'))
    <script>
        swal("Info", "{{ $message }}", "info");
    </script>
@endif
<body>
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->
<div class="dashboard-main-wrapper">
    <!-- ============================================================== -->
    <!-- navbar -->
    <!-- ============================================================== -->
    <div class="dashboard-header">
        <nav class="navbar navbar-expand-lg bg-white fixed-top">
            <a class="navbar-brand" href="/reports"><img src="/ORDERBANK IDENT logo white.png?vc=2" style="width: 200px;"/></a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-right-top">
                    <li class="nav-item dropdown nav-user">
                        @php $profile = \auth()->user(); @endphp
                        @if($profile->profile_picture_uri == '')
                        @php $dp = 'https://png.pngtree.com/svg/20161027/service_default_avatar_182956.png'; @endphp
                    @else
                        @php $dp = $profile->profile_picture_uri; @endphp
                    @endif
                        <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ $dp }}" alt="" class="user-avatar-md rounded-circle"></a>
                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                            <div class="nav-user-info">
                                <h5 class="mb-0 text-white nav-user-name">{{ \auth()->user()->firstname }} {{ \auth()->user()->lastname }} </h5>

                                <h5 class="mb-0 text-white nav-user-name"><b>Account Status:{{ @App\Subscriptions::find(App\BusinessSubscription::where('user_id', auth()->id())->first()->subscription_id)->title ?? '-' }}</b></h5>
                                <h5 class="mb-0 text-white nav-user-name"><b>Wallet Balance:₦{{ number_format(auth()->user()->wallet()) }}</b></h5>
                            </div>
                            <a class="dropdown-item" href="/logout"><i class="fas fa-power-off mr-2"></i>Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>


    <!-- ============================================================== -->
    <!-- end navbar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- left sidebar -->
    <!-- ============================================================== -->
    @include('gadmin_menu')
    <!-- ============================================================== -->
    <!-- end left sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- wrapper  -->
    <!-- ============================================================== -->
    <div class="dashboard-wrapper">
        <!-- ============================================================== -->
        <!-- pageheader  -->
        <!-- ============================================================== -->
        <div class="row ss" style="margin-left: -1px;  background: #6049ed;">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <br>
                    <h3 class="mb-2" style="color: #fff; margin-top: 7px;">@yield('title') </h3>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader  -->
        <!-- ============================================================== -->
        <div class="dashboard-finance">
            <div class="container-fluid dashboard-content">
                <!-- ============================================================== -->
                <!-- end inventory turnover -->
                <!-- ============================================================== -->
                @yield('content')
            </div>
            <p style="text-align: center">
                <a href="https://chat.whatsapp.com/CTyfSVydMvGCaLRyUXOqeP"><b style="color: #5E2CED;">
                        For Help: Join Our WhatsApp Group</b></a>
            </p>
            <br>
            <h4 style="text-align: center">Copyright ©️ 2020. All rights Reserved.<br> Built with ❤️ </h4>
        </div>

    </div>
    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->
</div>
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



<!-- main js -->
<script src="/libs/js/main-js.js"></script>
<!-- morris js -->
<script src="/vendor/charts/morris-bundle/raphael.min.js"></script>
<script src="/vendor/charts/morris-bundle/morris.js"></script>
<!-- daterangepicker js -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

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

<script>

// setInterval(function(){

//     $.ajax({
//         type: "GET",
//         url: "/cronjobsone",
//         dataType : "text",
//         contentType: "application/json",
//         data: {action: "update"},

//     }).done(function(data) {

//         console.log("INFORMATION UPDATED")
//     });

//     $.ajax({
//         type: "GET",
//         url: "/cronjobstwo",
//         dataType : "text",
//         contentType: "application/json",
//         data: {action: "update"},

//     }).done(function(data) {

//         console.log("INFORMATION UPDATED")
//     });

// },100000);




    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });



    $(document).ready(function() {
        $('.select2').select2();
    });

    var deleteLinks = document.querySelectorAll('.delete');

for (var i = 0; i < deleteLinks.length; i++) {
  deleteLinks[i].addEventListener('click', function(event) {
      event.preventDefault();

      var choice = confirm(this.getAttribute('data-confirm'));

      if (choice) {
        window.location.href = this.getAttribute('href');
      }
  });
}

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

</script>
@yield('scripts')
</body>
</html>
