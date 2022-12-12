@extends('layouts.partner')
@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Subscribed Members </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="subscriptionsReport" class="display min-w850">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Joining Date</th>
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
                                    <td></td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"  ><i class="fa fa-pencil"></i></a>
                                            <div class="modal fade" id="exampleModalCenter">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Subscription</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h4 class="card-title">Subscriber Information</h4>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="basic-form">
                                                                        <form>
                                                                            <div class="row">
                                                                            <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                    <label>Username</label>
                                                                                        <input type="text" class="form-control input-default " placeholder="Munashe" >
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">

                                                                            <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                    <label>DateJoined</label>
                                                                                        <input type="date" class="form-control input-default " >
                                                                                    </div>
                                                                                </div>
        
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                    <label>ExpiryDate</label>
                                                                                        <input type="date" class="form-control input-default " >
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="custom-control custom-switch toggle-switch text-right mr-4 mb-2">
                                                                                    <input type="checkbox" class="custom-control-input" id="customSwitch11">
                                                                                    <label class="custom-control-label" for="customSwitch11">Active Status</label>
                                                                                </div>
                                                                            </div>

                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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