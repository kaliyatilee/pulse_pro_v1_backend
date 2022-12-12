@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-12">
          
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Members</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="memberReport" class="display min-w850">
                            <thead>
                                <tr>
                                    {{-- <th></th> --}}
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>DOB</th>
                                    <th>Height</th>
                                    <th>Weight</th>
                                    <th>BMI</th>
                                    <th>Joining Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                @if($member->role !== 'admin')
                                    <tr>
                                        {{-- <td>
                                            <img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt="">
                                        </td> --}}
                                        <td>{{$member->id}}</td>
                                        <td>{{$member->firstname}} {{$member->lastname}}</td>
                                        <td>{{$member->role}}</td>
                                        <td>{{$member->gender}}</td>
                                        <td>{{$member->email}}</td>
                                        <td>{{$member->dob}}</td>
                                         <td>{{$member->height}}</td>
                                        <td>{{$member->weight}}</td>
                                        <td>{{$member->bmi}}</td>
                                        <td>{{\Carbon\Carbon::parse($member->created_at)->format('d M Y')}}</td>
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
@endsection