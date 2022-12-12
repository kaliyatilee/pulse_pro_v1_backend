@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">View Feed Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Category </h5>
                                        <p>{{ $corpouser->category }} </p>
                                        
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Headline </h5>
                                        <p>{{ $corpouser->headline }} </p>
                                    </div>
                                </div> --}}

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5 class="form-label">Description </h5>
                                        <p>{{ $corpouser->post}} </p>
                                    </div>
                                </div>
                            </div>
                            
                            
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Type </h5>
                                        <p>{{ $corpouser->type }} </p>
                                    </div>
                                </div>

                            </div> --}}
                            
                            
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5 class="form-label">Image</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="uploadedimg me-3 mb-2" id="image_preview">
                                                <a target="_blank" href="{{$corpouser->imageurl}}">
                                                    <img style="width: 400px;" src="{{$corpouser->imageurl}}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            <br>
                            <a href="{{route('corpouserslist')}}" class="button primary">Back</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection