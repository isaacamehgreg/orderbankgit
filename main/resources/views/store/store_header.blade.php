<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
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

    <title>{{ $store->store_title }}</title>
    
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

.cmobile {
    text-align: left;
    margin-left: 30px;
}

@media (min-width: 1281px) {
  
  //CSS
  .cmobile {
      text-align: justify !important;
      margin-left: 0px;
  }
  .mobileimg {
      height: 200px !important;
  }
}

@media (min-width: 320px) and (max-width: 480px) {
    .cmobile {
      text-align: center !important;
      margin-left: 0px;
  }

  .margleft {
      margin-left: 0px;
  }

  .margin-left {
    margin-left: 0px !important;
    margin-bottom: 20px;
  }

  

  
}

@media (min-width: 576px) {
body.container {
    max-width: 1000px;
    padding-left: 0px;
    padding-right: 0px;
}


}

.margleft {
    margin-left: 30px;
}

.margin-left {
    margin-left: 30px;
}

/* Bootstrap 4 text input with search icon */

.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}

/*Profile Card 5*/
.profile-card-5{
    margin-top:20px;
}
.profile-card-5 .btn{
    border-radius:2px;
    text-transform:uppercase;
    font-size:12px;
    padding:7px 20px;
}
.profile-card-5 .card-img-block {
    width: 91%;
    margin: 0 auto;
    position: relative;
    top: -20px;
    
}
.profile-card-5 .card-img-block img{
    border-radius:5px;
    box-shadow:0 0 10px rgba(0,0,0,0.63);
}
.profile-card-5 h5{
    color:#4E5E30;
    font-weight:600;
}
.profile-card-5 p{
    font-size:14px;
    font-weight:300;
}
.profile-card-5 .btn-primary{
    background-color:#4E5E30;
    border-color:#4E5E30;
}

.mobileimg {
    height: 100%;
}

a {
    color: {{ $store->store_font_color }}
}

</style>
