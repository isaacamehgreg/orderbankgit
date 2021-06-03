@extends('app')
@section('title', 'Create a Web Page')
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
            <h5 class="card-header">Create A Webpage<a href="#" style="color: #fff;" data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-success float-right"><b>Create a webpage</b></a></h5>
            <div class="card-body">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="card-header">Your Webpage statistics.</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <a href="#!">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-inline-block">
                                                        <h5 class="text-muted">Total Pages</h5>
                                                        <h3 class="mb-0">{{$editors->count()}}</h3>
                                                    </div>
                                                    <div
                                                        class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                        <i class="fa fa-list fa-fw fa-sm text-info"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <a href="#!">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-inline-block">
                                                        <h5 class="text-muted">Published Pages</h5>
                                                        <h3 class="mb-0">{{$editors->count()}}</h3>
                                                    </div>
                                                    <div
                                                        class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                        <i class="fa fa-list fa-fw fa-sm text-info"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <div class="published">
            <h3>Pubished Pages {{$editors->count()}}</h3>
            <div class="row">
                @foreach($editors as $editor)
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card w-75">
                          <div class="card-body">
                            <h5 class="card-title">Page Name: {{$editor->page_name}}</h5>
                            <p>{{$editor->url}}</p>
                            <a href="{{route('single.editor', ['id' => $editor->id])}}" class="btn btn-sm btn-primary"><b>Edit</b></a>
                            <a href="{{route('editor.delete', ['id' => $editor->id])}}" class="btn btn-sm btn-danger"><b>Unpublish page</b></a>
                          </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            <div class="unpublished">
            <h3>Unpublished Pages {{$trash->count()}}</h3>
            @if($trash->count() > 0)
            <div class="row">
            @foreach($trash as $trashed)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card w-75">
                      <div class="card-body">
                        <h5 class="card-title">Page Name: {{$trashed->page_name}}</h5>
                        <p>{{$trashed->url}}</p>
                        <a href="{{route('editor.kill', ['id' => $trashed->id])}}" class="btn btn-sm btn-danger"><b>Permanently Delete page</b></a>
                      </div>
                    </div>
                </div>
            @endforeach
            </div>
            @else
            <h3 class="text-center">There are no unpublished pages.</h3>
            @endif
            </div>
                <!-- Modal -->
                <form action="{{route('editor.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('messages')
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create a webpage</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputAddress">Page Name</label>
                                <input type="text" name="page_name" class="form-control" id="pagename" placeholder="About Page">
                            </div>
                            <div class="form-group">
                            <div class="col-auto">
                                <label for="pageurl">Page URL</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">https://{{trim(strtolower(str_replace(' ', '',$business->business_name)))}}.orderbank.com</div>
                                    </div>
                                    <input type="text" name="url" class="form-control" id="inlineFormInputGroup" placeholder="/about">
                                </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Import code (optional)</label>
                                <textarea class="form-control" name="content" aria-label="With textarea"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Page</button>
                        </div>
                        </div>
                    </div>
                    </div>
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
