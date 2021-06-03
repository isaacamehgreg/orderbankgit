@extends('app')
@section('title', 'Create Form')
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
                <h5 class="card-header">Create A Form To Connect with your Customers<a href="/contacts" style="color: #fff;" class="btn btn-sm btn-success float-right"><b>Manage contact forms</b></a></h5>
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        @include('messages')

                        <div class="row">

                            <div class="col-sm-12 form-group">
                                <label>Enter Form Name:</label>
                                <input name="title" class="form-control" />
                            </div>

                            <div class="col-sm-12 form-group">
                                <label>Select The Form Fields:</label>
                                <select class="js-example-basic-multiple form-control" name="form_fields[]" multiple="multiple" style="padding: 10px !important;">

                                    <option selected="" value="full_name">Full Name</option>

                                    <option selected="" value="phone_number">Active Phone Number</option>

                                    <option selected="" value="email" >Active Email Address</option>
                                </select>
                            </div>

                            <div class="col-sm-12 form-group">
                                <label>Form Link (ignore)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="btnGroupAddon">{{ url('') }}/contact-form/</div>
                                    </div>
                                    <input type="text" name="link" class="form-control" value="{{ str_random(7) }}">
                                </div>
                            </div>

                            <div class="col-sm-12 form-group">
                                <label>Redirect Link (optional)</label>
                                <input name="redirect" placeholder="eg: Link To Your Thank You Page" class="form-control" />
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
