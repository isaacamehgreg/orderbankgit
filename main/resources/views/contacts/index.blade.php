@extends('app')
@section('title', 'Manage Contact Forms')
@section('content')

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="row">
                    <div class="col-sm-12">
                        <h5 class="card-header">Your Contact Form Statistics.</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="#!">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Total Contact Forms</h5>
                                                    <h3 class="mb-0">{{$forms->count()}}</h3>
                                                </div>
                                                <div
                                                    class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-list fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="#!">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-inline-block">
                                                    <h5 class="text-muted">Total Form Views</h5>
                                                    <h3 class="mb-0">{{$forms->sum('views')}}</h3>
                                                </div>
                                                <div
                                                    class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                    <i class="fa fa-eye fa-fw fa-sm text-info"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card" style="background-color: transparent;">
                <h5 class="card-header">Here Are The List Of Your Forms<a href='/contacts/create' class="btn btn-sm btn-success float-right"><b>+ ADD CONTACT FORM</b></a></h5>
                <div class="card-body">
                    @php
                        $count = 0;
                    @endphp
                    <div class="row">
                        @foreach($forms as $form)
                            @php
                                $count++;
                            @endphp
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <div class="card border-dark mb-3">
                                    <div class="card-body bg-light border-primary mb-3">
                                        <div class="row text-center">
                                            <div class="col">{{$count}}</div>
                                            <div class="col"><a href="contacts/edit/{{ $form->id }}" class="btn btn-sm btn-block btn-primary">UPDATE CONTACT FORM</a></div>
                                            <div class="col"><input type="checkbox" class="bulk" id="{{ $form->id }}" name="form_id[]" /><b style="color: #5E2CED;"></b></div>
                                        </div>
                                        <hr><br>

                                        {{-- <li>Products: @foreach(json_decode($form->products) as $products)
                                           {{ @App\Products::find($products)->title }}
                                       @endforeach</li> --}}
                                        Form Name: {{ $form->title }}
                                        <br>
                                        <br>
                                        </li><textarea class="form-control" style="height: 78px;"><iframe src="{{ url('contact-form/'.$form->link) }}" style="border: none;width: 100%; height: 2000px;"></iframe> Copy the code and paste in HTML area of your website</textarea>
                                        <br>
                                        {{--  <a href="forms/edit/{{ $form->id }}" class="btn btn-info btn-block">EDIT ORDER FORM</a> --}}
                                        <a href="contacts/delete/{{ $form->id }}" class="btn btn-danger btn-block">DELETE CONTACT FORM</a>
                                        <a href="{{ url('contact-form/'.$form->link) }}" class="btn btn-success btn-block">CONTACT FORM LINK</a>
                                        <a href="{{$form->redirect}}" class="btn btn-warning btn-block">REDIRECTED LINK</a>
                                        <a href="/admin/customers/entries/form/{{$form->id}}" class="btn btn-warning btn-block">VIEW ENTRIES</a>
                                    </div>
                                    <div class="btn btn-block btn-primary">{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $form->created_at )) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

@endsection
