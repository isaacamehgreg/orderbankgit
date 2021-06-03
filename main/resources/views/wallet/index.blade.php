@extends('app')
@section('title', 'Manage Wallet')
@section('content')

 @include('messages')
<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Wallet Transaction History</h5>

                            <div class="card-body">
                                <div class="offset-xl-10 col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                <form>
                                    <div class="form-group">
                                        <a href="/wallet/fund" class="btn btn-primary" style="width: 165px;">Fund Wallet</a>
                                    </div>
                                </form>
                            </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th style="color: #5E2CED;">Date</th>
                                                <th style="color: #5E2CED;">Reference No.</th>
                                                <th style="color: #5E2CED;">Amount</th>
                                                <th style="color: #5E2CED;">Status</th>
                                                <th style="color: #5E2CED;">Gateway</th>
                                                <th style="color: #5E2CED;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@foreach($wallet_history as $wallet)

	                                            <tr>
                                                    <td>{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $wallet->created_at )) }}</td>
	                                                <td>{{ $wallet->reference }}</td>
                                                    <td>₦{{ $wallet->amount }}</td>
                                                    <td>{{ $wallet->status }}</td>
                                                    <td>{{$wallet->gateway}}</td>
                                                    <td>
                                                        @php
                                                        $successes = ['success', 'successful', 'paid']
                                                        @endphp
                                                        @if (!in_array(strtolower($wallet->status), $successes))
                                                            <a href="{{route('verify-transaction', $wallet->reference)}}"
                                                               class="btn btn-sm btn-outline-dark">
                                                                Recheck
                                                            </a>
                                                        @endif
                                                    </td>
	                                            </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>

@endsection
@section('scripts')

@endsection
