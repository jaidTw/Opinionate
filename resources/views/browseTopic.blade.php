@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <p>
                <!-- Trigger Modal -->
                @if (Auth::check())
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#CreateModal">{{ trans('views.create_topic') }}</button>
                @endif
                <input class="form-control" id="search_topic" placeholder="搜尋">
            </p>

            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('views.topics') }}</div>

                <table class="table table-hover" id="browse_table">
                <tr>
                    <th>{{ trans('views.id') }}</th>
                    <th>{{ trans('views.topic_name') }}</th>
                    <th>{{ trans('views.proposer') }}</th>
                </tr>
                @foreach($topics as $topic)
                    <tr class="topic_listing">
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
                @endforeach
                </table>

                <table class="table table-hover hidden" id="search_table">
                <tr>
                    <th>{{ trans('views.id') }}</th>
                    <th>{{ trans('views.topic_name') }}</th>
                    <th>{{ trans('views.proposer') }}</th>
                </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="text-center" id="pagination">
        {{ $pagination }}
    </div>
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

<script>
$(function()
{
@if ($errors->has('name'))
    $('#CreateModal').modal('show');
@endif
    $(document).on('input focus blur', '#search_topic', function() {
        if ($(this).val() == '')
        {
            $('#search_table').addClass('hidden');
            $('#browse_table').removeClass('hidden');
            $('#pagination').removeClass('hidden');
        }
        else
        {
            $('#browse_table').addClass('hidden');
            $('#pagination').addClass('hidden');
            $.get("/topics/search", {term: $(this).val()})
            .done(function(data) {
                $('.search_listing').remove();

                result_topics = $.parseJSON(data);
                $.each(result_topics, function(k, v) {
                    $('#search_table').append(
                        '<tr class="search_listing"><td>' +
                        v['id'] +
                        '</td><td><a href=\'/topics/' +
                        v['id'] +
                        '\'>' +
                        v['name'] +
                        '</a></td><td><a href=\'/home/' +
                        v['user_id'] +
                        '\'>' +
                        v['username'] +
                        '</a></td></tr>'
                    );
                });

                $('#search_table').removeClass('hidden')
            });
        }
    });
});
</script>
@endsection
