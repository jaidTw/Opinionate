@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <img src="/vote2.png" class="img-responsive center-block" alt="Responsive image">
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color: #5bc0de;">
    <h1 class="text-center">{{ trans('views.pitch') }}</h1>
</div>
<div class="container" style="margin-top: 0px;">

    <div class="row center-block">
        <div class="col-xs-12 col-md-4" style="background-color: #428bca; width: 33%; height: 150px; margin: 0px;">
            {{ trans('views.feature1') }}{{ trans('views.feature1_description') }}
        </div>
        <div class="col-xs-12" style="background-color: #f0ad4e; width: 33%; height: 150px;">
            {{ trans('views.feature2') }}{{ trans('views.feature2_description') }}
        </div>
        <div class="col-xs-12" style="background-color: #5cb85c; width: 33%; height: 150px;">
            {{ trans('views.feature3') }}{{ trans('views.feature3_description') }}
        </div>
    </div>

    <div class="row center-block">
        <div class="col-xs-12 col-md-12" style="background-color: #eee; width: 99%; height: 150px; margin: 0px;">
            {{ trans('views.main_description') }}
        </div>
    </div>

</div>
@endsection
