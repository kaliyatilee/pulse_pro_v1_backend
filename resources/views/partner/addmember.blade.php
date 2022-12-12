@extends('layouts.partner')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Member Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="post" action="{{route('create_member')}}">
                                @csrf
                                <input type="hidden" name="partner_id" value="{{Auth::user()->partner_id}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="firstname" type="text" class="form-control input-default " placeholder="Firstname" value="{{old('firstname')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="lastname" type="text" class="form-control input-default " placeholder="Lastname">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control input-default " placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="phone" type="text" class="form-control input-default " placeholder="Enter phone number starting with country code">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Date Of Birth</label>
                                            <input name="dob" type="date" class="form-control input-default" style="max-height: 45px">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Membership Number</label>
                                            <input name="membership_number" type="text" class="form-control input-default" style="max-height: 45px">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select name="gender" class="form-control default-select" id="sel1" >
                                                <option value="male" selected>Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="weight" type="number" class="form-control input-default " placeholder="Weight in kgs">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="height" type="number" class="form-control input-default " placeholder="Height in cm">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control input-default " placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="password_confirmation" type="password" class="form-control input-default " placeholder="Confirm Password">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        @if (session('success_message'))
        swal({
            title: "Success",
            text: "{{Session::get('success_message')}}",
            dangerMode: false,
            icon: "success",
        })
        @endif
    </script>
@endsection