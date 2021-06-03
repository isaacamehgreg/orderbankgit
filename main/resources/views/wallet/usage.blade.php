@extends('app')
@section('title', 'Manage Wallet')
@section('content')

 @include('messages')
<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Wallet Usage History</h5>
                            
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
                                                <th><b style="color: #5E2CED;">DATE</th>
                                                <th><b style="color: #5E2CED;">DESCRIPTION.</th>
                                                <th><b style="color: #5E2CED;">REMARK</b></th>
                                                <th><b style="color: #5E2CED;">AMOUNT</th>
                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@foreach($usage as $use)
                                        	
	                                            <tr>
                                                    <td>{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $use->created_at )) }}</td>
                                                    <td>{{ $use->paying_for }}</td>
                                                    <td>{{ $use->remark ?? 'No Remark' }} </td>
                                                    <td>₦{{ $use->amount }}</td>
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