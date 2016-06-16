@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <img src="/vote2.png" class="img-responsive center-block" alt="Responsive image">
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color: #5bc0de;">
    <h1 class="text-center">{{ trans('views.pitch') }}</h1>
</div>
<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('views.feature1') }}</div>
                <div class="panel-body">
                    {{ trans('views.feature1_description') }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('views.feature2') }}</div>
                <div class="panel-body">
                    {{ trans('views.feature2_description') }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('views.feature3') }}</div>
                <div class="panel-body">
                    {{ trans('views.feature3_description') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ trans('views.main_description') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
