@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">View Subscription Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Plan Name </h5>
                                        <p>{{ $partner->plan_name }} </p>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Plan Price </h5>
                                        <p>{{ $partner->amount }} </p>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Plan Description </h5>
                                        <p>{!! $partner->description !!} </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Days </h5>
                                        <p>{{ $partner->days}} </p>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">

                                <br>
                                <a href="{{route('subscriptionlist')}}" class="button primary">Back</a>
                            </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection