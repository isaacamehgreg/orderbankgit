@extends('app')
@section('title', 'Sales Page Dashboard')
@section('content')
@include('messages')
<div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Here Are The List Of Your Sales Pages<a href='/store/items/add' class="btn btn-sm btn-success float-right"><b>Create Sales Page</b></a></h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th><b style="color: #5E2CED;">DATE CREATED</th>
                                                <th><b style="color: #5E2CED;">ITEM NAME</th>
                                                {{--<th><b style="color: #5E2CED;">DESCRIPTION</th>--}}
                                                <th><b style="color: #5E2CED;">ITEM FEATURED IMAGE</th>
                                                <th><b style="color: #5E2CED;">MANAGE</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        	@foreach($items as $item)
	                                            <tr>
	                                                <td>{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $item->created_at )) }}</td>
                                                    <td>{{ $item->item_name }}
                                                    @php
                                                    $form = App\Forms::find($item->form_id);
                                                    $product_id = json_decode($form->products, true)[0];
                                                    $store = App\Store::find($item->store_id);
                                                    @endphp
                                                    <br>
                                                    <a class="btn btn-sm btn-primary" target="_blank" href="{{ url('store/i/'.$store->store_url_slug.'/'.$item->id.'/'.str_slug($item->item_name)) }}">View Product</a>
                                                    </td>
                                                    <td>@if(!empty($item->item_featured_image)) <img src="/uploads/store/items/{{ $item->item_featured_image }}" style="width: 200px;"/> @endif</td>

	                                                <td>
                                                        <a href="/store/items/duplicate/{{ $item->id }}" class="btn btn-block btn-dark">DUPLICATE</a>

                                                        @if($item->hidden)
                                                            <a href="/store/items/unhide/{{ $item->id }}" class="btn btn-block btn-primary">UNHIDE</a>
                                                        @else
                                                            <a href="/store/items/hide/{{ $item->id }}" class="btn btn-block btn-warning">HIDE</a>
                                                        @endif

                                                        <a href="/store/items/edit/{{ $item->id }}" class="btn btn-block btn-primary">EDIT</a>
                                                        <a href="/store/items/delete/{{ $item->id }}" class="btn btn-block btn-danger">DELETE</a>
                                                    </td>
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
