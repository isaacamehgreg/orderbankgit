@extends('app')
@section('title', 'Waybill - General - Recipients')
@section('content')

<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @include('messages')
                        <div class="card">
                            <h5 class="card-header">Recipients <a href='recipients/add' class="btn btn-sm btn-success float-right"><b>Add +</b></a></h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Date created</th>
                                                <th>First name</th>
                                                <th>Last name</th>
                                                <th>Phone number</th>
                                                <th>Phone number two</th>
                                                <th>State</th>
                                                <th>Area</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@foreach($recipients as $recipient)
                                        	    @php
                                                    $state = App\States::find($recipient->state_id);
                                                    $area = App\Areas::find($recipient->area_id);
                                        	    @endphp
	                                            <tr>
	                                                <td>{{ $recipient->created_at }}</td>
	                                                <td>{{ $recipient->firstname }}</td>
                                                    <td>{{ $recipient->lastname }}</td>
                                                    <td>{{ $recipient->phonenumber }}</td>
	                                                <td>{{ $recipient->phonenumber_two }}</td>
	                                                <td>{{ $state->title }}</td>
	                                                <td>{{ @$area->title }}</td>
	                                                <td>
                                                        <a href="recipients/edit/{{ $recipient->id }}" class="btn btn-block btn-primary">Edit</a>
                                                        <a href="recipients/delete/{{ $recipient->id }}" class="btn btn-block btn-danger">Delete</a>
                                                    </td>
	                                            </tr>
                                            @endforeach
                                          
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date created</th>
                                                <th>First name</th>
                                                <th>Last name</th>
                                                <th>Phone number</th>
                                                <th>Phone number two</th>
                                                <th>State</th>
                                                <th>Area</th>
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