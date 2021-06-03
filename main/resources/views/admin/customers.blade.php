@extends('app')
@section('title', 'All Customers')
@section('content')
 
<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Here Are The List Of All Your Customers</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Customer Name</th>
                                                <th>Address</th>
                                                <th>State</th>
                                                <th>Phone Number</th>
                                                <th>Alternate No.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        	@foreach($customers as $customers)
	                                            <tr>
	                                                <td>{{ $customers->created_at }}</td>
	                                                <td>{{ $customers->fullname }}</td>
                                                    <td>{{ $customers->address }}</td>
                                                    <td>{{ $customers->state }}</td>
                                                    <td> {{ $customers->phonenumber }}</td>
                                                    <td>{{ $customers->phonenumber_two }}</td>
	                                                
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