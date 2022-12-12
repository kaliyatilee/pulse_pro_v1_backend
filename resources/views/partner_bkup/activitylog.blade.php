@extends('layouts.partner')
@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">ActivityLog</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th class="width80">#</th>
                                    <th>ID </th>
                                    <th>Time</th>
                                    <th>User</th>
                                    <th>Description</th>
                                    <th>Method</th>
                                    <th>Route</th>
                                     <th>IP Address</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
   
    </div>
</div>
@endsection