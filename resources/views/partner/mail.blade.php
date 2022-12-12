@extends('layouts.mail')
@section('content')
<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="{{route('compose')}}">Email</a></li>
						<li class="breadcrumb-item "><a href="{{route('compose')}}">SMS</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="email-right-box ml-0 ml-sm-4 ml-sm-0">
                                    <div class="toolbar mb-4" role="toolbar">
                                        <div class="btn-group mb-1">
                                            <button type="button" class="btn btn-success light px-3"><i class="fa fa-archive"></i></button>
                                            <button type="button" class="btn btn-success light px-3"><i class="fa fa-exclamation-circle"></i></button>
                                            <button type="button" class="btn btn-success light px-3"><i class="fa fa-trash"></i></button>
                                        </div>
                                        <div class="btn-group mb-1">
                                            <button type="button" class="btn btn-success light dropdown-toggle px-3" data-toggle="dropdown">
												<i class="fa fa-folder"></i> <b class="caret m-l-5"></b>
                                            </button>
                                            <div class="dropdown-menu"> 
												<a class="dropdown-item" href="javascript: void(0);">Social</a> 
												<a class="dropdown-item" href="javascript: void(0);">Promotions</a> 
												<a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                            </div>
                                        </div>
                                        <div class="btn-group mb-1">
                                            <button type="button" class="btn btn-primary light dropdown-toggle px-3" data-toggle="dropdown">
												<i class="fa fa-tag"></i> <b class="caret m-l-5"></b>
                                            </button>
                                            <div class="dropdown-menu"> 
												<a class="dropdown-item" href="javascript: void(0);">Updates</a> 
												<a class="dropdown-item" href="javascript: void(0);">Social</a> 
												<a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                            </div>
                                        </div>
                                        <div class="btn-group mb-1">
                                            <button type="button" class="btn btn-success light dropdown-toggle v" data-toggle="dropdown">More <span class="caret m-l-5"></span>
                                            </button>
                                            <div class="dropdown-menu"> <a class="dropdown-item" href="javascript: void(0);">Mark as Unread</a> <a class="dropdown-item" href="javascript: void(0);">Add to Tasks</a>
                                                <a class="dropdown-item" href="javascript: void(0);">Add Star</a> <a class="dropdown-item" href="javascript: void(0);">Mute</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="compose-content">
                                        <form action="#">
                                            <div class="form-group">
                                                <input type="text" class="form-control bg-transparent" placeholder=" To:">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control bg-transparent" placeholder=" Subject:">
                                            </div>
                                            <div class="form-group">
                                                <textarea id="email-compose-editor" class="textarea_editor form-control bg-transparent" rows="15" placeholder="Enter text ..."></textarea>
                                            </div>
                                        </form>
                                        <h5 class="mb-4"><i class="fa fa-paperclip"></i> Attatchment</h5>
										<form action="#" class="dropzone">
											<div class="fallback">
												<input name="file" type="file" multiple />
											</div>
										</form>
                                    </div>
                                    <div class="text-left mt-4 mb-2">
                                        <button class="btn btn-success btn-sl-sm mr-2" type="button"><span class="mr-2"><i class="fa fa-paper-plane"></i></span>Send</button>
                                        <button class="btn btn-danger light btn-sl-sm" type="button"><span class="mr-2"><i class="fa fa-times" aria-hidden="true"></i></span>Discard</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
@endsection