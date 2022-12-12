
@extends('layouts.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product List</h4>
                </div>

                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                        @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Product Status</th>
                                    <th>Total Qty</th>
                                    <th>Available Qty</th>
                                    @if($userdata->role != "super")
                                    <th>Manage</th>
                                    @endif
                                   
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><img style="width: 50px;" src="{{$product->productimage}}"></td>
                                    <td>{{ $product->reward_name }}</td>
                                    <td>{{ ucwords(strtolower($product->status)) }}</td>
                                    <td>{{ $product->totalQty }}</td>
                                    <td>{{ $product->totalQty }}</td>
                                    @if($userdata->role != "super")
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('editmanageproduct', ['id' => $product->id]) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil-square-o"></i></a>
                                        </div>
                                    </td>
                                    @endif
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
</div>

@endsection