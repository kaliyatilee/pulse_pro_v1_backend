@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 col-xxl-12">
            <div class="row">
            <div class="col-sm-4">
                    <div class="card avtivity-card">
                        <div class="card-body">
                            <div class="media align-items-center">
											<span class="activity-icon bgl-warning  mr-md-4 mr-3">
                                            <i class="flaticon-381-gift"></i>
											</span>
                                <div class="media-body">
                                    <p class="fs-14 mb-2">Total Stock</p>
                                    <span class="title text-black font-w600">{{ $data['tstock'] }}</span>
                                </div>
                            </div>
                            <div class="progress" style="height:5px;">
                                <div class="progress-bar bg-danger" style="width: 42%; height:5px;" role="progressbar">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="effect bg-danger"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card avtivity-card">
                        <div class="card-body">
                            <div class="media align-items-center">
											<span class="activity-icon bgl-warning  mr-md-4 mr-3">
                                            <i class="fas fa-money-bill-alt"></i>
											</span>
                                <div class="media-body">
                                    <p class="fs-14 mb-2">Coins Redeemed</p>
                                    <span class="title text-black font-w600">{{$data['coinsreddmed']}}</span>
                                </div>
                            </div>
                            <div class="progress" style="height:5px;">
                                <div class="progress-bar bg-warning" style="width: 42%; height:5px;" role="progressbar">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="effect bg-warning"></div>
                    </div>
                </div>
              
                <div class="col-sm-4">
                    <div class="card avtivity-card">
                        <div class="card-body">
                            <div class="media align-items-center">
											<span class="activity-icon bgl-warning  mr-md-4 mr-3">
												
                                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M1.64826 26.5285C0.547125 26.7394 -0.174308 27.8026 0.0366371 28.9038C0.222269 29.8741 1.07449 30.5491 2.02796 30.5491C2.15453 30.5491 2.28531 30.5364 2.41188 30.5112L10.7653 28.908C11.242 28.8152 11.6682 28.5578 11.9719 28.1781L15.558 23.6554L14.3599 23.0437C13.4739 22.5965 12.8579 21.7865 12.6469 20.8035L9.26338 25.0688L1.64826 26.5285Z" fill="#FFBC11"/>
													<path d="M31.3999 8.89345C33.8558 8.89345 35.8467 6.90258 35.8467 4.44673C35.8467 1.99087 33.8558 0 31.3999 0C28.9441 0 26.9532 1.99087 26.9532 4.44673C26.9532 6.90258 28.9441 8.89345 31.3999 8.89345Z" fill="#FFBC11"/>
													<path d="M21.6965 3.33297C21.2282 2.85202 20.7937 2.66217 20.3169 2.66217C20.1439 2.66217 19.971 2.68748 19.7853 2.72967L12.1534 4.53958C11.0986 4.78849 10.4489 5.84744 10.6979 6.89795C10.913 7.80079 11.7146 8.40831 12.6048 8.40831C12.7567 8.40831 12.9086 8.39144 13.0605 8.35347L19.5618 6.81357C19.9837 7.28187 22.0974 9.57273 22.4813 9.97775C19.7938 12.855 17.1064 15.7281 14.4189 18.6054C14.3767 18.6519 14.3388 18.6982 14.3008 18.7446C13.5161 19.7445 13.7566 21.3139 14.9379 21.9088L23.1774 26.1151L18.8994 33.0467C18.313 34.0002 18.6083 35.249 19.5618 35.8396C19.8951 36.0464 20.2621 36.1434 20.6249 36.1434C21.3042 36.1434 21.9707 35.8017 22.3547 35.1815L27.7886 26.3766C28.0882 25.8915 28.1683 25.305 28.0122 24.7608C27.8561 24.2123 27.4806 23.7567 26.9702 23.4993L21.3885 20.66L27.2571 14.3823L31.6869 18.1371C32.0539 18.4493 32.5054 18.6012 32.9526 18.6012C33.4335 18.6012 33.9145 18.424 34.2899 18.078L39.3737 13.3402C40.1669 12.6019 40.2133 11.3615 39.475 10.5684C39.0868 10.1549 38.5637 9.944 38.0406 9.944C37.5638 9.944 37.0829 10.117 36.7074 10.4671L32.9019 14.0068C32.8977 14.011 23.363 5.04163 21.6965 3.33297Z" fill="#FFBC11"/>
												</svg>
											</span>
                                <div class="media-body">
                                    <p class="fs-14 mb-2">Trending Products</p>
                                    <span class="title text-black font-w600">{{$data['trendingproduct']}}</span>
                                </div>
                            </div>
                            <div class="progress" style="height:5px;">
                                <div class="progress-bar bg-warning" style="width: 42%; height:5px;" role="progressbar">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="effect bg-warning"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card avtivity-card">
                        <div class="card-body">
                            <div class="media align-items-center">
											<span class="activity-icon bgl-success mr-md-4 mr-3">
                                            <i class="fas fa-hand-holding-usd"></i>
											</span>
                                <div class="media-body">
                                    <p class="fs-14 mb-2">Total Revenue</p>
                                    <span class="title text-black font-w600">{{$data['totalrevenue']}}</span>
                                </div>
                            </div>
                            <div class="progress" style="height:5px;">
                                <div class="progress-bar bg-success" style="width: 42%; height:5px;" role="progressbar">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="effect bg-success"></div>
                    </div>
                </div>


             
                
               
               
             
            </div>
        </div>
        <div class="col-xl-6 col-xxl-12">
        <div class="card">
                
                    <div class="mr-auto pr-3 mb-sm-0 mb-3">
                        <h4 class="text-black fs-20">Product List</h4>
                      
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Product Status</th>
                                    <th>Action</th>
                                   

                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><img style="width: 50px;" src="{{$product->productimage}}"></td>
                                    <td>{{ $product->reward_name }}</td>
                                    <td>{{ ucwords(strtolower($product->status)) }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('editproduct', ['id' => $product->id]) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil-square-o"></i></a>
                                            <a href="{{ route('viewproduct', ['id' => $product->id]) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-eye"></i></a>&nbsp;
                                        </div>
                                    </td>
                                    
                                </tr>
                            @endforeach
                            </tbody>
                         </table>
                    </div>
                </div>
                    
                
                
            </div>
        </div>
        
       

       
    </div>
</div>
@endsection