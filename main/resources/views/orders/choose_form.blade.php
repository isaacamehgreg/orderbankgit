@extends('app')
@section('title', 'Edit Order')
@section('content')

<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Assign form to order</h5>
            <div class="card-body">
                <form action="" method="post">
                                    @csrf
                                    @include('messages')
                                    
                                 <div class="col-sm-12 form-group">
                                        <label>Choose Form For This Order</label>
                                        <select name="form" id="delivery_time" class="form-control">
	                                        @foreach($forms as $form)
	                                        	<option value="{{ $form->id }}">{{ $form->title }}</option>
	                                        @endforeach
	                                    </select>
                                    </div>

                                    <br>

                                    &nbsp;&nbsp;&nbsp;&nbsp; <button class="btn btn-secondary" id="submitBtn">Submit Now!</button>
    
                                </form>

            </div>
        </div>
    </div>
</div>

@endsection