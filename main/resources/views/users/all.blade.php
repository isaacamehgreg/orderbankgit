@extends('app')
@section('title', 'Users - All')
@section('content')

 @include('messages')
<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">All users</h5>

                            <div class="card-body">
                                <div class="offset-xl-10 col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                <form>
                                    <div class="form-group">
                                        <a href="/users/add" class="btn btn-primary" style="width: 165px;">Add user +</a>
                                    </div>
                                </form>
                            </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Date created</th>
                                                <th>Role</th>
                                                <th>First name</th>
                                                <th>Last name</th>
                                                <th>E-mail address</th>
                                                <th>Phone number</th>
                                                <th>Address</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@foreach($users as $user)

	                                            <tr>
	                                                <td>{{ $user->created_at }}</td>
                                                    @php
                                                      if($user->role == 1) {
                                                         $role = 'Super Admin';
                                                      } elseif ($user->role == 2) {
                                                          $role = 'Customer Support';
                                                      } elseif ($user->role == 3) {
                                                          $role = 'Administrative Officer';
                                                      } elseif ($user->role == 4) {
                                                          $role = 'Accountant';
                                                      }
                                                    @endphp
                                                    <td><button class="btn btn-sm btn-success">{{ $role }}</button></td>
	                                                <td>{{ $user->firstname }}</td>
                                                    <td>{{ $user->lastname }}</td>
	                                                <td>{{ $user->email_address }}</td>
	                                                <td>{{ $user->phone_number }}</td>
	                                                <td>{{ $user->address }}</td>
                                                    <td>
                                                        <a href="/users/edit/{{ $user->id }}" class="btn btn-sm btn-block btn-primary">Edit user</a>
                                                        <a href="/users/reset/{{ $user->id }}" class="btn btn-sm btn-block btn-secondary">Reset password</a>
                                                        @if($user->disabled == 'no')
                                                            <a href="/users/disable/{{ $user->id }}" class="btn btn-sm btn-block btn-danger">Disable user</a>
                                                        @else
                                                            <a href="/users/enable/{{ $user->id }}" class="btn btn-sm btn-block btn-success">Enable user</a>
                                                        @endif
                                                        <a href="/users/delete/{{ $user->id }}" class="btn btn-sm btn-block btn-danger">Delete user</a>
	                                            </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date created</th>
                                                <th>Role</th>
                                                <th>First name</th>
                                                <th>Last name</th>
                                                <th>E-mail address</th>
                                                <th>Phone number</th>
                                                <th>Address</th>
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
