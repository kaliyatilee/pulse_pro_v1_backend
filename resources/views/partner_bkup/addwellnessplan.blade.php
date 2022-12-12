@extends('layouts.partner')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">WellnessPlan Information</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{route('create_partner_wellness_plan')}}" method="post">
                            @csrf
                            <input type="hidden" name="partner_id" value="{{Auth::user()->partner_id}}">
                            <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input name="plan_name" type="text" class="form-control input-default " placeholder="PlanName">
                            </div>
                         </div>
                         <div class="col-md-6">
                         <div class="form-group">
                                <input name="plan_description" type="text" class="form-control input-default "
                                       placeholder="PlanDescription">
                            </div>
                         </div>
                        </div>

                        <div class="row">
                         <div class="col-md-6">
                         <div class="form-group">
                                <input name="plan_code" type="text" class="form-control input-default "
                                       placeholder="PlanCode">
                            </div>
                         </div>

                         <div class="col-md-6">
                         <div class="form-group">
                                <input name="external_reference" type="text" class="form-control input-default "
                                       placeholder="External Reference">
                            </div>
                         </div>

                        </div>

                        <div class="row">

                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    @if (session('success_message'))
    swal({
        title: "Success",
        text: "Wellness Plan Added",
        dangerMode: false,
        icon: "success",
    })
    @endif
</script>
@endsection