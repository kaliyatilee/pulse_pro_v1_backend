@extends('layouts.partner')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Reward Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="post" enctype="multipart/form-data" action="{{route('create_rewards')}}">
                                @csrf
                                <input type="hidden" name="partner_id" value="{{Auth::user()->partner_id}}">
                           
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Product</label>
                                            <input name="reward_name" type="text" class="form-control input-default "
                                                   placeholder="name of product">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cost</label>
                                            <input name="pulse_points" type="number" class="form-control input-default "
                                                   placeholder="cost in pulse coins">
                                        </div>
                                    </div>

                                </div>
                            
                            

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Short Description</label>
                                            <input name="description" type="text" class="form-control input-default "
                                                   placeholder="Description">
                                        </div>
                                    </div>

                                   

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Upload Reward Image</label>
                                        <div class="form-group">
                                            <input name="imageurl" type="file" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection