@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">View Partner Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Name </h5>
                                        <p>{{ $partner->name }} </p>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Partner Trading Name </h5>
                                        <p>{{ $partner->partnerTradingName }} </p>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Email </h5>
                                        <p>{{ $partner->email }} </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Phone </h5>
                                        <p>{{ $partner->phone}} </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Business Type </h5>
                                        <p>{{ $partner->businessType }} </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Partner Trading Details </h5>
                                        <p>{{ $partner->partnerTradingDetails }} </p>
                                    </div>
                                </div>

                                
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Address </h5>
                                    <p>{{ $partner->propertyNumber }} {{ $partner->streetName }} {{ $partner->suburb }} {{ $partner->country }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Bank Details </h5>
                                    <p>Bank name: {{ $partner->bankName }} <br>Account Number{{ $partner->accountNumber }} <br>Branch name: {{ $partner->branchName }} <br>Branch Code: {{ $partner->branchCode }}</p>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Director Id</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="uploadedimg me-3 mb-2" id="image_preview">
                                                <a target="_blank" href="{{asset('/public/storage/directorid/original')}}/{{$partner->directorId}}">
                                                    <img style="width: 400px;" src="{{asset('/public/storage/directorid/original')}}/{{$partner->directorId}}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">CR14 FORM</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="uploadlogo me-3">
                                                <a target="_blank" href="{{asset('/public/storage/CR14form/original')}}/{{$partner->CR14form}}">
                                                    <u>{{$partner->CR14form}}</u>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Certificate of incorporation</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="uploadlogo me-3">
                                                <a target="_blank" href="{{asset('/public/storage/certificateOfIncorporation/original')}}/{{$partner->certificateOfIncorporation}}">
                                                    <u>{{$partner->certificateOfIncorporation}}</u>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <br>
                                <a href="{{route('partnerlist')}}" class="button primary">Back</a>
                            </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection