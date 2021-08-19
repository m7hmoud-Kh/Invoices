@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@section('title')
    Edit Permission
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">permission</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                Edit Permission</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')



@if (session()->has('edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('edit') }}</strong>
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



<!-- row -->
<form action="/role/update" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <div class="form-group">
                            <p> Permission Name: {{ $role->name }} </p>

                        </div>
                    </div>
                    <div class="row">
                        <!-- col -->
                        <input type="hidden" name="role_id" value="{{$role->id}}">
                        <div class="col-lg-4">
                            <ul id="treeview1">
                                <li><a href="#">Permission</a>
                                    <ul>
                                        @foreach ($allpermission as $per)
                                            <li>
                                                <input type="checkbox" name="permission[]"
                                                    id="{{ $per->id }}" value="{{ $per->id }}" @foreach ($permission as $item)  @if ($item->name==$per->name)
                                                checked @endif
                                        @endforeach>
                                        <label for="{{ $per->id }}">{{ $per->name }}</label>
                                </li>
                                @endforeach
                            </ul>
                            </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-main-primary">Update</button>
                        </div>
                        <!-- /col -->
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
</form>
@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
@endsection
