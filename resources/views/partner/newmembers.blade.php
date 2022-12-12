@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Members List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Membership Number</th>
                                    <th>BMI</th>
                                    <th>Date Of Birth</th>
                                    <th>Gender</th>
                                    <th>Joining Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newMembers as $member)
                                    <tr>
                                        <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                        <td>{{$member->membership_number}}</td>
                                        <td>{{$member->bmi}}</td>
                                        <td>{{$member->dob}}</td>
                                        <td>{{$member->gender}}</td>
                                        <td>{{\Carbon\Carbon::parse($member->created_at)->format('d/m/Y')}}</td>
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