@extends('app')
@section('title', 'Setup eCommerce Store')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            @include('messages')
            <h5 class="card-header">Setup eCommerce Store</h5>
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
                                    <input type="text" name="store_url_slug" class="form-control" value="{{ auth()->user()->businessNameSlug() }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Store Title (Name)</label>
                                <input name="store_title" value="{{ auth()->user()->business()->business_name }}" class="form-control"/>
                            </div>

                            <div class="col-sm-4">
                                <br>
                                <label>Store Header Color</label>
                                <input type="color" style="height: 50px;" name="store_header_color" value="#5E2CED" class="form-control"/>
                            </div>

                            <div class="col-sm-4">
                                <br>
                                <label>Store Font Color</label>
                                <input type="color" style="height: 50px;" name="store_font_color" value="#fff" class="form-control"/>
                            </div>

                            <div class="col-sm-4">
                                <br>
                                <label>Store Footer Color</label>
                                <input type="color" style="height: 50px;" name="store_footer_color" value="#5E2CED" class="form-control"/>
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

