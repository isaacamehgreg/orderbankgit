@extends('app')
@section('title', 'Store Settings')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            @include('messages')
            <h5 class="card-header">Store Settings</h5>
            <div class="card-body">
                <div class="">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-sm-12">
                                <label>Store Link (URL)</label>
                                <div class="input-group">


                                    <input type="text" name="store_url_slug" readonly id="store_url_slug" class="form-control" value="{{ url('') }}/store/i/{{ $store->store_url_slug }}">
                                    <div class="input-group-append">

                                        <button type="button" class="btn btn-primary" onclick="myFunction()">Copy Store Link</button>

                                        </div>
                                </div>
                            </div>

                            <br>

                            <div class="col-sm-12">
                                <br>
                                <label>Store Title (Name)</label>
                                <input name="store_title" value="{{ $store->store_title }}" class="form-control" />
                            </div>

                            <div class="col-sm-12">
                                @if(isset($store->store_logo))
                                    <img src="/uploads/store/logo/{{ $store->store_logo }} " alt="logo" style="height: 50px; background: black;" />
                                @endif
                                <br>
                                <label>Store Logo</label>

                                <input type="file" name="store_logo" class="form-control" />
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <label>Store Header Color</label>
                                <input type="color" style="height: 50px;" name="store_header_color" value="{{ $store->store_header_color }}" class="form-control"/>
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <label>Store Font Color</label>
                                <input type="color" style="height: 50px;" name="store_font_color" value="{{ $store->store_font_color }}" class="form-control"/>
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <label>Store Footer Color</label>
                                <input type="color" style="height: 50px;" name="store_footer_color" value="{{ $store->store_footer_color }}" class="form-control"/>
                            </div>

                            <div class="col-sm-12">
                                @if(isset($store->store_banner_image))
                                    <img src="/uploads/store/logo/{{ $store->store_banner_image }} " alt="logo" style="height: 50px; background: black;" />
                                @endif
                                <br>
                                <label>Store Banner Image</label>

                                <input type="file" name="store_banner_image" class="form-control" />
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <label>Store Description</label>
                                <input name="store_banner_text" value="{{ $store->store_banner_text }}" class="form-control" />
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
