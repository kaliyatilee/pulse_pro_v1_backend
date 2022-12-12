@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Subscribed Users</h4>
                </div>

                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                        @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>User Role</th>
                                    <th>Plan Name</th>
                                    <th>Period Start</th>
                                    <th>Period End</th>
                                    <th>Number of Licence</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($subscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->uname }}</td>
                                    <td>{{ $subscription->phne }}</td>
                                    <td>{{ $subscription->eml }}</td>
                                    <td>{{ $subscription->urole }}</td>
                                    <td>{{ $subscription->plan_name }}</td>
                                    <td>{{ $subscription->current_period_start }}</td>
                                    <td>{{ $subscription->current_period_end }}</td>
                                    <td>{{ $subscription->numlicence }}</td>
                                    <td>

                                    {{ number_format($subscription->numlicence *  $subscription->amount) }}
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