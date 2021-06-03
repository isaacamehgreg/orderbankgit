@extends('app')
@section('title', 'Admin - WhatsApp Numbers')
@section('content')

<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">WhatsApp Numbers <a href='whatsapp_numbers/add' class="btn btn-sm btn-success float-right"><b>Add +</b></a></h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Device ID</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        	@foreach($whatsapp_numbers as $whatsapp_number)
	                                            <tr>
	                                                <td>{{ $whatsapp_number->number }}</td>
                                                    <td>{{ $whatsapp_number->device_id }}</td>
                                                
	                                                <td>
                                                        <a href="whatsapp_numbers/edit/{{ $whatsapp_number->id }}" class="btn btn-block btn-primary">Edit</a>
                                                        <a href="whatsapp_numbers/delete/{{ $whatsapp_number->id }}" class="btn btn-block btn-danger delete" data-confirm="Are you sure to delete this device?">Delete</a>



                                                    </td>
	                                            </tr>
                                            @endforeach
                                          
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Number</th>
                                                <th>Device ID</th>
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