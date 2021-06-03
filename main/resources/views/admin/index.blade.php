@extends('app')
@section('title', 'Analytics')
@section('content')
 <link rel="stylesheet" type="text/css" href="/vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/buttons.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/select.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/fixedHeader.bootstrap4.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">
    <div class="col-sm-8">
                            <!-- ============================================================== -->
                            <!-- four widgets   -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- total views   -->
                            <!-- ============================================================== -->

                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                            <a href="/orders">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Orders</h5>
                                            <h2 class="mb-0"> {{ $total_orders }}</h2>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                            <i class="fa fa-list fa-fw fa-sm text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>


                            {{-- <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                            <a href="/admin/customers">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Customers</h5>
                                            <h2 class="mb-0"> {{ $total_customers }}</h2>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                            <i class="fa fa-users fa-fw fa-sm text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div> --}}
                            <!-- ============================================================== -->
                            <!-- end total views   -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- total followers   -->
                            <!-- ============================================================== -->
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="/admin/products">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-inline-block">
                                                <h5 class="text-muted">Total Products</h5>
                                                <h2 class="mb-0"> {{ $total_products }}</h2>
                                            </div>
                                            <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                                <i class="fa fa-flag fa-fw fa-sm text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end total followers   -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- partnerships   -->
                            <!-- ============================================================== -->
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="/admin/forms">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Forms</h5>
                                            <h2 class="mb-0">{{ $total_forms }}</h2>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
                                            <i class="fa fa-map fa-fw fa-sm text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>

                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="/admin/customers">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Customers</h5>
                                            <h2 class="mb-0">{{ $total_customers }}</h2>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
                                            <i class="fa fa-map fa-fw fa-sm text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                            
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="/admin/deliverytime">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Delivery Time</h5>
                                            <h2 class="mb-0">{{ $total_delivery_time }}</h2>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
                                            <i class="fa fa-clock fa-fw fa-sm text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>

                           
                            </div>
                            
              


<div class="col-sm-4">

<div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">OrderBank</h5>
                                            <span>Product Of EdeNet Media and Marketing</span>
                                            
                                        </div>
                                        
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