@extends('layouts.datatable')
@section('content')
<div class="container-fluid">

            <div class="card-header">
                <h4 class="card-title">Pulse Rewards</h4>
            </div>
        <div class="row">
        @foreach($rewards as $reward)
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
          
            <div class="card">
                <div class="card-body">
                    <div class="new-arrival-product">
                        <div class="new-arrivals-img-contnent">
                        @if($reward->imageurl)
                                    <img class="img-fluid" src="{{$reward->imageurl}}"
                                         alt="">
                                @else
                                    <img class="img-fluid" src="{{ env('APP_URL') }}assets/admin/images/product/1.jpg" alt="">
                                @endif

                        </div>
                      <hr>
                        <div class="new-arrival-content text-center mt-3">
                                <h4 class="nav-text">Name : {{$reward->reward_name}}</h4>
                                <h4 class="nav-text">Price : {{$reward->pulse_points}}</h4>
                                <h4 class="nav-text">Description : {{$reward->description}}</h4>
                            <hr>
                                 <div class="row text-center">
                                   <div class="col-md-6">
                                   <a href="#" class="btn btn-success shadow btn-md sharp mr-1"><i
                                                                class="fa fa-edit" ></i></a>
                                   </div>
                                  
                                 <div class="col-md-6">
                                   <a href="#" class="btn btn-danger shadow btn-md sharp mr-1"><i
                                                                class="fa fa-trash" ></i></a>
                                 </div>
                                  </div>
                            </div>
                    </div>
                </div>
            </div>
           
        </div>
        @endforeach
    </div>
        </div>
   
</div>
</div>
@endsection