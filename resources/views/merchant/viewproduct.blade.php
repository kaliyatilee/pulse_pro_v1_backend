@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">View Product Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Product Name </h5>
                                        <p>{{ $product->reward_name }} </p>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Product Description </h5>
                                        <p>{{ $product->description }} </p>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h5 class="form-label">Product Amount </h5>
                                        <p>{{ $product->amount }} </p>
                                       
                                    </div>
                                </div>
                            </div>

                         
                            
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5 class="form-label">Product Image</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="uploadedimg me-3 mb-2" id="image_preview">
                                                <a target="_blank" href="{{$product->productimage}}">
                                                    <img style="width: 400px;" src="{{$product->productimage}}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            
                                <br>
                                <a href="{{route('productlist')}}" class="button primary">Back</a>
                            </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection