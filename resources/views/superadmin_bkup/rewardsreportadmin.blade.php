@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Rewards list</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rewardsReport" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>Reward Name</th>
                                    <th>Description</th>
                                    <th>Pulse Points</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                   @foreach($rewards as $reward)
                                <tr>
                                
                                  
                                   
                                    <td>{{$reward->reward_name}}</td>
                                    <td>{{$reward->description}}</td>
                                    <td>{{$reward->pulse_points}} </td>
                                    <td>100</td>
                                    <td>{{$reward->created_at}}</td>
                                  
                                    {{-- <td>
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td> --}}
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