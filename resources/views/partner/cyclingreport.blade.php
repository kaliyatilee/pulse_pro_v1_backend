@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Activity Log</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Date</th>
                                    <th>Distance</th>
                                    <th>Duration</th>
                                    <th>AverageHeartRate</th>
                                    <th>Kcals</th>
                                   
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