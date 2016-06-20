@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            @if (Auth::check())
            <p>
                <!-- Trigger Modal -->
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#CreateModal">{{ trans('views.create_topic') }}</button>
            </p>
            @endif

            <ul class="nav navbar-nav navbar-right">
                <form class="form-inline">
                    <div class="form-group" role="form" method="GET" action="http://www.google.com">
                        <label class="sr-only" for="term">搜尋</label>
                        <input class="form-control" name="term" id="term" placeholder="搜尋">
                    </div>
                </form>
            </ul>

            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('views.topics') }}</div>

                <table class="table table-hover">
                <tr>
                    <th>{{ trans('views.id') }}</th>
                    <th>{{ trans('views.topic_name') }}</th>
                    <th>{{ trans('views.proposer') }}</th>
                </tr>
                @foreach($topics as $topic)
                    @if(!$topic->is_unlisted)
                    <tr>
                        <td> {{ $topic->id }} </td>
                        <td>
                            <a href=' {{ url('topics/' . $topic->id) }}'>
                                {{ $topic->name }}
                            </a>
                        </td>
                        <td>
                            <a href=' {{ url('home/' . $topic->user_id) }}'>
                                {{ $topic->username }}
                            </a>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </table>
            </div>
        </div>
    </div>
    {{ $pagination }}
</div>
@endsection

<!-- Modal -->
<div class="modal fade" id="CreateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">{{ trans('views.close') }}</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('views.create_new_topic') }}</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/topics/create') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">{{ trans('views.topic_name') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                {{ trans('views.next') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
@if ($errors->has('name'))
<script>
$(function()
{
    $('#CreateModal').modal('show');
});
</script>
@endif
@endsection
