@extends('layouts.newsfeed')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
               
                <div class="card-body">
                   
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#my-posts" data-toggle="tab" class="nav-link active show">All Posts</a>
                                </li>
                                <li class="nav-item"><a href="#motivation" data-toggle="tab" class="nav-link">Motivation</a>
                                </li>
                                <li class="nav-item"><a href="#dietary" data-toggle="tab" class="nav-link">Dietary</a>
                                </li>
                               <li class="nav-item"><a href="#activity" data-toggle="tab" class="nav-link">Activity</a>
                                </li>
                 
                            </ul>
                            <div class="tab-content">
                                <div id="allposts" class="tab-pane fade active show">
                                   
                                    <div class="my-post-content pt-3">
                                       
                                        @foreach($dailyposts as $post)
                                        <div class="profile-uoloaded-post border-bottom-1 pb-5">
                                            
                                         <p> 
                                         <?php 
                                         	$user = App\Models\User::find($post->postedby);
                                         ?>

                                            <h6 class="text-black">{{$post->created_at}}</h6>
                                          </p>
                                            @if($post->imageurl)
                 
                                            <img class="img-fluid" src="{{$post->imageurl}}" alt="">
                                            @else
                                            <img class="img-fluid" src="{{ env('APP_URL') }}assets/admin/images/profile/profile.png" with="100%" height="30%" alt="">
                                            @endif
                                            <a class="post-title" href="">
                                                <h3 class="text-black">{{$post->title}}</h3>
                                            </a>
                                             <p class="text-black">{{$post->text}}</p>
  
                                            <button class="btn btn-success mr-2"><span class="mr-2"><i class="fa fa-heart"></i></span>200</button>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#replyModal"><span class="mr-2"><i class="fa fa-comments"></i></span>Comments</button>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#replyModal"><span class="mr-2"><i class="fa fa-book"></i></span>Read more</button>
                                        </div>
                                        <hr>
                                        @endforeach
                                    </div>
                                </div>
                                 <div id="motivation" class="tab-pane fade active show">
                                   
                                    <div class="my-post-content pt-3">
                                       
                                        @foreach($dailyposts as $post)
                                        <div class="profile-uoloaded-post border-bottom-1 pb-5">
                                            
                                         <p> 
                                         <?php 
                                         	$user = App\Models\User::find($post->postedby);
                                         ?>
                                       
                                         
                                        
                                            <h6 class="text-black">{{$post->created_at}}</h6>
                                          </p>
                                            @if($post->imageurl)
                 
                                            <img class="img-fluid" src="{{$post->imageurl}}" alt="">
                                            @else
                                            <img class="img-fluid" src="{{ env('APP_URL') }}assets/admin/images/profile/profile.png" with="100%" height="30%" alt="">
                                            @endif
                                            <a class="post-title" href="">
                                                <h3 class="text-black">{{$post->post}}</h3>
                                            </a>
                                           
                                            <button class="btn btn-success mr-2"><span class="mr-2"><i class="fa fa-heart"></i></span>200</button>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#replyModal"><span class="mr-2"><i class="fa fa-comments"></i></span>Comments</button>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#replyModal"><span class="mr-2"><i class="fa fa-book"></i></span>Read more</button>
                                        </div>
                                        <hr>
                                        @endforeach
                                    </div>
                                </div>
                                  <div id="dietary" class="tab-pane fade active show">
                                   
                                    <div class="my-post-content pt-3">
                                       
                                        @foreach($dailyposts as $post)
                                        <div class="profile-uoloaded-post border-bottom-1 pb-5">
                                            
                                         <p> 
                                         <?php 
                                         	$user = App\Models\User::find($post->postedby);
                                         ?>
                                       
                                         
                                     
                                            <h6 class="text-black">{{$post->created_at}}</h6>
                                          </p>
                                            @if($post->imageurl)
                 
                                            <img class="img-fluid" src="{{$post->imageurl}}" alt="">
                                            @else
                                            <img class="img-fluid" src="{{ env('APP_URL') }}assets/admin/images/profile/profile.png" with="100%" height="30%" alt="">
                                            @endif
                                            <a class="post-title" href="">
                                                <h3 class="text-black">{{$post->post}}</h3>
                                            </a>
                                           
                                            <button class="btn btn-success mr-2"><span class="mr-2"><i class="fa fa-heart"></i></span>200</button>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#replyModal"><span class="mr-2"><i class="fa fa-comments"></i></span>Comments</button>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#replyModal"><span class="mr-2"><i class="fa fa-book"></i></span>Read more</button>
                                        </div>
                                        <hr>
                                        @endforeach
                                    </div>
                                </div>
                                  <div id="activity" class="tab-pane fade active show">
                                   
                                    <div class="my-post-content pt-3">
                                       
                                        @foreach($dailyposts as $post)
                                        <div class="profile-uoloaded-post border-bottom-1 pb-5">
                                            
                                         <p> 
                                         <?php 
                                         	$user = App\Models\User::find($post->postedby);
                                         ?>
                                       
                                         
                                       
                                            <h6 class="text-black">{{$post->created_at}}</h6>
                                          </p>
                                            @if($post->imageurl)
                 
                                            <img class="img-fluid" src="{{$post->imageurl}}" alt="">
                                            @else
                                            <img class="img-fluid" src="{{ env('APP_URL') }}assets/admin/images/profile/profile.png" with="100%" height="30%" alt="">
                                            @endif
                                            <a class="post-title" href="">
                                                <h3 class="text-black">{{$post->text}}</h3>
                                            </a>
                                           
                                            <button class="btn btn-success mr-2"><span class="mr-2"><i class="fa fa-heart"></i></span>200</button>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#replyModal"><span class="mr-2"><i class="fa fa-comments"></i></span>Comments</button>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#replyModal"><span class="mr-2"><i class="fa fa-book"></i></span>Read more</button>
                                        </div>
                                        <hr>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="replyModal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Post Reply</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <textarea class="form-control" rows="4">Message</textarea>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Reply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection