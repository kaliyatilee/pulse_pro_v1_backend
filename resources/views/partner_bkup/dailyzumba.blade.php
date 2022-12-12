@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Active Zumba Users List</h4>
                   
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                   <th></th>
                                    <th>Date</th>
                                    <th>Distance</th>
                                    <th>Calories</th>
                                    <th>Duration</th>
                                    <th>Heartrate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeZumba as $zumba)
                                <tr>
                                    <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                    <td>{{$zumba->created_at}}</td>
                                    <td>{{$zumba->distance}}</td>
                                    <td>{{$zumba->calories}}</td>
                                    <td>{{$zumba->duration}}</td>
                                    <td>{{$zumba->heartrate}}</td>
                                    <td>
                                         <div class="d-flex">
                                                    <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"
                                                       data-toggle="modal"
                                                       data-target="#exampleModalCenter{{$zumba->id}}"><i
                                                                class="fa fa-edit" ></i></a>
                                                 <div class="modal fade" id="exampleModalCenter{{$zumba->id}}">
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
                                                                        ('update_member', $zumba->id)}}">
                                                                        @csrf
                                                                        <input type="hidden" name="member_id" value="{{$zumba->id}}">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="firstname" type="text" class="form-control input-default " placeholder="Firstname" value="{{$zumba->firstname}}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="lastname" type="text" class="form-control input-default " placeholder="Lastname" value="{{$zumba->lastname}}">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="email" type="text" class="form-control input-default " placeholder="Email" value="{{$zumba->email}}">
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
                                                                                    <input name="weight" type="number" class="form-control input-default " placeholder="Weight in kgs" value="{{$zumba->weight}}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="height" type="number" class="form-control input-default " placeholder="Height in cm" value="{{$zumba->height}}">
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
                                            <a href="https://www.pulse-wellness.tech/admin/memberprofile?member_id={{$zumba->id}}" class="btn
                                              btn-danger
                                           shadow
                                           btn-xs
                                           sharp"><i class="fa
                                           fa-eye"></i></a>
                                        </div>
                                                    <div class="modal fade" id="exampleModalCenter{{$zumba->id}}">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit MemberDetails</h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal"><span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="basic-form">
                                                                            <form method="post" action="{{route
                                                                        ('update_member', $zumba->id)}}">
                                                                                @csrf
                                                                                <input type="hidden" name="member_id"
                                                                                       value="{{$zumba->id}}">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <input name="firstname"
                                                                                                   type="text"
                                                                                                   class="form-control input-default "
                                                                                                   placeholder="Firstname"
                                                                                                   value="{{$zumba->firstname}}">
                                                                                        </div>
                                                                                    </div>
                                                                                
                                                                                
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <input name="lastname"
                                                                                                   type="text"
                                                                                                   class="form-control input-default "
                                                                                                   placeholder="Lastname"
                                                                                                   value="{{$zumba->lastname}}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label>Gender</label>
                                                                                            <select class="form-control
                                                                                        default-select"
                                                                                                    id="sel1"
                                                                                                    name="gender">
                                                                                                @if(strtolower($zumba->gender) ==
                                                                                                "male")
                                                                                                    <option
                                                                                                            value="Male"
                                                                                                            selected
                                                                                                    >Male
                                                                                                    </option>
                                                                                                    <option
                                                                                                            value="Female"
                                                                                                    >Female
                                                                                                    </option>
                                                                                                @endif
                                                                                                @if(strtolower($zumba->gender) ==
                                                                                                "female")
                                                                                                    <option
                                                                                                            value="Male"

                                                                                                    >Male
                                                                                                    </option>
                                                                                                    <option
                                                                                                            value="Female"
                                                                                                            selected
                                                                                                    >Female
                                                                                                    </option>
                                                                                                @endif
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                            class="btn btn-danger light"
                                                                                            data-dismiss="modal">Close
                                                                                    </button>
                                                                                    <button type="submit"
                                                                                            class="btn btn-primary">Save
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