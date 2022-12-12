@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Active Members List</h4>
                   
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                   <th></th>
                                    <th>Activity Name</th>
                                    <th>Calories Burnt</th>
                                    <th>Distance Covered</th>
                                    <th>Heartrate</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeMembers as $member)
                                <tr>
                                    <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                    <td>{{$member->activity}}</td>
                                    <td>{{$member->calories}}</td>
                                    <td>{{$member->distance}}</td>
                                    <td>{{$member->heartrate}}</td>
                                    <td>{{$member->created_at}}</td>
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