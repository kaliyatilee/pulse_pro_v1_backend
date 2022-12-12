@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">News Feeds</h4>
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
                                    <th>Image</th>
                                    <th>Post</th>
                                    {{-- <th>Type</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($corponewsfeed as $corponewsfee)
                                <tr>
                                    <td><img style="width: 50px;" src="{{$corponewsfee->imageurl}}"></td>
                                    <td>{{ $corponewsfee->post }}</td>
                                    {{-- <td>{{ $corponewsfee->type }}</td> --}}
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('editcorponewsfeed', ['id' => $corponewsfee->id]) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil-square-o"></i></a>
                                            <a href="{{ route('viewcorponewsfeed', ['id' => $corponewsfee->id]) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-eye"></i></a>
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
@endsection