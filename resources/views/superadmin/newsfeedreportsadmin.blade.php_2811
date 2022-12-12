@extends('layouts.superadmin')
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
                        <table id="goalReport" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Post Media</th>
                                    {{-- <th>Headline</th> --}}
                                    <th>Post</th>
                                    <th>Role</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td>{{$post->id}}</td>
                                        <td>
                                            @if($post->imageurl)
                                                @php $imageurl = str_ireplace("/core","",$post->imageurl); @endphp
                                                <img src="{{$imageurl}}" height="50" width="50" />
                                            @else 
                                                -
                                            @endif
                                        </td>
                                        {{-- <td>{{$post->headline}}</td> --}}
                                        <td>{{$post->post}}</td>
                                        <td>{{$post->role}}</td>
                                        <td>{{$post->created_at}}</td>
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