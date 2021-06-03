@extends('app')
@section('title', 'Waybill - Generate Waybill')
@section('content')
<style>
.card-header {
    background-color: #fff;
    border-bottom: 1px solid #ffffff;
}

</style>
<form id="form" method="post">

<div class="row" style="margin-left: -1px; background: #e06c42;">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header" style="margin-bottom: 10px;">
                    <input id="dropoffpoint" name="dropoffpoint" value="{{ $dropoffpoint->id }}" hidden>
                    <h5 class="mb-2" style="color: #fff; margin-top: 7px;">Drop Off Point: <a class="text-white" data-toggle="modal" data-target="#dropoffpointModal" href="#!" style="text-decoration: underline;"><span id="dropoffpointname">{{ $dropoffpoint->name }}</span> (edit)</a> </h5>
                </div>
            </div>
        </div>
    <br>
    <div class="row">
<div class="col-xl-8 col-lg-9 col-md-9 col-sm-12 col-12">
        <div class="col-xl-12 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" style="padding: 20px; padding-bottom: 50px;">
                                    <label>Sender</label>
                                    <input name="sender" id="sender" class="form-control" value="PERFECT MALL NIGERIA" readonly="" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card" style="margin-top: -3px;">
                            <div class="card-body">
                                <div class="row" id="recipient_card_row" style="padding: 20px; padding-bottom: 50px;">
                                <label>Recipient</label>
                                    <div class="input-group" id="recipient_card">
                                          <select class="form-control select2" name="recipient" id="recipient" style="height: 100px;">
                                            <option value="">Choose...</option>
                                            @foreach($recipients as $recipient)
                                                <option value="{{ $recipient->id }}">{{ $recipient->firstname }} {{ $recipient->lastname }}</option>
                                            @endforeach
                                          </select>
                                          <div class="input-group-append">
                                            <button style="height: 38px;" class="btn btn-primary" data-toggle="modal" data-target="#addrecipientModal" type="button">ADD +</button>
                                          </div>
                                </div>


                                <div class="" id="recipient_card2">
                                    <br>
                                    <b style="font-size: 18px; font-family: 'Proxima Nova Regular'" id="recipient_name"></b>
                                    
                                    <p><span id="recipient_address">address</span> <br> <span id="recipient_phone">phone</span></p>
                                    <a href="#!" class='btn btn-sm btn-secondary' id="editrecipient" data-toggle="modal" data-target="#editrecipientModal">Edit profile</a> <a href="#!" id="recipient_change" class="btn btn-sm btn-primary">Change</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

     


        <div class="col-xl-12 col-lg-9 col-md-9 col-sm-9 col-12">
            <div class="card">
                <div class="row" style="padding: 20px; padding-bottom: 50px;">
                    <div class="col-sm-12">
                        <h5 class="card-header">Shipment info</h5>
                        <div class="card-body">
                             <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">Date of shipment</label>
                                  <input type="text" name="date_of_shipment" id="date_of_shipment" class="form-control" value="{{ date('d/m/Y') }}" readonly id="" placeholder="Date of shipment">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="inputState">Payment method</label>
                                  <select id="payment_method" id="payment_method" class="form-control">
                                    <option>Choose...</option>
                                    <option value="payment_on_delivery" selected>Payment on delivery</option>
                                  </select>
                                </div>

                                
                                <div class="form-group col-md-6">
                                  <label for="inputState">Shipment Types</label>
                                  <select id="shipment_type" name="shipment_type" class="form-control">
                                    <option>Choose...</option>
                                    <option value="standard_shipping" selected>Standard Shipping</option>
                                  </select>
                                </div>


                                <div class="form-group col-md-6">
                                  <label for="inputCity">Reference Number (Optional)</label>
                                  <input type="text" class="form-control" id="reference_number" name="reference_number">
                                </div>

                              </div>
                         
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <div style="display: contents;" id="packages">
   
            <div class="col-xl-12 col-lg-9 col-md-9 col-sm-9 col-12" id="package1">
                <div class="card">
                    <div class="row" style="padding: 20px; padding-bottom: 50px;">
                        <div class="col-sm-12">
                            <div class="card-header"><h5 style="display: inline">Package Details</h5> <div class="float-right" style="margin-right: -20px;"><button onclick="addItem(1)" style="height: 29px;" class="btn btn-primary btn-sm" type="button">Add item</button></div></div>
                            <div class="card-body">
                            <div id="item_card_1">
                                    <div class="form-row align-items-center" id="package1">
                                        <div class="col-sm-4">
                                          <label class="" for="inlineFormInput">Item name</label>
                                          <input type="text" class="form-control mb-2 packages_item_name" id="package1_item_name" placeholder="" name="packages_item_name[]">
                                        </div>

                                        <div class="col-sm-2">
                                          <label class="" for="inlineFormInput">Unit Price</label>
                                          <input type="number" class="form-control mb-2 unit-price packages_item_unit_price" onkeyup="total_price(1)" placeholder="0" value="" id="package1_item_unit_price" name="packages_item_unit_price[]">
                                        </div>

                                        <div class="col-sm-2">
                                          <label class="" for="inlineFormInput">Qty</label>
                                          <input type="number" class="form-control mb-2 qty packages_item_qty" onkeyup="total_price(1)" placeholder="" value="1" id="package1_item_qty" name="packages_item_qty[]">
                                        </div>

                                        <div class="col-sm-3">
                                          <label class="" for="inlineFormInput">Total Price</label>
                                          <input type="text" readonly="" value="0.00" class="form-control mb-2 total-price packages_item_total_price" id="package1_item_total_price" name="packages_item_total_price[]">
                                        </div>
                                       
                                      
                                        </div>
                                    </div>

                                    <div class="form-row align-items-center">
                                        <div class="col-sm-6">
                                          <label class="" for="inlineFormInput">Weight (Kg)</label>
                                          <input type="number" value="" class="form-control mb-2" id="packages_weight" name="packages_weight" placeholder="">
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
</div>
               <div class="col-xl-4">
            <div class="card">
                <div class="row" style="padding: 20px;">
                    <div class="col-sm-12">
                        <h5 class="card-header">Shipping Cost</h5>
                        <div class="card-body">
                            <div class="row" style="padding-bottom: 20px;">
                                <div class="col-sm-9">Processing Fee</div>
                                <input name="fee" hidden="hidden" id="fee">
                                <div clss="col-sm-4 float-right">N <span id="fee_text">0</span></div>
                            </div>
                            <div class="row" style="padding-bottom: 20px;">
                                <div class="col-sm-9">Additional Services</div>
                                <div clss="col-sm-4 float-right">N 0</div>
                            </div>
                            <hr>
                            <div class="row" style="padding-bottom: 20px;">
                                <div class="col-sm-9">Total</div>
                                <input name="total_fee" hidden="hidden" id="total_fee">
                                <div clss="col-sm-4 float-right">N <span id="total_text">0</span></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        </div>

    </form>

        <div class="row">
        <button class="btn btn-primary" style="margin-left: 30px;" id="generate_waybill">Generate Waybill</button>
    </div>

    </div>


    <!-- Modal -->
<div class="modal" id="dropoffpointModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Drop off Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="">
            <label>Select location</label>
            <select class="custom-select" id="dropoffpointselect">
                @foreach($dropoffpointall as $dropoffpoints)
                    <option @if($dropoffpoints->id == $dropoffpoint->id) selected @endif value="{{ $dropoffpoints->id }}">{{ $dropoffpoints->name }}</option>
                @endforeach
            </select>
            <br><br>
            <div class="card" id="dropoffpointcard">
                        <div class="card-body">
                            <p><b>Address</b></p>
                            <p id="dropoffpointaddress">{{ $dropoffpoint->address }}</p>
                            <p id="dropoffpointphonenumber">{{ $dropoffpoint->phonenumber }}</p>
                        </div>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Save location</button>
      </div>
    </div>
  </div>
</div>








    <!-- Modal -->
<div class="modal" id="addrecipientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Receiver Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="addrecipient_form">
             <div id="addrecipient_msg"></div>
              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">First name</label>
                                  <input type="text" class="form-control" name="addrecipient_firstname" id="addrecipient_firstname" placeholder="Enter customer first name">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="inputState">Last name</label>
                                  <input type="text" class="form-control" name="addrecipient_lastname" id="addrecipient_lastname" placeholder="Enter customer last name">
                                </div>

                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">Phone number</label>
                                  <input type="text" class="form-control" name="addrecipient_phonenumber" id="addrecipient_phonenumber" placeholder="Enter customer phone number ">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="inputState">Phone number 2 (optional)</label>
                                  <input type="text" class="form-control" name="addrecipient_phonenumber_two" id="addrecipient_phonenumber_two" placeholder="Enter customer phone number 2">
                                </div>

                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">Select State</label>
                                    <select id="addrecipient_state" name="addrecipient_state" class="form-control">
                                        <option value="" selected>Choose...</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->title }}</option>
                                        @endforeach
                                  </select>                                
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="addrecipient_area">Select Area</label>
                                  <select id="addrecipient_area" name="addrecipient_area" class="form-control">
                                    <option selected value="">Choose...</option>
                                  </select>
                                </div>

                                <div class="form-group col-md-12">
                                  <label for="inputState">Address</label>
                                  <textarea name="addrecipient_address" id="addrecipient_address" class="form-control"></textarea>
                                </div>

                              </div>
                          </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="addrecipient_close" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addrecipient_save">Save recipient</button>
      </div>
    </div>
  </div>
</div>



<!-- modal -->
<div class="modal" id="editrecipientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Receiver Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="editrecipient_form">
             <div id="editrecipient_msg"></div>
              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">First name</label>
                                  <input type="text" class="form-control" name="editrecipient_firstname" id="editrecipient_firstname" placeholder="Enter customer first name">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="inputState">Last name</label>
                                  <input type="text" class="form-control" name="editrecipient_lastname" id="editrecipient_lastname" placeholder="Enter customer last name">
                                </div>

                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">Phone number</label>
                                  <input type="text" class="form-control" name="editrecipient_phonenumber" id="editrecipient_phonenumber" placeholder="Enter customer phone number ">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="inputState">Phone number 2 (optional)</label>
                                  <input type="text" class="form-control" name="editrecipient_phonenumber_two" id="editrecipient_phonenumber_two" placeholder="Enter customer phone number 2">
                                </div>

                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">Select State</label>
                                    <select id="editrecipient_state" name="editrecipient_state" class="form-control">
                                        <option value="" selected>Choose...</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->title }}</option>
                                        @endforeach
                                  </select>                                
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="editrecipient_area">Select Area</label>
                                  <select id="editrecipient_area" name="editrecipient_area" class="form-control">
                                    <option selected value="">Choose...</option>
                                  </select>
                                </div>

                                <div class="form-group col-md-12">
                                  <label for="inputState">Address</label>
                                  <textarea name="editrecipient_address" id="editrecipient_address" class="form-control"></textarea>
                                </div>

                              </div>
                          </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="editrecipient_close" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editrecipient_save">Edit recipient</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="/libs/js/axios.min.js"></script>
<script src="/libs/js/sweetalert2.all.min.js"></script>

<script>
    $('#recipient_card2').hide();

    // Get location etc
    let dropoffpointselect = $('#dropoffpointselect');
    dropoffpointselect.on('change', () => {

        let _id = dropoffpointselect.val();

        axios.get('/api/location?location_id=' + _id, {
            location_id: dropoffpointselect.val(),
        })
        .then(function (response) {
            let dropoffpointaddress = $('#dropoffpointaddress');
            let dropoffpointphonenumber = $('#dropoffpointphonenumber');
            let dropoffpoint = $('#dropoffpoint');
            let dropoffpointname = $('#dropoffpointname');

            // update
            dropoffpointaddress.text(response.data.address);
            dropoffpointphonenumber.text(response.data.phonenumber);
            dropoffpoint.val(response.data.id);
            dropoffpointname.text(response.data.name);

            // console.log(response.data);
        })
        .catch(function (error) {
            console.log(error);
        });        

    });


    // Get area
    let addrecipient_state = $('#addrecipient_state');
    addrecipient_state.on('change', function() {
        let id = addrecipient_state.val();

        axios.get('/api/areas?state_id=' + id)
             .then(function(response) {

                // console.log(response.data);
                $('#addrecipient_area').html(response.data);
                $('#editrecipient_area').html(response.data);

             }).catch(function(err) {
                console.log(err);
             });
    });

        let editrecipient_state = $('#editrecipient_state');
        editrecipient_state.on('change', function() {
            let id = editrecipient_state.val();

            axios.get('/api/areas?state_id=' + id)
                 .then(function(response) {

                    // console.log(response.data);
                    $('#editrecipient_area').html(response.data);

                 }).catch(function(err) {
                    console.log(err);
                 });
        });

    // Get area function 
    async function getArea(id) {
       try {
            let getData = await axios.get('/api/area?area_id=' + id);
            return getData.data;
        } catch (e) {
            console.log(e);
        }
    }


    // Change recipient
    let recipient_card = $('#recipient_card');
    let recipient_card2 = $('#recipient_card2');
    let recipient = $('#recipient');
    let recipient_card_row = $('#recipient_card_row');
    let recipient_name = $('#recipient_name');
    let recipient_phone = $('#recipient_phone');
    let recipient_address = $('#recipient_address');

    async function getRecipient(id) {
        let recipient_id = id;

        axios.get('/api/recipient?id=' + recipient_id)
              .then(function(response) {
                let data = response.data;
                // hide main card
                recipient_card.hide();
                // set style
                recipient_card_row.css({display: 'contents'});

                // set data
                recipient_name.text(data.firstname + " " + data.lastname);
                recipient_address.text(data.address);
                recipient_phone.text(data.phonenumber + ", " + data.phonenumber_two);

                let area = getArea(data.area_id).then(data => {
                    // console.log(data[0]['shipping_fee']);
                    // update shipping cost
                    $('#total_text').text(data[0]['shipping_fee']);
                    $('#fee_text').text(data[0]['shipping_fee']);

                    $('#fee').val(data[0]['shipping_fee']);
                    $("#total_fee").val(data[0]['shipping_fee']);
                });
                
                // show other card
                recipient_card2.show();

                // console.log(data);

              })
              .catch(function(err) {
                console.log(err);
              });
    }

    recipient.on('change', async function() {
        if(recipient.val() == 0) { return; };
        // get recipient info and update..
        let recipient_id = recipient.val();

        await getRecipient(recipient_id);
    });


    $('#recipient_change').on('click', () => {
        recipient_card.show();
        $('#recipient_card2').hide();

        document.getElementById('recipient').selectedIndex = 0;

        $('#total_text').text(0);
        $('#fee_text').text(0);

        // set style
        recipient_card_row.css({display: 'block'});
    });


    $('#addrecipient_save').on('click', async function() {
        let addrecipient_msg = $('#addrecipient_msg');

        // forms
        let addrecipient_firstname = $('#addrecipient_firstname').val();
        let addrecipient_lastname = $('#addrecipient_lastname').val();
        let addrecipient_phonenumber = $('#addrecipient_phonenumber').val();
        let addrecipient_phonenumber_two = $('#addrecipient_phonenumber_two').val();
        let addrecipient_state = $('#addrecipient_state').val();
        let addrecipient_area = $('#addrecipient_area').val();
        let addrecipient_address = $('#addrecipient_address').val();

        let data = {
            firstname: addrecipient_firstname,
            lastname: addrecipient_lastname,
            phonenumber: addrecipient_phonenumber,
            phonenumber_two: addrecipient_phonenumber_two,
            state_id: addrecipient_state,
            area_id: addrecipient_area,
            address: addrecipient_address
        };

        // send request
      axios.post('/api/recipient/add', {
         data
      })
      .then(async function (response) {
        // console.log(response.data);
        if(response.data.success) {
            let user_id = response.data.user.id;
            let fullname = response.data.user.firstname + " " + response.data.user.lastname;

            // update select
            recipient.append("<option selected value='" + user_id + "'>" + fullname + "</option>");

            await getRecipient(user_id);

            $('#addrecipient_close').click();

            swal("Success!", "Recipient added!", "success");

            // update shipping
            let area = getArea(addrecipient_area).then(data => {
                    // console.log(data[0]['shipping_fee']);
                    // update shipping cost
                    $('#total_text').text(data[0]['shipping_fee']);
                    $('#fee_text').text(data[0]['shipping_fee']);
                });

        } else {
            addrecipient_msg.html(response.data);
        }
        
      })
      .catch(function (error) {
        console.log(error);
      });

     // console.log(data);

    });


    $('#editrecipient').on('click', function() {
        // get user
        let recipient_id = recipient.val();

        let editrecipient_firstname = $('#editrecipient_firstname');
        let editrecipient_lastname = $('#editrecipient_lastname');
        let editrecipient_phonenumber = $('#editrecipient_phonenumber');
        let editrecipient_phonenumber_two = $('#editrecipient_phonenumber_two');
        let editrecipient_state = $('#editrecipient_state');
        let editrecipient_area = $('#editrecipient_area');
        let editrecipient_address = $('#editrecipient_address');

        axios.get('/api/recipient?id=' + recipient_id)
              .then(function(response) {
                let data = response.data;
                
                // set data
                editrecipient_firstname.val(data.firstname);
                editrecipient_lastname.val(data.lastname);
                editrecipient_phonenumber.val(data.phonenumber);
                editrecipient_phonenumber_two.val(data.phonenumber_two);
                editrecipient_address.val(data.address);

                 axios.get('/api/state?state_id=' + data.state_id)
                 .then(function(response) {
                   // console.log(response.data);

                    editrecipient_state.append("<option selected value='" + response.data[0]['id'] + "'>" + response.data[0]['title'] + "</option>");

                 }).catch(function(err) {
                    console.log(err);
                 });

                 axios.get('/api/area?area_id=' + data.area_id)
                 .then(function(response) {

                    // console.log(response.data);
                    // $('#addrecipient_area').html(response.data);
                    editrecipient_area.append("<option selected value='" + response.data[0]['id'] + "'>" + response.data[0]['title'] + "</option>");

                 }).catch(function(err) {
                    console.log(err);
                });

                editrecipient_phonenumber_two.val(data.phonenumber_two);
                editrecipient_phonenumber.val(data.phonenumber);


                // console.log(data);

              })
              .catch(function(err) {
                console.log(err);
              });

    });


    $('#editrecipient_save').on('click', async function() {
        let editrecipient_msg = $('#editrecipient_msg');

        // forms
        let editrecipient_firstname = $('#editrecipient_firstname').val();
        let editrecipient_lastname = $('#editrecipient_lastname').val();
        let editrecipient_phonenumber = $('#editrecipient_phonenumber').val();
        let editrecipient_phonenumber_two = $('#editrecipient_phonenumber_two').val();
        let editrecipient_state = $('#editrecipient_state').val();
        let editrecipient_area = $('#editrecipient_area').val();
        let editrecipient_address = $('#editrecipient_address').val();

        let data = {
            id: recipient.val(),
            firstname: editrecipient_firstname,
            lastname: editrecipient_lastname,
            phonenumber: editrecipient_phonenumber,
            phonenumber_two: editrecipient_phonenumber_two,
            state_id: editrecipient_state,
            area_id: editrecipient_area,
            address: editrecipient_address
        };

        // send request
      axios.post('/api/recipient/edit', {
         data
      })
      .then(async function (response) {
        // console.log(response.data);
        if(response.data.success) {
            let user_id = response.data.user.id;
            let fullname = response.data.user.firstname + " " + response.data.user.lastname;

            // update select
            recipient.append("<option selected value='" + user_id + "'>" + fullname + "</option>");

            await getRecipient(user_id);

            $('#editrecipient_close').click();

            swal("Success!", "Recipient modified!", "success");

            // update shipping
            let area = getArea(editrecipient_area).then(data => {
                    // console.log(data[0]['shipping_fee']);
                    // update shipping cost
                    $('#total_text').text(data[0]['shipping_fee']);
                    $('#fee_text').text(data[0]['shipping_fee']);
                });

        } else {
            editrecipient_msg.html(response.data);
        }
        
      })
      .catch(function (error) {
        console.log(error);
      });

     // console.log(data);

    });

    // $('#packages').append(content);

    

    function deleteItem(e) {
         $('#package' + e).remove();
    }

    let c = 1;

    function addItem(e) {

          c += 1;
          // console.log(c);

          let num = c;

          let content = `
                                    <div class="form-row align-items-center" id="package${num}">
                                        <div class="col-sm-4">
                                          <label class="" for="inlineFormInput">Item name</label>
                                          <input type="text" class="form-control mb-2 packages_item_name" id="package${num}_item_name" placeholder="" name="packages_item_name[]">
                                        </div>

                                        <div class="col-sm-2">
                                          <label class="" for="inlineFormInput">Unit Price</label>
                                          <input type="number" class="form-control mb-2 unit-price packages_item_unit_price" onkeyup="total_price(${num})" placeholder="0" value="" id="package${num}_item_unit_price" name="packages_item_unit_price[]">
                                        </div>

                                        <div class="col-sm-2">
                                          <label class="" for="inlineFormInput">Qty</label>
                                          <input type="number" class="form-control mb-2 qty packages_item_qty" placeholder="" onkeyup="total_price(${num})" value="1" id="package${num}_item_qty" name="packages_item_qty[]">
                                        </div>

                                        <div class="col-sm-3">
                                          <label class="" for="inlineFormInput">Total Price</label>
                                          <input type="text" readonly="" value="0.00" class="form-control mb-2 total-price packages_item_total_price" id="package${num}_item_total_price" name="packages_item_total_price[]">
                                        </div>
                                       
                                      
                                        <div class="col-sm-1">
                                          <button onclick="deleteItem(${num})" type="submit" style="margin-top: 25px;
    margin-left: -4px;" class="btn btn-sm btn-outline-danger mb-2">Delete</button>
                                        </div>
                                    </div>
                                    `;


        $('#item_card_' + e).append(content);

    }

    function total_price(id) {
        let unit_price = $('#package' + id + '_item_unit_price');
        let qty = $('#package' + id + '_item_qty');
        let total_price = $('#package' + id + '_item_total_price');

        total_price.val(unit_price.val() * qty.val());
       
    }

    $('#generate_waybill').on('click', function(e) {
        e.preventDefault();

        let form = $('#form');

        // get package names
        let packages_item_name = new Array();
        $('.packages_item_name').each(function(){
            packages_item_name.push($(this).val());
        });

        // get package unit price
        let packages_item_unit_price = new Array();
        $('.packages_item_unit_price').each(function(){
            packages_item_unit_price.push($(this).val());
        });

        // get package qty
        let packages_item_qty = new Array();
        $('.packages_item_qty').each(function(){
            packages_item_qty.push($(this).val());
        });

        // get package qty
        let packages_item_total_price = new Array();
        $('.packages_item_total_price').each(function(){
            packages_item_total_price.push($(this).val());
        });

        let data = {
            dropoffpoint: $('#dropoffpoint').val(),
            sender: $('#sender').val(),
            recipient: $('#recipient').val(),
            shipping_fee: $('#fee').val(),
            date_of_shipment: $('#date_of_shipment').val(),
            payment_method: $('#payment_method').val(),
            shipment_type: $('#shipment_type').val(),
            reference_number: $('#reference_number').val(),

            packages_item_name: packages_item_name,
            packages_item_unit_price: packages_item_unit_price,
            packages_item_qty: packages_item_qty,
            packages_item_total_price: packages_item_total_price,

            packages_weight: $('#packages_weight').val(),

            date: new Date()
        };

        // send request
        axios.post('/api/waybill/generate', {
            data
        })
        .then(function (response) {
            let data = response.data;

            if(data.code == 400) {

                Swal.fire({
                      title: '<strong>You\'ve got errors</strong>',
                      type: 'error',
                      html:
                        data.message,
                      showCloseButton: true,
                      showCancelButton: false,
                      focusConfirm: false,
                });
            } else if(data.code == 200) {
                Swal.fire({
                      title: '<strong>Waybill has been generated</strong>',
                      type: 'success',
                      html:
                        data.message,
                      showCloseButton: true,
                      showCancelButton: false,
                      focusConfirm: false,
                      
                });

                setTimeout(function() {
                    location.reload();
                }, 5000);
                
            } else {
                //
            }

            console.log(response.data);
        });

    });

</script>

@endsection