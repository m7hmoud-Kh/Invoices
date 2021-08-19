@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
@section('title')
Edit User
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">User</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Edit
                User</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-lg-12 col-md-12">

        @if (session()->has('update'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('update') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

        @if ($errors->any())
            @foreach ($errors as $err)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $err }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        @endif



        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="">Back</a>
                    </div>
                </div><br>
                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                action="/user/update" method="post">
                @csrf

                <div class="">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6" id="fnWrapper">
                            <label>Username: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20"
                                data-parsley-class-handler="#lnWrapper" name="name" required="" type="text" value="{{$user->name}}">
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>email: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20"
                                data-parsley-class-handler="#lnWrapper" name="email" required="" type="email" value="{{$user->email}}">
                        </div>
                    </div>

                </div>

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>Password:</label>
                        <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                            name="password"   type="password" >
                    </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label> confirm Password: </label>
                        <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                            name="confirm-password"  type="password" >
                    </div>
                </div>

                <div class="row row-sm mg-b-20">
                    <div class="col-lg-6">
                        <label class="form-label"> Status</label>
                        <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                            <option @if ($user->Status == 'active')
                                selected
                            @endif value="active">active</option>
                            <option  @if ($user->Status == 'not active')
                                selected
                            @endif
                            value="not active">not active</option>
                        </select>
                    </div>
                </div>


                <div class="row row-sm mg-b-20">
                    <div class="col-lg-6">
                        <label class="form-label"> Permission</label>
                        <select name="role" id="role" class="form-control  nice-select  custom-select">
                            @foreach ($roles as $role)
                            <option @if ($user->roles_name == $role->name)
                                selected
                            @endif value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button class="btn btn-main-primary pd-x-20" type="submit">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>




</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')

<!-- Internal Nice-select js-->
<script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js') }}"></script>

<!--Internal  Parsley.min js -->
<script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<!-- Internal Form-validation js -->
<script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
@endsection
