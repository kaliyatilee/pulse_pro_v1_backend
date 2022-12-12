@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Redeemed Rewards</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="partner_id" value="{{Auth::user()->partner_id}}">
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                             <label>Email</label>
                                <input type="text" name="email" id="email" class="form-control input-default " >
                            </div>
                         </div>
                        
                        </div>

                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                             <label>Redeem code</label>
                                <input type="text" name="redeem_code" id="redeem_code" class="form-control input-default " >
                            </div>
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