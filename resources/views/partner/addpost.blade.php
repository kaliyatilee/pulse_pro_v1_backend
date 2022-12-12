@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">New Post</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" enctype="multipart/form-data" action="{{route('newpost')}}">
                            @csrf
                            <input type="hidden" name="partner_id" value="{{Auth::user()->partner_id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PostName</label>
                                        <input type="text" name="post" id="post" class="form-control input-default ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PostCategory</label>
                                        <select class="form-control default-select" name="post_category" id="category">
                                            <option value="Motivation">Motivation</option>
                                            <option value="Question">Question</option>
                                            <option value="Activity">Activity</option>
                                            <option value="Health">Health</option>
                                            <option value="Dietary">Dietary</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-lg-12">
                                <div class="form-group type_msg">
                                        <div class="input-group">
                                            <textarea class="form-control" id="post" name="post" rows="5"  placeholder="Type your message here..."></textarea>
                                           
                                        </div>
                                    </div>  
                                </div>
                              
                                   
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Upload PostMedia</label>
                                    <div class="form-group">
                                        <input type="file" name="uploaded_file" class="form-control input-default " placeholder="PostImage">
                                    </div>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-success">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection