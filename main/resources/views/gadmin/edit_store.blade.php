@extends('gadmin')
@section('title', 'Store Settings')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            @include('messages')
            <h5 class="card-header">Store Settings</h5>
            <div class="card-body">
                <div class="">
                    <form action="" method="post">
                        @csrf

                        <div class="row">

                            <div class="col-sm-6">
                                <label>Store Link (URL)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="btnGroupAddon">{{ url('') }}/store/i/</div>
                                    </div>
                                    <input type="text" name="store_url_slug" class="form-control" value="{{ $store->store_url_slug }}">
                                </div>
                                
                            </div>

                            <div class="col-sm-6">
                                <label>Store Title (Name)</label>
                                <input name="store_title" value="{{ $store->store_title }}" class="form-control" />
                            </div>

                            <div class="col-sm-4">
                                <br>
                                <label>Store Header Color</label>
                                <input type="color" style="height: 50px;" name="store_header_color" value="{{ $store->store_header_color }}" class="form-control"/>
                            </div>

                            <div class="col-sm-4">
                                <br>
                                <label>Store Font Color</label>
                                <input type="color" style="height: 50px;" name="store_font_color" value="{{ $store->store_font_color }}" class="form-control"/>
                            </div>

                            <div class="col-sm-4">
                                <br>
                                <label>Store Footer Color</label>
                                <input type="color" style="height: 50px;" name="store_footer_color" value="{{ $store->store_footer_color }}" class="form-control"/>
                            </div>

                            <div class="col-sm-12">
                        </br>
                                <button class="btn btn-block btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</div>
   




 @endsection

 @section('scripts')
 <script>
     function myFunction() {
    /* Get the text field */
    var copyText = document.getElementById("store_url_slug");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */
    alert("Copied the text: " + copyText.value);
    }
</script>
 @endsection
