
@extends('layouts.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-header">
                    <div class="col-9">
                        <h4 class="card-title">Product List</h4>
                    </div>
                    <div class="col-1 text-right">
                        <button type="button" class="button" onclick="importData()">Import</button>
                    </div>
                    <div class="col-0 text-right">
                        <a href="{{route('productlistexport')}}" class="button">Export</a>
                    </div>
                </div>

                @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session()->has('failed'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('failed') }}
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
                                    <th>Action</th>
                                    @if($userdata->role == "super")
                                        <th>Status</th>
                                    @endif

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
                                    @if($userdata->role == "super")
                                    @if($product->status == "pending")
                                    <td>
                                        <div class="d-flex">
                                            <a href="javascript:void(0)" onclick="productstatus({{ $product->id }}, 'approved')"class="button primary">Approve</a>&nbsp;
                                            <a href="javascript:void(0)" onclick="productstatus({{ $product->id }}, 'rejected')" class="button warning">Reject</a>
                                        </div>
                                    </td>
                                    @else
                                    <td>
                                    -
                                    </td>
                                    @endif
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


<!-- Modal -->
    <div id="productstatus" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
    
        <!-- Modal content-->
        <div class="modal-content">
        
            <div class="modal-body">
            <p class="">Are you sure, you want to change the status?</p>
            </div>
            <input type="hidden" id="productid" />
            <input type="hidden" id="productstatus" />
            <div class="modal-footer">
            <button type="button" id="submitstatus" onclick="submitstatus()" class="button primary">Yes</button>&nbsp;
            <button type="button" class="button warning" data-dismiss="modal">No</button>
            </div>
        </div>
    
        </div>
    </div>

    <!-- Import -->
    <div id="importData" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content"> 
                <div class="modal-header">
                    <h5 class="modal-title">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>

                    <a href="{{asset('/public/assets/sampleExcecl/product-import-data.xlsx')}}" class="modal-title" style="padding-right: 25px; cursor: pointer;">Download Sample</a>
                </div>       
                
                <form method="post" action="{{ route('saveproductFromImport') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="d-flex flex-wrap">
                        <div class="uploadlogo me-3">
                            <label for="importFile" class="custom-file-upload md-font fw-600 selectlogo addsmupload"><img src="{{asset('/public/assets/img/ic_plus_upld.svg')}}"></label>
                            <input id="importFile" name="importFile" type="file" required/>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="btnsubmit" class="button primary">Submit</button>&nbsp;
                    <button type="button" class="button warning" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End -->

@endsection
<script>
    function importData(){
        $('#importData').modal('show');
    }
    function productstatus(id, status) {
        $('#productstatus').modal('show');
        $('#productid').val(id);
        $('#productstatus').val(status);
    }
    function submitstatus() {
        $("#submitstatus").html("Loading...");
        var id = $('#productid').val();
        var status = $('#productstatus').val();

        let url = "{{ route('productstatus') }}";
        $.ajax({
            type: "GET",
            url: url,
            data: { id: id, status: status },
            success: function (result) {
                location.reload();
            }
        });
    }
</script>