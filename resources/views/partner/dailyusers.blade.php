@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daily User List</h4>
                   
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                   <th></th>
                                    <th>Membership Number</th>
                                    <th>BMI</th>
                                    <th>Gender</th>
                                     <th>DateOfBith</th>
                                    <th>Height</th>
                                    <th>Weight</th>
                                    <th>LoyaltyPoints</th>
                                    <th>Date Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dailyusers as $user)
                                <tr>
                                <tr>
                                    <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                    <td>{{$user->membership_number}}</td>
                                    <td>{{$user->bmi}}</td>
                                    <td>{{$user->gender}}</td>
                                    <td>{{$user->dob}}</td>
                                    <td>{{$user->height}}</td>
                                    <td>{{$user->weight}}</td>
                                    <td>{{round($user->loyalpoints,2)}}</td>
                                    <td>{{\Carbon\Carbon::parse($user->created_at)->format('d/m/Y')}}</td>
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