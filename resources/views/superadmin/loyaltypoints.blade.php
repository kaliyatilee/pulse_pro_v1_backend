@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manage LoyaltyPoints</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Partnername</th>
                                    <th>Points Gained</th>
                                    <th>Points Redeemed</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-pencil-square-o"></i></a>
                                            <div class="modal fade" id="exampleModalCenter">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Manage Points</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card-body">
                                                                <div class="basic-form">
                                                                    <form method="post" action="">
                                                                        @csrf
                                                                        <input type="hidden" name="member_id" value="">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="firstname" type="text" class="form-control input-default " placeholder="Firstname" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="lastname" type="text" class="form-control input-default " placeholder="Lastname" value="">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="email" type="text" class="form-control input-default " placeholder="Email" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Gender</label>
                                                                                    <select class="form-control>
                                                                                       default-select" id="sel1" name="gender">
                                                                                        <option value="male">Male</option>
                                                                                        <option value="female">Female</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="weight" type="number" class="form-control input-default " placeholder="Weight in kgs" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="height" type="number" class="form-control input-default " placeholder="Height in cm" value="">
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
                                                                        <div class="modal-footer"> <button type="button" class="btn btn-danger light" data-dismiss="modal">Close
                                                                            </button>
                                                                            <button type="submit" class="btn btn-primary">Save
                                                                                changes
                                                                            </button>
                                                                        </div>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <a href="" class="btn
                                              btn-danger
                                           shadow
                                           btn-xs
                                           sharp"><i class="fa
                                           fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection