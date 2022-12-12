@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        
                    @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        @endif

                        <form method="post" action="{{ route('saveproduct') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text"  value="{{old('productname')}}" name="productname" id="productname" class="form-control input-default @error('productname') is-invalid @enderror" placeholder="ProductName">
                                @error('productname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                            </div>
                         </div>
                        
                        </div>

                        <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" value="{{old('productdescription')}}" name="productdescription" id="productdescription" class="form-control input-default @error('productdescription') is-invalid @enderror" placeholder="Description">
                                    @error('productdescription')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                            </div>
                         </div>
                        
                        </div>

                        
                        <div class="row">
                            <div class="col-md-6">
                               <div class="form-group">
                                   <input type="text" value="{{old('amount')}}" name="amount" id="amount" class="form-control input-default @error('amount') is-invalid @enderror" placeholder="Amount">
                                       @error('amount')
                                                   <span class="invalid-feedback" role="alert">
                                                       <strong>{{ $message }}</strong>
                                                   </span>
                                               @enderror
                               </div>
                            </div>
                           
                           </div>
                        
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Product Image</label>
                                        <div class="d-flex flex-wrap">
                                        
                                            <div class="uploadedimg me-3 mb-2" id="image_preview"></div>

                                            <div class="uploadlogo me-3">
                                                <label for="productimage" class="custom-file-upload md-font fw-600 selectlogo addsmupload"><img src="{{asset('/public/assets/img/ic_plus_upld.svg')}}"></label>
                                                <input id="productimage" name="productimage" onchange="preview_image();" type="file" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                      
                        <button type="submit" class="button primary">Submit</button>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
<script>
      // image preview function call  
      function preview_image() {
        var total_file = document.getElementById("productimage").files;
        $('#image_preview').html("<img style='width: 400px;' src='" + URL
            .createObjectURL(event.target.files[0]) + "'>");

    }
</script>