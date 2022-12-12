@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form>
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default" placeholder="ProductName">
                            </div>
                         </div>
                        
                        </div>

                        <div class="row">
                        
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Price">
                            </div>
                         </div>
                        </div>

                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Description">
                            </div>
                         </div>
                        
                         <!-- <div class="col-md-6">
                         <div class="form-group">
                                <input type="number" class="form-control input-default " placeholder="Category">
                            </div>
                         </div> -->
                        
                        </div>
                        <div class="row">
                         <div class="col-md-6">
                         <label>Upload ProductImage</label>
                         <div class="form-group">
                                <input type="file" class="form-control input-default " placeholder="ProductImage">
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