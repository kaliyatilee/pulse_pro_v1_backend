@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Users List</h4>
                    <a href="{{route('adduser')}}"  class="btn btn-primary">Add User</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>User Role</th>
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
                                    <td>
                                        <div class="d-flex">
                                        <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-pencil"></i></a>
                                            <div class="modal fade" id="exampleModalCenter">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit UserRole</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <div class="card-body">
                    <div class="basic-form">
                    <form>
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Username">
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Email">
                            </div>
                         </div>
                        </div>

                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                         <label>Current Role</label>
                                  <input type="text" class="form-control input-default " placeholder="Email" value="Manager">  
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                              <label>Assign Role</label>
                               <select class="form-control default-select" id="sel1" >
                               <option>Admin</option>
                               <option>Manager</option>
                               <option>Client</option>
                               </select>
                            </div>
                         </div>
                        
                        </div>
                    
                        </form>
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