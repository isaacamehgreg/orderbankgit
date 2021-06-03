@extends('app')
@section('title', 'Referral')
@section('content')
    <div class="row">
        <div class="offset-xl-7 col-xl-5 col-lg-3 col-md-6 col-sm-12 col-12">
            @if ($referral_code != "")
                <form>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" id="ref-code" disabled value="{{strtoupper($referral_code)}}" />

                        <div class="input-group-append">
                        <button type="button" class="btn btn-primary" data-clipboard-text="{{$referral_code}}">Copy Code</button>
                <button type="button" class="btn btn-info" data-clipboard-text="{{url('/signup?r='.$referral_code)}}">
                    Copy Link
                </button>
                        </div>
                    </div>
                </form>
            @else
                <form method="post" action="/referral/generate-code">
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" id="ref-code" disabled placeholder="No referral code" />
                        <div class="input-group-append">
                            @csrf
                            <button class="btn btn-primary" type="submit">Generate Referral Code</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="row">
                <div class="col-sm-12">
                    <h5 class="card-header">Share your referral code with friends and earn when they fund their
                        wallet.</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="#!">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-inline-block">
                                                <h5 class="text-muted">Referral Bonus</h5>
                                                <h3 class="mb-0">2.5%</h3>
                                            </div>
                                            <div
                                                class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                <i class="fa fa-list fa-fw fa-sm text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="#!">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-inline-block">
                                                <h5 class="text-muted">Total Referrals</h5>
                                                <h3 class="mb-0">{{$num_referred_users}}</h3>
                                            </div>
                                            <div
                                                class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                <i class="fa fa-play fa-fw fa-sm text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <a href="#!">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-inline-block">
                                                <h5 class="text-muted">Amount Earned</h5>
                                                <h3 class="mb-0"> ₦ {{$total_earnings}}</h3>
                                            </div>
                                            <div
                                                class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                                <i class="fa fa-ship fa-fw fa-sm text-info"></i>
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

        <div class="card">
            <h5 class="card-header">Users you have referred</h5>
            <div class="card-body">
                @if ($num_referred_users < 1)
                    <p>You currently do not have any referrals under you.</p>
                @else
                <div class="table-responsive">
                    <table class="table table-striped table-bordered first">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($referred_users as $referral)
                            <tr>
                                <td>{{ $referral->referred->firstname . " ". $referral->referred->lastname }}</td>
                                <td>{{ $referral->referred->email_address }}</td>
                                <td>{{ date( 'jS'.' \o\f'.' M, Y'.' \a\t'. ' g:iA', strtotime( $referral->created_at )) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://unpkg.com/clipboard@2/dist/clipboard.min.js"></script>
    <script type="text/javascript">
        new ClipboardJS('.btn');
    </script>
@endsection
