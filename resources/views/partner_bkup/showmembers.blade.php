@extends('layouts.partner')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Members List</h4>
                    <a href="{{route('addmember')}}" class="btn btn-success">Add Member</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="memberReports" class="display min-w850">
                                <thead>
                                <tr>
                                    @if(!Auth::user()->hasRole('manager'))
                                    <th></th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    @endif
                                    <th>Membership Number</th>
                                    <th>Gender</th>
                                    <th>Weight</th>
                                    <th>Height</th>
                                    <th>BMI</th>
                                    <th>Date Of Birth</th>
                                    <th>Joining Date</th>
                                    <th>More Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($members as $member)
                                    @if($member->role !== 'admin')
                                        <tr>
                                            @if(!Auth::user()->hasRole('manager'))

                                            <td><img class="rounded-circle" width="35"
                                                     src="{{$member->image}}"
                                                     alt=""></td>
                                            <td>{{$member->firstname}}</td>
                                            <td>{{$member->lastname}}</td>
                                            @endif
                                            <td>{{$member->membership_number}}</td>
                                            <td>{{$member->gender}}</td>
                                            <td>{{$member->height}}</td>
                                            <td>{{$member->weight}}</td>
                                            <td>{{$member->bmi}}</td>
                                            <td>{{\Carbon\Carbon::parse($member->dob)->format('d/m/Y')}}</td>
                                            <td>{{\Carbon\Carbon::parse($member->created_at)->format('d/m/Y')}}</td>
                                            <td>
                                        <div class="d-flex">
                                            <a href="" class="btn btn-success shadow btn-xs sharp mr-1" data-toggle="modal" data-target="#exampleModalCenter{{$member->id}}"><i class="fa fa-edit"></i></a>
                                            <div class="modal fade" id="exampleModalCenter{{$member->id}}">
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
                                                                        ('update_member', $member->id)}}">
                                                                        @csrf
                                                                        <input type="hidden" name="member_id" value="{{$member->id}}">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="firstname" type="text" class="form-control input-default " placeholder="Firstname" value="{{$member->firstname}}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="lastname" type="text" class="form-control input-default " placeholder="Lastname" value="{{$member->lastname}}">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="email" type="text" class="form-control input-default " placeholder="Email" value="{{$member->email}}">
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
                                                                                    <input name="weight" type="number" class="form-control input-default " placeholder="Weight in kgs" value="{{$member->weight}}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input name="height" type="number" class="form-control input-default " placeholder="Height in cm" value="{{$member->height}}">
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
                                            <a href="https://www.pulse-wellness.tech/admin/memberprofile?member_id={{$member->id}}" class="btn
                                              btn-danger
                                           shadow
                                           btn-xs
                                           sharp"><i class="fa
                                           fa-eye"></i></a>
                                        </div>
                                    </td>

                                        </tr>
                                    @endif
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        let sec_color = ['{!! $partnerdata["sec_color"] !!}'];
    </script>
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