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
                        <table id="newsFeedReport" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>Post</th>
                                    <th>Category</th>
                                    <th>By</th>
                                    <th>Likes</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                
                                    <?php 
                                       $user = App\Models\User::find($post->postedby);
                                    ?>
                                   
                                    <td>{{$post->post}}</td>
                                    <td>{{$post->category}}</td>
                                    <td>{{$post->firstname}} {{$post->lastname}}</td>
                                    <td>1000</td>
                                    <td>50</td>
                                    <td>{{$post->created_at}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-edit"></i></a>
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