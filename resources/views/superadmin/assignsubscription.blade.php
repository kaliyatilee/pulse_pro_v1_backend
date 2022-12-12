@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Assign Subscription</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="{{ route('saveassignsub') }}">
                            @csrf
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                            <label>User</label>
                            <select name="user_id" class="form-control default-select">
                                @foreach ($users as $user)
                                    <option value="{{ @$user->id }}">{{ @$user->name }} - {{ @$user->role }}</option>
                                @endforeach
                            </select>
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                              <label>Select Plan</label>
                               <select class="form-control default-select" name="plan_id" >
                                @foreach ($subscriptions as $subscription)
                                    <option value="{{ @$subscription->id }}">{{ @$subscription->plan_name }}</option>
                                @endforeach
                               </select>
                            </div>
                         </div>
                        
                        </div>
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="number" name="numlicence" class="form-control input-default " placeholder="Number of licence">
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="form-group">
                                   <input type="text" name="amount" class="form-control input-default " placeholder="Amount">
                               </div>
                            </div>

                        </div>

                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="date" name="current_period_start" class="form-control input-default " placeholder="Start Date">
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="date" name="current_period_end" class="form-control input-default " placeholder="End Date">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="button primary">Submit</button>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection