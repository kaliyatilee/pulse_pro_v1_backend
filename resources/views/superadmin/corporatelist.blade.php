@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-header">
                    <div class="col-9">
                        <h4 class="card-title">Corporate List</h4>
                    </div>
                    <div class="col-2 text-right">
                        <button type="button" class="button" onclick="importData()">Import</button>
                    </div>
                    <div class="col-0 text-right">
                        <a href="{{route('corporatelistexport')}}" class="button">Export</a>
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
                                    
                                    <th>Corporate Name</th>
                                    <th>Registration Number</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Change Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($corporates as $corporate)
                                <tr>
                                    <td>{{ $corporate->name }}</td>
                                    <td>{{ $corporate->registrationNumber }}</td>
                                    <td>{{ $corporate->email }}</td>
                                    <td>{{ $corporate->phone }}</td>
                                    <td>{{ ucwords(strtolower($corporate->status)) }}</td>
                                    <td>
                                        <div class="d-flex">

                                            @if($corporate->status == "active")

                                            <a href="javascript:void(0)" onclick="userstatus({{ $corporate->id }}, 'inactive')" class="button warning">Inactive</a>

                                            @else 

                                            
                                            <a href="javascript:void(0)" onclick="userstatus({{ $corporate->id }}, 'active')"class="button primary">Active</a>

                                            @endif
                                        
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('editcorporate', ['id' => $corporate->id]) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil-square-o"></i></a>
                                            <a href="{{ route('viewcorporate', ['id' => $corporate->id]) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-eye"></i></a>
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
</div>



<!-- Modal -->
<div id="userstatus" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">

    <!-- Modal content-->
    <div class="modal-content">
    
        <div class="modal-body">
        <p class="">Are you sure, you want to change the status?</p>
        </div>
        <input type="hidden" id="id" />
        <input type="hidden" id="userstatus" />
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

                <a href="{{asset('/public/assets/sampleExcecl/corporate-import-data.xlsx')}}" class="modal-title" style="padding-right: 25px; cursor: pointer;">Download Sample</a>
            </div>       
            
            <form method="post" action="{{ route('savecorporateFromImport') }}" enctype="multipart/form-data">
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

    function userstatus(id, status) {
        $('#userstatus').modal('show');
        $('#id').val(id);
        $('#userstatus').val(status);
    }
    function submitstatus() {
        $("#submitstatus").html("Loading...");
        var id = $('#id').val();
        var status = $('#userstatus').val();

        let url = "{{ route('changepartnerstatus') }}";
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