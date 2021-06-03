@extends('app')
@section('title', 'Edit Order')
@section('content')

<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Edit Order [{{ $order->invoice }}]</h5>
            <div class="card-body">
                <form action="" method="post">
                                    @csrf
                                    @include('messages')

                                    <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label>Your Full Name:</label>
                                        <input name="fullname" value="{{ $customer->fullname }}" id="fullname" class="form-control" />
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label>Your Full Address (Home Or Office, we deliver to anywhere you want):</label>
                                        <input name="address" value="{{ $customer->address }}" id="address" class="form-control" />
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label>State</label>
                                        <select name="state" id="state" class="form-control">
                                            <option selected value="{{ $customer->state }}">{{ $customer->state }}</option>
                                            <option value="Abia">Abia</option>
                                            <option value="Adamawa">Adamawa</option>
                                            <option value="Akwa Ibom">Akwa Ibom</option>
                                            <option value="Anambra">Anambra</option>
                                            <option value="Bauchi">Bauchi</option>
                                            <option value="Bayelsa">Bayelsa</option>
                                            <option value="Benue">Benue</option>
                                            <option value="Borno">Borno</option>
                                            <option value="Cross River">Cross River</option>
                                            <option value="Delta">Delta</option>
                                            <option value="Ebonyi">Ebonyi</option>
                                            <option value="Edo">Edo</option>
                                            <option value="Ekiti">Ekiti</option>
                                            <option value="Enugu">Enugu</option>
                                            <option value="FCT">Federal Capital Territory</option>
                                            <option value="Gombe">Gombe</option>
                                            <option value="Imo">Imo</option>
                                            <option value="Jigawa">Jigawa</option>
                                            <option value="Kaduna">Kaduna</option>
                                            <option value="Kano">Kano</option>
                                            <option value="Katsina">Katsina</option>
                                            <option value="Kebbi">Kebbi</option>
                                            <option value="Kogi">Kogi</option>
                                            <option value="Kwara">Kwara</option>
                                            <option value="Lagos">Lagos</option>
                                            <option value="Nasarawa">Nasarawa</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Ogun">Ogun</option>
                                            <option value="Ondo">Ondo</option>
                                            <option value="Osun">Osun</option>
                                            <option value="Oyo">Oyo</option>
                                            <option value="Plateau">Plateau</option>
                                            <option value="Rivers">Rivers</option>
                                            <option value="Sokoto">Sokoto</option>
                                            <option value="Taraba">Taraba</option>
                                            <option value="Yobe">Yobe</option>
                                            <option value="Zamfara">Zamfara</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label>Your Active Email Address</label>
                                        <input name="email" value="{{ $customer->email }}" id="email" class="form-control" />
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label>Your Active Phone Number:</label>
                                        <input name="phonenumber" value="{{ $customer->phonenumber }}" id="phonenumber" class="form-control" />
                                    </div>


                                    <div class="col-sm-12 form-group">
                                        <label>Alternative Phone Number (Optional):</label>
                                        <input name="phonenumbertwo" value="{{ $customer->phonenumber_two }}" id="phonenumbertwo" class="form-control" />
                                    </div>




                                    <div class="col-sm-12 form-group">
                                        <label>Select The One You Want To Order For:</label>
                                    <br><br>
                                      @foreach(json_decode($form->products) as $products)
                                        @php
                                        $product = App\Products::find($products);
                                        @endphp

                                        <div class="row">

                                            <div class="" style="margin-left: 15px;">
                                                <input name="product" @if($order->product_id == $product->id) checked @endif class="product" id="product" type="checkbox" value="{{ $product->id }}">
                                            </div>


                                            <div class="col-sm-2">
                                                <input onkeyup="totalprice({{ $product->id }}, {{ $product->price }})"  class="form-control" id="qty_{{ $product->id }}" readonly max="{{ $product->qty }}" type="number" value="{{ $product->qty }}">
                                            </div>

                                            <div class="col-sm-5">
                                                <input class="form-control" readonly value=" {{ $product->title }}">
                                            </div>


                                            <div class="col-sm-3">
                                                <input id="total_{{ $product->id }}" style="max-width: 400px; display: inline-block;" class="form-control total" readonly value="₦{{ number_format($product->price) }}" price="{{ number_format($product->price) }}">

                                                                                            </div>

                                        </div>

                                         <br>

                                      @endforeach
                                      <input name="product_total_price" value="{{ $product->price }}" id="product_total_price" hidden>
<input name="product_qty" value="{{ $product->qty }}" id="product_qty" hidden>

                                </div>

                                 <div class="col-sm-12 form-group">
                                        <label>Select When You Want Us To Deliver This Order:</label>
                                        <select name="delivery_time" id="delivery_time" class="form-control">
	                                        <option value="{{ @$order->delivery_time }}">{{ @$order->delivery_time }}</option>

	                                        <option value="Within 24hrs (Today or Tomorrow)">Within 24hrs (Today or Tomorrow)</option>
	                                        <option value="Within 48hrs (Within 2days)">Within 48hrs (Within 2days)</option>
	                                        <option value="Within 72hrs (Within 3days)">Within 72hrs (Within 3days)</option>
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
@section('scripts')
<script>


	$('.product').on('change', function() {
		let product = $(this).val();
		let qty = $('#qty_' + product).val();
		let total = $('#total_' + product).attr('price');


		$('#product_qty').val(qty);
		$('#product_total_price').val(total);

		console.log(total);
		console.log(qty);

	});


	function totalprice(id, amount) {
            let qty = $('#qty_' + id).val();
            let total = amount * qty;

            $('#total_' + id).attr('value', 'N' + total.format());
        }

        Number.prototype.format = function(n, x) {
            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
            return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
        };

        $('input[type="checkbox"]').on('change', function() {
            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
        });
</script>
@endsection
