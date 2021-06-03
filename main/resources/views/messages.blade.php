<style>
    .alert .alert-danger {
        background: indianred;
        padding: 20px;
        color: #fff;
        margin-bottom: 30px;
    }
</style>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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


@if ($errors->any())
    <script>
        swal("Error", "You have errors.", "error");
    </script>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Please check the form below for errors
        <hr>
        <b>
            @foreach($errors->all() as $error)
                {{ $error }} <br>
            @endforeach
        </b>
    </div>
@endif