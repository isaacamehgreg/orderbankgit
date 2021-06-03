@extends('app')
@section('title', 'Waybill - General - Couriers')
@section('content')

<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Couriers <a href='couriers/add' class="btn btn-sm btn-success float-right"><b>Add +</b></a></h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Date created</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Phone number</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        	@foreach($couriers as $courier)
	                                            <tr>
	                                                <td>{{ $courier->created_at }}</td>
	                                                <td>{{ $courier->name }}</td>
                                                    <td>{{ $courier->address }}</td>
                                                    <td>{{ $courier->phonenumber }}
	                                                <td>
                                                        <a href="couriers/edit/{{ $courier->id }}" class="btn btn-block btn-primary">Edit</a>
                                                        <a href="couriers/delete/{{ $courier->id }}" class="btn btn-block btn-danger">Delete</a>
                                                    </td>
	                                            </tr>
                                            @endforeach
                                          
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date created</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Phone number</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>

@endsection
@section('scripts')

@endsection