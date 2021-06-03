@extends('app')
@section('title', 'Manage TODOS')
@section('content')

    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">TODOS LIST<a href='/reports' class="btn btn-sm btn-success float-right"><b>Add +</b></a></h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first">
                            <thead>
                            <tr>
                                <th><b style="color: #5E2CED;">Todos</b></th>
                                <th><b style="color: #5E2CED;">Created at</b></th>
                                <th><b style="color: #5E2CED;">MANAGE</b></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($todos as $todo)
                                <tr>
                                    <td style="font-size: large">{{ $todo->todos }}</td>
                                    <td>{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $todo->created_at )) }}</td>
                                    <td>
                                        <a href="" class="btn btn-block btn-primary">EDIT</a>
                                        <a href="" class="btn btn-block btn-success">Complete</a>
                                        <a href="" class="btn btn-block btn-danger">DELETE</a>


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
