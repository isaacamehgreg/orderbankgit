@extends('app')
@section('title', 'My Profile')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            @include('messages')
            <h5 class="card-header">Update Your Account (KYC)</h5>
            <div class="card-body">
                <div class="">
                    <form action="/profile/update_account" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Your First Name:</label>
                                <br>
                                <input name="firstname" class="form-control" value="{{ $profile->firstname }}" />
                            </div>

                            <div class="col-sm-6">
                                <label>Your Last Name:</label>
                                <br>
                                <input name="lastname" class="form-control" value="{{ $profile->lastname }}" />
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <label>Your Active E-mail Address:</label>
                                <input name="email_address" class="form-control" value="{{ $profile->email_address }}" />
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <label>Your Phone number:</label>
                                <input name="phone_number" class="form-control" value="{{ $profile->business_phone_number }}" />
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <label>Your Address (Optional):</label>
                                <input name="address" class="form-control" value="{{ $profile->address }}" />
                            </div>
                            <div class="col-sm-12">
                                <br>
                                <button class="btn btn-block btn-primary">Update Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if(auth()->user()->role == 1)
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Withdrawal Settings</h5>
            <div class="card-body">
                    <form action="/profile/update-account-info" method="post">
                        @csrf
                        @include('messages')

                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="banks">Bank</label>
                                <select id="banks" name="bank_code" class="form-control">
                                    @foreach ($banks as $code => $details)
                                        @if ($bank_info != null && $bank_info->bank_code == $code)
                                            <option value="{{$code}}" selected>{{$details['name']}}</option>
                                        @else
                                            <option value="{{$code}}">{{$details['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 form-group">
                                <label>Account Number</label>
                                <div class="input-group">
                                    <input name="account_number"
                                           value="{{($bank_info != null) ? $bank_info->nuban : ''}}"
                                           id="nuban" class="form-control"
                                    />
                                    <div class="input-group-append">
                                        <button type="button" id="resolve-account" class="btn btn-info">Resolve Account</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 form-group">
                                <label for="account-name">Bank Account Name</label>
                                <input name="account_name"
                                       value="{{$bank_info != null ? $bank_info->account_name : ''}}"
                                       id="account-name" class="form-control"
                                />
                            </div>
                            <div class="col-sm-12 form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
    @endif
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Change Password</h5>
            <div class="card-body">
                <div class="">
                    <form action="/profile/change_password" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Current Password</label>
                                <input type="password" name="current_password" placeholder="Enter current password"
                                       class="form-control"/>
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <label>New Password</label>
                                <input type="password" name="new_password" placeholder="Enter new password"
                                       class="form-control"/>
                            </div>

                            <div class="col-sm-12">
                                <br>
                                <button class="btn btn-block btn-secondary">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 @endsection

@section('scripts')
    <script>
        $('#resolve-account').on('click', () => {
            document.querySelector("#resolve-account").innerHTML = "Please wait...";
            let nuban = document.getElementById("nuban").value,
                banks = document.getElementById("banks"),
                bank_code = banks.options[banks.selectedIndex].value,
                account_name = document.getElementById("account-name");

            if (nuban === "" || bank_code === "") {
                return;
            }

            $.ajax({
                url: `/withdrawals/get-bank-info`,
                method: "POST",
                data: {
                    'nuban': nuban,
                    'bank_code': bank_code
                },
                success: function(data) {
                    if (!data.success) {
                        swal('Error occurred', data.message, 'error');
                        document.querySelector("#resolve-account").innerHTML = "Resolve Account";
                        return;
                    }
                    account_name.value = data.data.account_name;
                    account_name.setAttribute("disabled", "disabled");
                    console.log(account_name);
                    console.log(account_name.value);
                },
                error: function(err) {
                    swal("Error", "Could not complete request", error);
                },
                done: function() {
                    document.querySelector("#resolve-account").innerHTML = "Resolve Account";
                }
            })
        });
    </script>
@endsection
