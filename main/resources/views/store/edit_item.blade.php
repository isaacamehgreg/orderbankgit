@extends('app')
@section('title', 'Edit Item')
@section('content')
 <link rel="stylesheet" type="text/css" href="/vendor/datatables/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/buttons.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/select.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="/vendor/datatables/css/fixedHeader.bootstrap4.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<style>
    .select2-container .select2-selection, .select2-selection__rendered, .select2-selection__arrow {
    height: 59px !important;
}
</style>
<div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Edit Store Item <a href="/store/items" style="color: #fff;" class="btn btn-sm btn-success float-right"><b>Manage Store Items</b></a></h5>
                            <div class="card-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @include('messages')

                                    <div class="row">

                                    <div class="col-sm-12 form-group">
                                        <label>Featured Product Name:</label>
                                        <input name="item_name" value="{{ $item->item_name }}" required class="form-control" />
                                    </div>

                                     <div class="col-sm-12 form-group">
                                        <label>Featured Product Image (required):</label>
                                        <div class="card card-body p-3">
                                            @if(!empty($item->item_featured_image))
                                                <img src="{{ url('uploads/store/items/'.$item->item_featured_image) }}" width="150" class="img-responsive" />
                                            @endif
                                            <br>
                                            <input type="file" name="item_featured_image" class="form-control" />
                                        </div>

                                     </div>
                                   <div class="col-sm-12 form-group">
                                        <label>Featured Product Price:</label>
                                        <input name="item_amount" type="number" value="{{ $item->item_amount }}" required class="form-control" />
                                    </div>


                                    <div class="col-sm-12 form-group">
                                        <label>More Description About The Product:</label>
                                        <textarea name="item_description" id="summernote" class="form-control">{{ $item->item_description }}</textarea>
                                    </div>


                                    <div class="col-sm-12 form-group">
                                        <label>Select The Order Form For This Product Item:</label>
                                        <select class="form-control" name="form_id" style="padding: 10px !important;">
                                        @foreach($forms as $form)
                                            <option @if($item->form_id == $form->id) selected @endif value="{{ $form->id }}">{{ $form->title }}</option>
                                        @endforeach
                                    </select>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
    $('#summernote').summernote({
        height: 300,
    });
</script>
@endsection
