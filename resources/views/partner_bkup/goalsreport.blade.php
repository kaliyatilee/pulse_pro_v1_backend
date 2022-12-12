@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-xl-5 col-xxl-12 mr-auto">
                            <div class="d-sm-flex d-block align-items-center">
                                <img src="images/illustration.png" alt="" class="mw-100 mr-3">
                                <div>
                                    <h4 class="fs-20 text-black">Generate member report  </h4>
                                    <p class="fs-14 mb-0"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-xxl-12 mt-3">
                            <div class="btn btn-outline-primary btn-md mb-2"><input class="form-control" type="date"><i class="ml-3 scale5"></i></div>
                            <svg class="ml-2 mr-2" width="14" height="3" viewBox="0 0 14 3" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="14" height="3" rx="1.5" fill="#2B2B2B" />
                            </svg>
                            <div class="btn btn-outline-primary mr-3 btn-md  mb-2"><input class="form-control" type="date"><i class="ml-3 scale5"></i></div>
                            <a href="" class="btn btn-primary btn-md mb-2">Generate Report<i class="las la-angle-right ml-3 scale5"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection