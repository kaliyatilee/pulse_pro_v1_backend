@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form>
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Firstname">
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Lastname">
                            </div>
                         </div>
                        </div>

                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Email">
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                              <label>Gender</label>
                               <select class="form-control default-select" id="sel1" >
                               <option>Male</option>
                               <option>Female</option>
                               </select>
                            </div>
                         </div>
                        
                        </div>
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="number" class="form-control input-default " placeholder="Weight in kgs">
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="number" class="form-control input-default " placeholder="Height in cm">
                            </div>
                         </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" class="form-control input-default " placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" class="form-control input-default " placeholder="Confirm Password">
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