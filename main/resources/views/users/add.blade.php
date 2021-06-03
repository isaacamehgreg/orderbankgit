@extends('app')
@section('title', 'Users - Add New')
@section('content')
 <link rel="stylesheet" type="text/css" href="/vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/buttons.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/select.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/fixedHeader.bootstrap4.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Add users</h5>

                            <div class="card-body">
                                <form action="" method="post">
                                    @csrf
                                    @include('messages')

                                    <div class="row">

                                    <div class="col-sm-12 form-group">
                                        <label>Role</label>
                                        <select name="role" class="form-control">
                                            <option value="2">Customer Support</option>
                                            <option value="3">Administrative Officer</option>
                                            <option value="4">Accountant</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 form-group">
                                        <label>Firstname</label>
                                        <input name="firstname" class="form-control" />
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Lastname</label>
                                        <input name="lastname" class="form-control" />
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>E-mail address</label>
                                        <input name="email_address" class="form-control" />
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Phone Number (optional)</label>
                                        <input name="phone_number" class="form-control" />
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Password</label>
                                        <input name="password" type="password" class="form-control" />
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label>Address (optional)</label>
                                        <input name="address" class="form-control" />
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
