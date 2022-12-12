@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">News Feed</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>Postname</th>
                                    <th>Category</th>
                                    <th>Postedby</th>
                                    <th>Post Media</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                   @foreach($posts as $post)
                                <tr>
                                   
                                    <td>{{$post->post}}</td>
                                    <td>{{$post->category}}</td>
                                    <td>{{$post->postby}}</td>
                                    <td><img src="{{$post->postby}}"></td>
                                    <td>{{$post->created_at}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                            <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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