@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daily Step Count</h4>
                   
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                   <th></th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Gender</th>
                                    <th>Steps Count</th>
                                    <th>Distance Covered</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($step_count as $steps)
                                <tr>
                                    <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                    <td>{{$steps->firstname}}</td>
                                    <td>{{$steps->lastname}}</td>
                                    <td>{{$steps->gender}}</td>
                                    <td>{{$steps->steps}}</td>
                                    <td>{{$steps->distance}}</td>
                                  
                                    <td>{{\Carbon\Carbon::parse($steps->created_at)->format('d/m/Y')}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1" data-toggle="modal" data-target="#exampleModalCenter{{$steps->id}}"><i class="fa fa-edit"></i></a>
                                            <div class="modal fade" id="exampleModalCenter{{$steps->id}}">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit MemberDetails</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card-body">
                                                                <div class="basic-form">
                                                                    <form method="post" action="{{route
                                                                        ('update_member', $steps->id)}}">
                                                                        @csrf
                                                                        <input type="hidden" name="member_id" value="{{$steps->id}}">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="firstname" type="text" class="form-control input-default " placeholder="Firstname" value="{{$steps->firstname}}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="lastname" type="text" class="form-control input-default " placeholder="Lastname" value="{{$steps->lastname}}">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="email" type="text" class="form-control input-default " placeholder="Email" value="{{$steps->email}}">
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
                                                                                    <input name="weight" type="number" class="form-control input-default " placeholder="Weight in kgs" value="{{$steps->weight}}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="height" type="number" class="form-control input-default " placeholder="Height in cm" value="{{$steps->height}}">
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
                                            <a href="{{route('memberprofile')}}" class="btn
                                              btn-danger
                                           shadow
                                           btn-xs
                                           sharp"><i class="fa
                                           fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

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