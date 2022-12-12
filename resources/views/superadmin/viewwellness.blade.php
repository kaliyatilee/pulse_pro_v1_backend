@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">View Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Name </h5>
                                        <p>{{ $user->name }} </p>
                                        
                                    </div>
                                </div>
                            </div>


                            @if(isset($plan_dataa))
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Plan </h5>
                                        <p>{{ $plan_dataa->plan_name ? $plan_dataa->plan_name : '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Steps </h5>
                                        <p>{{ $plan_dataa->steps ? $plan_dataa->steps : '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Daily Distance </h5>
                                        <p>{{ $plan_dataa->daily_distance ? $plan_dataa->daily_distance : '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Calories Burnt </h5>
                                        <p>{{ $plan_dataa->calories_burnt ? $plan_dataa->calories_burnt : '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Frequency of activity </h5>
                                        <p>{{ $plan_dataa->frequency_of_activity ? $plan_dataa->frequency_of_activity : '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Daily calorie intake </h5>
                                        <p>{{ $plan_dataa->daily_calorie_intake ? $plan_dataa->daily_calorie_intake : '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Daily Reminder </h5>
                                        <p>{{ $plan_dataa->daily_reminder ? $plan_dataa->daily_reminder : '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Duration of exercise </h5>
                                        <p>{{ $plan_dataa->duration_of_exercise ? $plan_dataa->duration_of_exercise : '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Participation in rigorous school sport </h5>
                                        <p>{{ $plan_dataa->participation_in_rigorous_school_sport ? $plan_dataa->participation_in_rigorous_school_sport : '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Recommended Calorie deficit </h5>
                                        <p>{{ $plan_dataa->recommended_calorie_deficit ? $plan_dataa->recommended_calorie_deficit : '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <h5 class="form-label">Description overall</h5>
                                        <p>{!! $plan_dataa->description !!}</p>
                                    </div>
                                </div>
                            </div>
                            @endif


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection