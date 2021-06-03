@extends('gadmin')
@section('title', 'Message History')
@section('content')

 @include('messages')
<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Message History Logs <a href="/gadmin/reports/message_logs/clear" style="color: #fff;" class="btn btn-sm btn-success float-right"><b>Clear Logs</b></a></h5>
                            
                            <div class="card-body">
                               
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th><b style="color: #5E2CED;">DATE</th>
                                                <th><b style="color: #5E2CED;">MESSAGE.</th>
                                                <th><b style="color: #5E2CED;">CHANNEL</th>
                                      
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@foreach($messages as $use)
                                        	
	                                            <tr>
                                                    <td>{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $use->created_at )) }}</td>
	                                                <td>{{ $use->message }}</td>
                                                    <td>SMS | EMAIL</td>
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
