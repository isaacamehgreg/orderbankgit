@extends('app')
@section('title', 'Waybill - General - Areas')
@section('content')

<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Areas <a href='areas/add' class="btn btn-sm btn-success float-right"><b>Add +</b></a></h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Date created</th>
                                                <th>Title</th>
                                                <th>State</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        	@foreach($areas as $state)
	                                            <tr>
	                                                <td>{{ $state->created_at }}</td>
	                                                <td>{{ $state->title }}</td>
                                                    <td>{{ App\States::find($state->state_id)->title }}
	                                                <td>
                                                        <a href="areas/edit/{{ $state->id }}" class="btn btn-block btn-primary">Edit</a>
                                                        <a href="areas/delete/{{ $state->id }}" class="btn btn-block btn-danger">Delete</a>
                                                    </td>
	                                            </tr>
                                            @endforeach
                                          
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date created</th>
                                                <th>Title</th>
                                                <th>Status</th>
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