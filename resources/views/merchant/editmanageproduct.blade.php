@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Product Qty</h4>
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
                        
                        <form method="post" action="{{ route('savemanageproduct') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" id="id" name="id">

                        <div class="row">
                            
                            <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Product Image</label>
                                            <div class="d-flex flex-wrap">
                                                <div class="uploadedimg me-3 mb-2" id="image_preview">
                                                    <img style="width: 400px;" src="{{$product->productimage}}">
                                                </div>
    
                                               
                                            </div>
                                        </div>
                                    </div>
    
    
                                </div>

                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input type="text" disabled value="{{ old('productname') ? old('productname') : $product->reward_name }}" name="productname" id="productname" class="form-control input-default @error('productname') is-invalid @enderror" placeholder="Product Name">
                            </div>
                         </div>
                        
                        </div>

                        <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">

                                <label class="form-label">Total Qty</label>

                                <input type="number" value="{{ old('totalQty') ? old('totalQty') : $product->totalQty }}" name="totalQty" id="totalQty" class="form-control input-default @error('totalQty') is-invalid     @enderror" placeholder="Total Qty">
                                            @error('totalQty')
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
   
                                   <label class="form-label">Available Qty</label>
   
                                   <input type="text" disabled value="{{ old('totalQty') ? old('totalQty') : $product->totalQty }}" name="totalQty" id="totalQty" class="form-control input-default @error('totalQty') is-invalid     @enderror" placeholder="Total Qty">
                                               @error('totalQty')
                                                   <span class="invalid-feedback" role="alert">
                                                       <strong>{{ $message }}</strong>
                                                   </span>
                                               @enderror
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