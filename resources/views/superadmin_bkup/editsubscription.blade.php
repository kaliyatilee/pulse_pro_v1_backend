@extends('layouts.superadmin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Partner Information</h4>
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

                                
                        <form method="post" action="{{ route('savesubscription') }}" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" value="{{ old('plan_name') ? old('plan_name') : $partner->plan_name }}" id="plan_name" name="plan_name" class="form-control input-default @error('plan_name') is-invalid @enderror" placeholder="Plan Name">
                                                @error('plan_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" value="{{ old('amount') ? old('amount') : $partner->amount }}" id="amount" name="amount" class="form-control input-default @error('amount') is-invalid @enderror" placeholder="Plan Price">
                                                @error('amount')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="{{ $partner->id }}" id="id" name="id">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            
                                            <textarea id="description" name="description" class="form-control input-default @error('description') is-invalid @enderror" placeholder="Plan Description">{{ old('description') ? old('description') : $partner->description }}</textarea>

                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>
    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="number" value="{{ old('days') ? old('days') : $partner->days }}" id="days" name="days" class="form-control input-default @error('days') is-invalid @enderror" placeholder="Days">
                                                @error('days')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>
                                    
                                </div>
    
                                <br>
    
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
        var total_file = document.getElementById("directorId").files;
        $('#image_preview').html("<img style='width: 400px;' src='" + URL
            .createObjectURL(event.target.files[0]) + "'>");

    }
      // image preview function call  
      function preview_mou() {
        $('#oldmou').html("");

    }
</script>