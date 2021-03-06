@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1>{{ $user->name }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ trans('views.register_time') }}{{ $user->created_at }}
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('views.topics') }}
                </div>
                <table class="table table-hover">
                <tr>
                    <th>{{ trans('views.id') }}</th>
                    <th>{{ trans('views.topic_name') }}</th>
                </tr>
                @foreach($topics as $topic)
                    <tr>
                        <td> {{ $topic->id }} </td>
                        <td>
                            <a href=' {{ url('topics/' . $topic->id) }}'>
                                {{ $topic->name }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
        </div>
        {{ $pagination }}
    </div>

@endsection
