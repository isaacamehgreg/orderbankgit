@extends('app')
@section('title', 'Message Notification History')
@section('content')

 @include('messages')
<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header"><div class="alert alert-danger">Please note that delivery history are deleted from our system after 60 days.</div></h5>
                            
                            <div class="card-body">
                               
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                               {{-- <th><b style="color: #5E2CED;">DATE</th> --}}
                                                <th><b style="color: #5E2CED;">MESSAGE CONTENT</th>
                                                {{--<th><b style="color: #5E2CED;">CHANNEL</th>
                                                <th><b style="color: #5E2CED;">STATUS</th> --}}
                                      
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@foreach($messages as $use)
                                        	
	                                            <tr>
                                                   {{-- <td>{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $use->created_at )) }}</td> --}}
	                                                <td><centre><b style="color: #5E2CED;">Sent on: {{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $use->created_at )) }}</b></centre> 
                                                   <br> <br>
                                                   {{ $use->message }}</td>
                                                  {{--  <td>SMS | EMAIL</td>
                                                    <td>DELIVERED</td> --}}
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
