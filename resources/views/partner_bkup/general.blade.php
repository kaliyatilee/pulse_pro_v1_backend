@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">System Manager</h4>
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <div class="default-tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home"><i class="la la-home mr-2"></i> Company Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile"><i class="la la-envelope"></i> Email Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#contact"><i class="la la-palette mr-2"></i> Design Settings</a>
                            </li>
                            <!-- <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#message"><i class="la la-envelope mr-2"></i> Message</a>
                                        </li> -->
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="home" role="tabpanel">
                                <div class="pt-4">
                                <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
              
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="{{ route('update_partner') }}">
                            @csrf
                        <div class="row">
                            <input name="partner_id" type="hidden" value="{{ $partner_id }}">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" name="name" class="form-control input-default " placeholder="Companyname" value="{{ $partnerdata['name'] }}">
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" name="email" class="form-control input-default " placeholder="Registered Email" value="{{ $partnerdata['email'] }}">
                            </div>
                         </div>
                        </div>

                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" name="phone" class="form-control input-default " placeholder="Phone" value="{{ $partnerdata["phone"] }}">
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                             <input type="text" name="address" class="form-control input-default " placeholder="Address" value="{{ $partnerdata['address'] }}">
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
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <div class="pt-4">
                                <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
              
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="{{ route('update_partner') }}">
                            @csrf
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Registered Email" value="{{ $partnerdata['email'] }}">
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="Host">
                            </div>
                         </div>
                        </div>

                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" class="form-control input-default " placeholder="SMTP">
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                         <input type="text" class="form-control input-default " placeholder="Port">   
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
                            </div>
                            <div class="tab-pane fade" id="contact">
                                <div class="pt-4">
                                <div class="pt-4">
                                <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
              
                <div class="card-body">
                    <div class="basic-form">
                        <form>
                        <div class="row">
                         <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Primary Color</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 mb-3">
                                        <div class="example">
                                            <p class="mb-1">Simple mode</p>
                                            <input type="text" class="as_colorpicker form-control" value="{{ $partnerdata['pri_color'] }}">
                                        </div>
                                    </div>
{{--                                    <div class="col-xl-4 col-lg-6 mb-3">--}}
{{--                                        <div class="example">--}}
{{--                                            <p class="mb-1">Simple mode</p>--}}
{{--                                            <input type="text" class="as_colorpicker form-control" value="#7ab2fa">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-xl-4 col-lg-6 mb-3">--}}
{{--                                        <div class="example">--}}
{{--                                            <p class="mb-1">Complex mode</p>--}}
{{--                                            <input type="text" class="complex-colorpicker form-control" value="#fa7a7a">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-xl-4 col-lg-6 mb-3">--}}
{{--                                        <div class="example">--}}
{{--                                            <p class="mb-1">Gradiant mode</p>--}}
{{--                                            <input type="text" class="gradient-colorpicker form-control" value="#bee0ab">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                         </div>
                         <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Secondary Color</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 mb-3">
                                        <div class="example">
                                            <p class="mb-1">Simple mode</p>
                                            <input type="text" class="as_colorpicker form-control" value="{{ $partnerdata['sec_color'] }}">
                                        </div>
{{--                                        <div class="example">--}}
{{--                                            <p class="mb-1">Simple mode</p>--}}
{{--                                            <input type="text" class="as_colorpicker form-control" value="#7ab2fa">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-xl-4 col-lg-6 mb-3">--}}
{{--                                        <div class="example">--}}
{{--                                            <p class="mb-1">Complex mode</p>--}}
{{--                                            <input type="text" class="complex-colorpicker form-control" value="#fa7a7a">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-xl-4 col-lg-6 mb-3">--}}
{{--                                        <div class="example">--}}
{{--                                            <p class="mb-1">Gradiant mode</p>--}}
{{--                                            <input type="text" class="gradient-colorpicker form-control" value="#bee0ab">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                         </div>
                        </div>

                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                           <label>Logo</label> 
                           <input type="file" class="form-control input-default ">
                        </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                         <label>Logo Text</label> 
                         <input type="text" class="form-control input-default " placeholder="">   
                            </div>
                         </div>
                        
                        
                        
                             <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                     
                      
                       
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection