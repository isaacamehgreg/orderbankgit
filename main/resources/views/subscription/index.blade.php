@extends('app')
@section('title', 'Subscription')
@section('content')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if ($message = Session::get('success'))
    <script>
        swal("Success", "{{ $message }}", "success");
    </script>
@endif


@if ($message = Session::get('error'))
    <script>
        swal("Error", "{{ $message }}", "error");
    </script>
@endif
<div class="layout-content">
        <div class="container-fluid flex-grow-1 container-p-y">

            <h6 class="pb-1 mt-5 mb-4">Select A Subscription Plan</h6>

            <div class="row">
       
                @foreach ($subscriptions as $subscription)
                    <div class="col-md-3 col-xl-4">
                        <div class="card mb-3 text-area" style="max-width: 40rem;">
                            <div class="card-header">
                                {{$subscription->title}}
                               </div>
                            <div class="card-body">
                                <h4 class="card-title">&#8358; {{ number_format($subscription->price) }} / {{ $subscription->duration_type }}</h4>
                                <ul class="list-group list-group-flush">
                                    {{-- @if (!empty(json_decode($subscription->description)))
                                        @foreach (json_decode($subscription->description) as $perk=>$value)
                                            <li class="list-group-item">
                                                {{ucfirst(str_replace('_', ' ', $perk))}}:
                                                <b>{{$value}}</b>
                                            </li>
                                        @endforeach
                                    @endif --}}
                                   
                                        {!! $subscription->description !!}
                                   
                                </ul>
                            </div>

                            @php
                            $price = 1000;
                            $date = DateTime::createFromFormat('', $subscription->ends);
                            $endsDate =  $date->getTimestamp();

                            @endphp

                
                            @if($business_subscription)
                            
                                @if($business_subscription->subscription_id == $subscription->id && time() >= $business_subscription->end_at)
                                <div class="card-body">
                                    <button class="btn btn-danger">Expired</button>
                                @if($subscription->price != 0)
                                    <a href="javascript:void(0)" class="btn btn-success card-link"
                                    data-plan-code="{{$subscription->paystack_plan_code}}"
                                    data-price="{{$subscription->price}}"
                                    data-plan-id="{{$subscription->id}}"
                                    onclick="subscribe(this)">Renew</a>
                                    
                                @endif
                                </div>
                                                               
                            
                            @elseif($business_subscription->subscription_id == $subscription->id && $endsDate >= time())
                                <div class="card-body">
                                    <button class="btn btn-primary"> Active</button>
                                    {{-- <a href="/subscription/cancel/{{ $subscription->id }}" class="btn btn-danger card-link">
                                        Cancel</a> --}}
                                </div>
                            @else
                            @if($subscription->price != 0)
                            <div class="card-body">
                                <a href="{{ url('subscription/upgrade/'.$subscription->id) }}" class="btn btn-success card-link">
                                    Upgrade</a>
                               
                            </div>
                            @endif
                            @endif
                            @else
                            @if($subscription->price == '0.00')
                            @if($business_subscription)
                                @if ($business_subscription->subscription_id == $subscription->id)
                                <div class="card-body">
                                    <a href="#!" class="btn btn-success card-link">
                                        Subscribed</a>
                                </div>
                                @else
                                <div class="card-body">
                                    <a href="{{ url('subscription/buy/'.$subscription->id) }}" class="btn btn-success card-link">
                                        Upgrade</a>
                                </div>
                                @endif
                            @else
                                <div class="card-body">
                                    <a href="{{ url('subscription/free') }}" class="btn btn-success card-link">
                                        Get Started For Free</a>
                                </div>
                                @endif
                            @else
                            <div class="card-body">
                                <a href="{{ url('subscription/upgrade/'.$subscription->id) }}" class="btn btn-success card-link"
                                >
                                    Subscribe To This Plan</a>
                            </div>
                            @endif

                            @endif
                    
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script type="text/javascript">
        function subscribe(el) {
            let price = el.getAttribute("data-price"),
                planCode = el.getAttribute("data-plan-code"),
                planId = el.getAttribute("data-plan-id"),
                reference = "{{$reference}}";

            let handler = PaystackPop.setup({
                key: "pk_live_dd6353d10918b9001033b999af3af190eac897ba",
                email: "{{auth()->user()->email_address}}",
                amount: price*100,
                currency: "NGN",
                ref: reference,
                // plan: planCode,
                channels: ['card'],
                metadata: {
                    custom_fields: [
                        {
                            display_name: "Mobile Number",
                            variable_name: "mobile_number",
                            value: "{{auth()->user()->phone}}"
                        }
                    ]
                },
                callback: function(response){
                    console.log(response);
                    window.location.href = "/verify-payment/"+reference
                },
                onClose: function(){
                    alert("failed to complete request");
                }
            });
            handler.openIframe();
        }
    </script>
@endsection
