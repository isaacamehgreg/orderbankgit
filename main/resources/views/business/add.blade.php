@extends('app')
@section('title', 'Edit Your Business Details')
@section('content')
<div class="row">
    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            @include('messages')
            <h5 class="card-header">Enter Your Correct Business Details</h5>
            <div class="card-body">
                <div class="">
                    <form action="/business/add" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label>First Name</label>
                                <input name="firstname" class="form-control"/>
                            </div>
                            <div class="col-sm-6">
                                <label>Last Name</label>
                                <input name="lastname" class="form-control"/>
                            </div>
                            <div class="col-sm-6">
                                <label>Business Name</label>
                                <input name="business_name" class="form-control"/>
                            </div>

                            <div class="col-sm-6">
                                <label>Business Email</label>
                                <input name="business_email" class="form-control"/>
                            </div>

                            <div class="col-sm-6">
                                <label>Business Address</label>
                                <input name="business_address" class="form-control"/>
                            </div>

                            <div class="col-sm-6">
                                <br>
                                <label>Business Phone Number</label>
                                <input name="business_phone_number" class="form-control"/>
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
    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <form action="/business/upload_dp" method="post" enctype="multipart/form-data">
                @csrf
            <h5 class="card-header">Business Logo</h5>
            <div class="card-body" style="padding: 15px;">
                  
                 <center><img src="https://png.pngtree.com/svg/20161027/service_default_avatar_182956.png" class="img-responsive img-circle" style="width: 100px;" alt="broken image link"></center>
                 <br>
                 <label class="btn btn-block btn-sm btn-secondary">
                    Choose File <input type="file" name="file" hidden>
                </label>
                 <button class="btn btn-block btn-success" type="submit">Submit File</button>
             </div>
         </form>
            </div>
        </div>
    </div>

</div>


 @endsection
 
 