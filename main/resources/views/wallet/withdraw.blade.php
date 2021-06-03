@extends('app')
@section('title', 'Withdraw Funds')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="row">

    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Withdraw Wallet Funds <br> (Withdraw To Your Bank Account)<a href="/wallet"
                                                                                                 style="color: #fff;"
                                                                                                 class="btn btn-sm btn-success float-right"><b>Go
                        back</b></a></h5>

            <div class="card-body">
                <form action="/wallet/withdraw" method="post">

                    @csrf
                    @include('messages')

                    <div class="row">
                        <div class="col-sm-12 form-group mb-3">
                            <label>Amount</label>
                            <input name="amount" id="amount" class="form-control"/>
                            {{-- <small>You will be charged 0.5% as VAT for this transfer</small> --}}
                        </div>

                        <div class="col-sm-12 form-group">
                            <label>Bank</label>
                            <input disabled name="bank_name" value="{{$bank_name}}" class="form-control"/>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label>Account Number</label>
                            <input disabled name="account_number" value="{{$account_number}}" class="form-control"/>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label>Account Name</label>
                            <input disabled name="account_name" value="{{$account_name}}" class="form-control"/>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" class="btn btn-primary">Withdraw</button>
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
@endsection
