@extends('app')
@section('title', 'Input Order')
@section('content')

<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Input Order</h5>
            <div class="card-body">
                <form action="" method="post">
                                    @csrf
                                    @include('messages')

                                    <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label>Full Name:</label>
                                        <input name="fullname" value="" id="fullname" class="form-control" />
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label>Active Phone Number:</label>
                                        <input name="phone_number" id="phonenumber" class="form-control" />
                                    </div>


                                    <div class="col-sm-12 form-group">
                                        <label>Alternative Phone Number (Optional):</label>
                                        <input name="phone_number_two" id="phonenumbertwo" class="form-control" />
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label>Full Address:</label>
                                        <input name="full_address" id="address" class="form-control" />
                                    </div>



                                    <div class="col-sm-12 form-group">
                                        <label>State:</label>
                                        <select name="state" id="state" class="form-control">
                                            <option disabled selected>--Select State--</option>
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
                                        <label>Active Email Address:</label>
                                        <input name="email_address" id="email" class="form-control" />
                                    </div>


                                    <div class="col-sm-12 form-group">
                                    <label>Enter The Quantity:</label>

                                    <input name="qty" class="form-control" value="" id="qty">

                                </div>

                                <div class="col-sm-12 form-group">
                                    <label>Enter Product Name:</label>

                                    <input name="product_name" class="form-control" value="" id="qty">

                                </div>

                                <div class="col-sm-12 form-group">
                                    <label>Enter The Price:</label>

                                    <input name="price" class="form-control" value="" id="qty">

                                </div>

                                 <div class="col-sm-12 form-group">
                                        <label>Delivery Time:</label>
                                        <input class="form-control" name="delivery_time" value="" placeholder="" id="" >

                                    </div>

                                    <br>

                                    &nbsp;&nbsp;&nbsp;&nbsp; <button class="btn btn-secondary" id="submitBtn">Submit Order</button>

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
