@extends('layouts.superadmin')
@section('content')
<style>
    .fs-20{margin-left:10px;}
    .active {
        color: #000!important;
        background-color: #ccc!important;
    }
    .container {
        /*width: 80%;
        margin: 15px auto;*/
        }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 col-xxl-12">
            <div class="row">
            <div class="col-sm-4">
                    <div class="card avtivity-card">
                        <div class="card-body">
                            <div class="media align-items-center">
											<span class="activity-icon bgl-secondary  mr-md-4 mr-3">
                                            <svg width="40" height="40" viewBox="0 0 40 37"   fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M30.5325 18.9448C27.7921 15.402 23.5761 13.6 18.0001 13.6C12.4241 13.6 8.2081 15.402 5.4677 18.9448C0.082099 25.908 2.8701 36.9376 2.9925 37.4C3.34508 38.8603 4.81456 39.7583 6.27486 39.4057C7.71986 39.0568 8.61712 37.6123 8.2897 36.1624C8.2897 36.0808 6.6985 27.8596 10.3297 23.3988L10.5269 23.1676V36.6588L9.1669 65.1508C9.0921 66.6164 10.1934 67.8771 11.6557 68H11.8801C13.2659 68.0095 14.4372 66.9758 14.6001 65.5996L17.5309 40.8H18.4625L21.4001 65.5996C21.563 66.9758 22.7343 68.0095 24.1201 68H24.3513C25.8136 67.8771 26.9149 66.6164 26.8401 65.1508L25.4801 36.6588V23.1744L25.6637 23.392C29.3357 27.88 27.7037 36.074 27.7037 36.176C27.3657 37.6407 28.279 39.1021 29.7437 39.44C31.2084 39.778 32.6697 38.8647 33.0077 37.4C33.1301 36.9376 35.9181 25.908 30.5325 18.9448Z" fill="#A02CFA"/>
												<path d="M18.0001 12.24C21.3801 12.24 24.1201 9.49998 24.1201 6.12C24.1201 2.74002 21.3801 0 18.0001 0C14.6201 0 11.8801 2.74002 11.8801 6.12C11.8801 9.49998 14.6201 12.24 18.0001 12.24Z" fill="#A02CFA"/>
												<mask id="mask0" maskUnits="userSpaceOnUse" x="0" y="19" width="39" height="55">
												<path d="M0 26.0017C0 24.1758 1.37483 22.6428 3.18995 22.4448L3.26935 22.4361C4.23614 22.3306 5.1115 21.8163 5.67413 21.023L6.13877 20.3679C7.48483 18.4701 10.3941 18.7986 11.2832 20.9487L11.4217 21.2836C12.2534 23.2951 14.9783 23.5955 16.2283 21.8136C17.323 20.253 19.6329 20.247 20.7357 21.8019L21.5961 23.0149C22.4113 24.1642 23.7948 24.7693 25.1921 24.5877L28.4801 24.1603C34.0567 23.4354 39 27.7777 39 33.4012V54.5C39 65.2695 30.2696 74 19.5 74C8.73045 74 0 65.2696 0 54.5V26.0017Z" fill="#A02CFA"/>
												</mask>
												<g mask="url(#mask0)">
												<path d="M30.5324 18.9448C27.792 15.402 23.576 13.6 18 13.6C12.424 13.6 8.20798 15.402 5.46758 18.9448C0.0819769 25.908 2.86998 36.9376 2.99238 37.4C3.34496 38.8603 4.81444 39.7583 6.27474 39.4057C7.71974 39.0568 8.617 37.6123 8.28958 36.1624C8.28958 36.0808 6.69838 27.8596 10.3296 23.3988L10.5268 23.1676V36.6588L9.16678 65.1508C9.09198 66.6164 10.1932 67.8771 11.6556 68H11.88C13.2658 68.0095 14.4371 66.9758 14.6 65.5996L17.5308 40.8H18.4624L21.4 65.5996C21.5628 66.9758 22.7341 68.0095 24.12 68H24.3512C25.8135 67.8771 26.9148 66.6164 26.84 65.1508L25.48 36.6588V23.1744L25.6636 23.392C29.3356 27.88 27.7036 36.074 27.7036 36.176C27.3656 37.6407 28.2789 39.1021 29.7436 39.44C31.2083 39.778 32.6696 38.8647 33.0076 37.4C33.13 36.9376 35.918 25.908 30.5324 18.9448Z" fill="#A02CFA"/>
												<path d="M17.9999 12.24C21.3799 12.24 24.12 9.49998 24.12 6.12C24.12 2.74002 21.3799 0 17.9999 0C14.62 0 11.8799 2.74002 11.8799 6.12C11.8799 9.49998 14.62 12.24 17.9999 12.24Z" fill="#A02CFA"/>
												</g>
											</svg>
											</span>
                                <div class="media-body">
                                    <p class="fs-14 mb-2">Total Active Users</p>
                                    <span class="title text-black font-w600">{{$data['activemembers']}}</span>
                                </div>
                            </div>
                            <div class="progress" style="height:5px;">
                                <div class="progress-bar bg-secondary" style="width: 82%; height:5px;" role="progressbar">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="effect bg-secondary"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card avtivity-card">
                        <div class="card-body">
                            <div class="media align-items-center">
											<span class="activity-icon bgl-success mr-md-4 mr-3">
                                            <svg width="40" height="40" viewBox="0 0 40 37" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M30.5325 18.9448C27.7921 15.402 23.5761 13.6 18.0001 13.6C12.4241 13.6 8.2081 15.402 5.4677 18.9448C0.082099 25.908 2.8701 36.9376 2.9925 37.4C3.34508 38.8603 4.81456 39.7583 6.27486 39.4057C7.71986 39.0568 8.61712 37.6123 8.2897 36.1624C8.2897 36.0808 6.6985 27.8596 10.3297 23.3988L10.5269 23.1676V36.6588L9.1669 65.1508C9.0921 66.6164 10.1934 67.8771 11.6557 68H11.8801C13.2659 68.0095 14.4372 66.9758 14.6001 65.5996L17.5309 40.8H18.4625L21.4001 65.5996C21.563 66.9758 22.7343 68.0095 24.1201 68H24.3513C25.8136 67.8771 26.9149 66.6164 26.8401 65.1508L25.4801 36.6588V23.1744L25.6637 23.392C29.3357 27.88 27.7037 36.074 27.7037 36.176C27.3657 37.6407 28.279 39.1021 29.7437 39.44C31.2084 39.778 32.6697 38.8647 33.0077 37.4C33.1301 36.9376 35.9181 25.908 30.5325 18.9448Z" fill="#8EC741"/>
												<path d="M18.0001 12.24C21.3801 12.24 24.1201 9.49998 24.1201 6.12C24.1201 2.74002 21.3801 0 18.0001 0C14.6201 0 11.8801 2.74002 11.8801 6.12C11.8801 9.49998 14.6201 12.24 18.0001 12.24Z" fill="#8EC741"/>
												<mask id="mask0" maskUnits="userSpaceOnUse" x="0" y="19" width="39" height="55">
												<path d="M0 26.0017C0 24.1758 1.37483 22.6428 3.18995 22.4448L3.26935 22.4361C4.23614 22.3306 5.1115 21.8163 5.67413 21.023L6.13877 20.3679C7.48483 18.4701 10.3941 18.7986 11.2832 20.9487L11.4217 21.2836C12.2534 23.2951 14.9783 23.5955 16.2283 21.8136C17.323 20.253 19.6329 20.247 20.7357 21.8019L21.5961 23.0149C22.4113 24.1642 23.7948 24.7693 25.1921 24.5877L28.4801 24.1603C34.0567 23.4354 39 27.7777 39 33.4012V54.5C39 65.2695 30.2696 74 19.5 74C8.73045 74 0 65.2696 0 54.5V26.0017Z" fill="#8EC741"/>
												</mask>
												<g mask="url(#mask0)">
												<path d="M30.5324 18.9448C27.792 15.402 23.576 13.6 18 13.6C12.424 13.6 8.20798 15.402 5.46758 18.9448C0.0819769 25.908 2.86998 36.9376 2.99238 37.4C3.34496 38.8603 4.81444 39.7583 6.27474 39.4057C7.71974 39.0568 8.617 37.6123 8.28958 36.1624C8.28958 36.0808 6.69838 27.8596 10.3296 23.3988L10.5268 23.1676V36.6588L9.16678 65.1508C9.09198 66.6164 10.1932 67.8771 11.6556 68H11.88C13.2658 68.0095 14.4371 66.9758 14.6 65.5996L17.5308 40.8H18.4624L21.4 65.5996C21.5628 66.9758 22.7341 68.0095 24.12 68H24.3512C25.8135 67.8771 26.9148 66.6164 26.84 65.1508L25.48 36.6588V23.1744L25.6636 23.392C29.3356 27.88 27.7036 36.074 27.7036 36.176C27.3656 37.6407 28.2789 39.1021 29.7436 39.44C31.2083 39.778 32.6696 38.8647 33.0076 37.4C33.13 36.9376 35.918 25.908 30.5324 18.9448Z" fill="#8EC741"/>
												<path d="M17.9999 12.24C21.3799 12.24 24.12 9.49998 24.12 6.12C24.12 2.74002 21.3799 0 17.9999 0C14.62 0 11.8799 2.74002 11.8799 6.12C11.8799 9.49998 14.62 12.24 17.9999 12.24Z" fill="#8EC741"/>
												</g>
											</svg>
											</span>
                                <div class="media-body">
                                    <p class="fs-14 mb-2">Total Inactive Users</p>
                                    <span class="title text-black font-w600">{{$data['inactivemembers']}}</span>
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
													<path d="M19.9996 10.0001C22.7611 10.0001 24.9997 7.76148 24.9997 5.00004C24.9997 2.23859 22.7611 0 19.9996 0C17.2382 0 14.9996 2.23859 14.9996 5.00004C14.9996 7.76148 17.2382 10.0001 19.9996 10.0001Z" fill="#ed3b8b"/>
													<path d="M29.7178 36.3838L23.5603 38.6931L26.6224 39.8414C27.9402 40.3307 29.3621 39.6527 29.8413 38.3778C30.0964 37.6976 30.021 36.9851 29.7178 36.3838Z" fill="#ed3b8b"/>
													<path d="M8.37771 27.6588C7.08745 27.1803 5.64452 27.8298 5.15873 29.1224C4.67411 30.4151 5.32967 31.8555 6.62228 32.3413L9.31945 33.3527L16.4402 30.6821L8.37771 27.6588Z" fill="#ed3b8b"/>
													<path d="M34.8413 29.1225C34.3554 27.8297 32.9126 27.1803 31.6223 27.6589L11.6223 35.1589C10.3295 35.6448 9.67401 37.0852 10.1586 38.3779C10.6378 39.6524 12.0594 40.3309 13.3776 39.8415L33.3777 32.3414C34.6705 31.8556 35.326 30.4152 34.8413 29.1225Z" fill="#ed3b8b"/>
													<path d="M37.5001 20.0001H31.5455L27.2364 11.3819C26.7886 10.4871 25.8776 9.97737 24.9388 10.0001L19.9996 10.0001L15.061 10.0001C14.1223 9.97737 13.2125 10.4872 12.7637 11.3819L8.45457 20.0001H2.49998C1.1194 20.0001 0 21.1195 0 22.5001C0 23.8807 1.1194 25.0001 2.49998 25.0001H10C10.9473 25.0001 11.8128 24.4654 12.2363 23.6183L15 18.0909V27.4724L19.9998 29.3472L25 27.4719V18.0909L27.7637 23.6183C28.1873 24.4655 29.0528 25.0001 30 25.0001H37.5C38.8806 25.0001 40 23.8807 40 22.5001C40 21.1195 38.8807 20.0001 37.5001 20.0001Z" fill="#ed3b8b"/>
												</svg>
											</span>
                                <div class="media-body">
                                    <p class="fs-14 mb-2">New Subscriber</p>
                                    <span class="title text-black font-w600">{{$data['newMembers']}}</span>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js"></script>
        <div class="col-xl-6 col-xxl-12 bg-white">
                <div class="card">
                    <div class="card-header d-sm-flex d-block pb-3 border-0">
                        <div class="mr-auto pr-3 mb-sm-0 mb-3">
                            <h4 class="text-black fs-20">Total Revenue</h4>
                            
                        </div>
                        <div class="select-box">
                            <select class="btn btn-light" onchange="opentab(this.value)">
                                <option value="Daily" class="select-box rounded">Daily</option>
                                <option value="Weekly" class="select-box rounded">Weekly</option>
                                <option value="Monthly" class="select-box rounded">Monthly</option>
                            </select>
                           

                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 pb-5 mb-5 bg-white">
                        <canvas id="Daily" class="city"></canvas>
                        <canvas id="Weekly" class="city" style="display:none"></canvas>
                        <canvas id="Monthly" class="city" style="display:none"></canvas>
            </div>
            <script>
                    var ctx = document.getElementById('Daily').getContext('2d');
                    var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [{!! $data['dailylabel'] !!}],
                        datasets: [{
                        label: 'Revenue',
                        data: [{!! $data['dailyseries'] !!}],
                        backgroundColor: "rgba(153,255,51,0.6)"
                        }]
                    }
                    });
            </script>
                
            <div class="col-xl-6 col-xxl-12 bg-white">
                <div class="card">
                    <div class="card-header d-sm-flex d-block pb-3 border-0">
                        <div class="mr-auto pr-3 mb-sm-0 mb-3">
                            <h4 class="text-black fs-20">Total Redeemed</h4>
                            
                        </div>
                        <div class="select-box">
                            <select class="btn rounded btn-light" onchange="opentab1(this.value)">
                                <option value="Dailyr">Daily</option>
                                <option value="Weeklyr">Weekly</option>
                                <option value="Monthlyr">Monthly</option>
                            </select>
                           

                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 pb-5 mb-5 bg-white">
                        <canvas id="Dailyr" class="cityr"></canvas>
                        <canvas id="Weeklyr" class="cityr"  style="display:none"></canvas>
                        <canvas id="Monthlyr" class="cityr" style="display:none"></canvas>
            </div>

            <script>
                    var ctx = document.getElementById('Dailyr').getContext('2d');
                    var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [{!! $data['dailylabelr'] !!}],
                        datasets: [{
                        label: 'Total Redeemed',
                        data: [{!! $data['dailyseriesr'] !!}],
                        backgroundColor: "rgba(255,153,0,1)"
                        }]
                    }
                    });
                    </script>
        
       

       
    </div>
</div>
<script>
function opentab(cityName) {
    
   /* if ($(".Daily").hasClass('active')) {
        $(".Daily").removeClass('active');
    }
    if ($(".Weekly").hasClass('active')) {
        $(".Weekly").removeClass('active');
    }
    if ($(".Monthly").hasClass('active')) {
        $(".Monthly").removeClass('active');
    }
    $("."+cityName).toggleClass('active');*/
 
    if(cityName == 'Daily')
  {
    var ctx = document.getElementById(cityName).getContext('2d');
                    var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [{!! $data['dailylabel'] !!}],
                        datasets: [{
                        label: 'Revenue',
                        data: [{!! $data['dailyseries'] !!}],
                        backgroundColor: "rgba(153,255,51,0.6)"
                        }]
                    }
                    });
   

    
  }
  if(cityName == 'Weekly')
  {
    var ctx = document.getElementById(cityName).getContext('2d');
                    var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [{!! $data['dailylabelw'] !!}],
                        datasets: [{
                        label: 'Revenue',
                        data: [{!! $data['dailyseriesw'] !!}],
                        backgroundColor: "rgba(153,255,51,0.6)"
                        }]
                    }
                    });
   

    
  }
  if(cityName == 'Monthly')

  {

    var ctx = document.getElementById(cityName).getContext('2d');
                    var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [{!! $data['dailylabelm'] !!}],
                        datasets: [{
                        label: 'Revenue',
                        data: [{!! $data['dailyseriesm'] !!}],
                        backgroundColor: "rgba(153,255,51,0.6)"
                        }]
                    }
                    });
                    

    
  } 
  var i;
  var x = document.getElementsByClassName("city");
  

  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
    
  }
  document.getElementById(cityName).style.display = "block"; 
  
  
    
  
}

function opentab1(cityName) {
    /*if ($(".Dailyr").hasClass('active')) {
        $(".Dailyr").removeClass('active');
    }
    if ($(".Weeklyr").hasClass('active')) {
        $(".Weeklyr").removeClass('active');
    }
    if ($(".Monthlyr").hasClass('active')) {
        $(".Monthlyr").removeClass('active');
    }
    $("."+cityName).toggleClass('active');*/
    if(cityName == 'Dailyr')
  {
    var ctx = document.getElementById(cityName).getContext('2d');
                    var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [{!! $data['dailylabelr'] !!}],
                        datasets: [{
                        label: 'Revenue',
                        data: [{!! $data['dailyseriesr'] !!}],
                        backgroundColor: "rgba(255,153,0,1)"
                        }]
                    }
                    });


    
  }
  if(cityName == 'Weeklyr')
  {
    var ctx = document.getElementById(cityName).getContext('2d');
                    var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [{!! $data['dailylabelrw'] !!}],
                        datasets: [{
                        label: 'Revenue',
                        data: [{!! $data['dailyseriesrw'] !!}],
                        backgroundColor: "rgba(255,153,0,1)"
                        }]
                    }
                    });


    
  }
  if(cityName == 'Monthlyr')

  {

    var ctx = document.getElementById(cityName).getContext('2d');
                    var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [{!! $data['dailylabelrm'] !!}],
                        datasets: [{
                        label: 'Revenue',
                        data: [{!! $data['dailyseriesrm'] !!}],
                        backgroundColor: "rgba(255,153,0,1)"
                        }]
                    }
                    });

    

    
  } 
  var i;
  var x = document.getElementsByClassName("cityr");
  

  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
    x[i].removeClass='active';
  }
  document.getElementById(cityName).style.display = "block";  
  document.getElementById(cityName).addClass="active";
}

</script>
@endsection