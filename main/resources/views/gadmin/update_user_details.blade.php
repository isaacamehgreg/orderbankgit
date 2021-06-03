@extends('gadmin')
@section('title', 'Update Business Details')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            @include('messages')
            <h5 class="card-header">Update Correct Profile Details</h5>
            <div class="card-body">
                <div class="">
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                         
                            <div class="col-sm-6">
                                <label>Customer First Name</label>
                                <input name="firstname" value="{{ $profile->firstname }}" class="form-control"/>
                            </div>

                            <div class="col-sm-6">
                                <label>Customer Last Name</label>
                                <input name="lastname" value="{{ $profile->lastname }}" class="form-control"/>
                            </div>

                            <div class="col-sm-6">
                                <label>Customer Address</label>
                                <input name="address" value="{{ $profile->address }}" class="form-control"/>
                            </div>

                            <div class="col-sm-6">
                                <br>
                                <label>Customer Phone Number</label>
                                <input name="phone_number" value="{{ $profile->phone_number }}" class="form-control"/>
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
 
 