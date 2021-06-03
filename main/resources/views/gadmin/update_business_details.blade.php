@extends('gadmin')
@section('title', 'Update Business Details')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            @include('messages')
            <h5 class="card-header">Update Correct Business Details</h5>
            <div class="card-body">
                <div class="">
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                         
                            <div class="col-sm-6">
                                <label>Business Name</label>
                                <input name="business_name" value="{{ $business->business_name }}" class="form-control"/>
                            </div>

                            <div class="col-sm-6">
                                <label>Business Email</label>
                                <input name="business_email" value="{{ $business->business_email }}" class="form-control"/>
                            </div>
                            <br>
                            <div class="col-sm-6">
                                <label>Business Address</label>
                                <input name="business_address" value="{{ $business->business_address }}" class="form-control"/>
                            </div>

                            <div class="col-sm-6">
                                <br>
                                <label>Business Phone Number</label>
                                <input name="business_phone_number" value="{{ $business->business_phone_number }}" class="form-control"/>
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <button class="btn btn-block btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</div>

    </div>

</div>


 @endsection
 
 