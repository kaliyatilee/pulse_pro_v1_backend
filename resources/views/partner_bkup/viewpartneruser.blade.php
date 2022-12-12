@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">View User Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Name </h5>
                                        <p>{{ $corpouser->name }} </p>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Email </h5>
                                        <p>{{ $corpouser->email }} </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Phone </h5>
                                        <p>{{ $corpouser->phone}} </p>
                                    </div>
                                </div>
                            </div> <br>
                            <a href="{{route('corpouserslist')}}" class="button primary">Back</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection