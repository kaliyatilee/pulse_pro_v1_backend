@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Client List</h4>
                    
                    <a href="{{route('clientsexport')}}" class="button">Export</a>

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
                                    
                                    <th>Member Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>By Corporate</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>PUL{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->corponame ? $user->corponame : '-' }}</td>
                                    <td>{{ ucwords(strtolower($user->status)) }}</td>
                                    <td>
                                        <div class="d-flex">

                                            @if($user->status == "active")

                                            <a href="javascript:void(0)" onclick="userstatus({{ $user->id }}, 'inactive')" class="button warning">Inactive</a>

                                            @else 

                                            
                                            <a href="javascript:void(0)" onclick="userstatus({{ $user->id }}, 'active')"class="button primary">Active</a>

                                            @endif
                                        
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                           
                                            <a href="{{ route('viewclient', ['id' => $user->id]) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-eye"></i></a>
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


@endsection
<script>
    function userstatus(id, status) {
        $('#userstatus').modal('show');
        $('#id').val(id);
        $('#userstatus').val(status);
    }
    function submitstatus() {
        $("#submitstatus").html("Loading...");
        var id = $('#id').val();
        var status = $('#userstatus').val();

        let url = "{{ route('userstatus') }}";
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