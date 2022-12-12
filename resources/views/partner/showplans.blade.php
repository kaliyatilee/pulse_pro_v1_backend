@extends('layouts.partner')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Wellness Plans</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-w850">
                                <thead>
                                <tr>

                                    <th>PlanName</th>
                                    <th>PlanCode</th>
                                    <th>External Reference</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($plans as $plan)
                                    <tr>

                                        <td>{{$plan->plan_name}}</td>
                                        <td>{{$plan->plan_code}}</td>
                                        <td>{{$plan->external_reference}}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"
                                                   data-toggle="modal" data-target="#exampleModalCenter"><i
                                                            class="fa fa-edit"></i></a>
                                                <div class="modal fade" id="exampleModalCenter">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Plan</h5>
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal"><span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h4 class="card-title">WellnessPlan
                                                                            Information</h4>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="basic-form">
                                                                            <form method="post" action="{{route
                                                                        ('update_partner_wellness_plan', $plan->id)}}">
                                                                                @csrf
                                                                                <input name="partner_id" type="hidden"
                                                                                       value="{{$partner->id}}">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <input name="plan_name"
                                                                                                   type="text"
                                                                                                   class="form-control
                                                                                                input-default "
                                                                                                   value="{{$plan->plan_name}}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <input name="description"
                                                                                                   type="text"
                                                                                                   class="form-control
                                                                                               input-default "
                                                                                                   value="{{$plan->description}}"
                                                                                                   placeholder="Write Description">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <input name="plan_code"
                                                                                                   type="text"
                                                                                                   class="form-control
                                                                                                input-default "
                                                                                                   value="{{$plan->plan_code}}">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <input name="external_reference"
                                                                                                   type="text"
                                                                                                   class="form-control
                                                                                                input-default "
                                                                                                   placeholder="Put External Reference">
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                            class="btn btn-danger light"
                                                                                            data-dismiss="modal">Close
                                                                                    </button>
                                                                                    <button type="submit" class="btn
                                                                                btn-primary">Save changes
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <button data-id="{{ $plan->id }}" onclick="deleteConfirmation
                                                        ({{$plan->id}}, '{{ route('destroy_partner_wellness_plan',$plan->id)}}', '{{csrf_token()}}', '{{route('showplans')}}')"
                                                        class="btn
                                                btn-danger
                                            shadow
                                            btn-xs
                                            sharp"><i
                                                            class="fa
                                            fa-trash"></i></button>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        @if (session('success_message'))
        swal({
            title: "Success",
            text: "Wellness Plan updated",
            dangerMode: false,
            icon: "success",
        })
        @endif
    </script>
@endsection