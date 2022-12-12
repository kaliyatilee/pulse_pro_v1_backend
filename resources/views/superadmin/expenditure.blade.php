@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Expenditure Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form>
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Expenditure Item">
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Amount">
                            </div>
                         </div>
                        </div>
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                             <label for="">Purpose</label>
                                <textarea type="text" class="form-control input-default ">
                                </textarea>   
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                         <label for="">Paid To</label>
                                <input type="text" class="form-control input-default" >
                            </div>
                         </div>
                        </div>
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                         <label>Description</label>
                                <textarea type="text" class="form-control input-default " >
                                </textarea>   
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                             <label for="">Quantity</label>
                                <input type="number" class="form-control input-default">
                            </div>
                         </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                         <div class="form-group">
                            <label>Date</label>
                                <input type="date" class="form-control input-default "  >
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                            <label>Upload file</label>
                                <input type="file" class="form-control input-default " >
                            </div>
                         </div>
                        
                        </div>
                      
                        <button type="submit" class="btn btn-primary">Submit</button>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection