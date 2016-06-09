@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header">
        <h1 style="display:inline"> {{ $topic->name }}
        @can('update-topic', $topic)
            <button type="button" class="btn btn-primary">
                <span class="glyphicon glyphicon-pencil"> </span>
            </button>
        @endcan
        </h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    description
                    @can('update-topic', $topic)
                    <button type="button" class="close">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    @endcan
                </div>
                <div class="panel-body">
                    <p>
                        {{ $topic->description }}
                    </p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Question Sets
                    @can('update-topic', $topic)
                    <button type="button" class="close">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    @endcan
                </div>
                <div class="panel-body">
                    @include('showQuestionSet')
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Topic Information
                    @can('update-topic', $topic)
                    <button type="button" class="close">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    @endcan
                </div>
                <div class="panel-body">
                    <h3> Proposer </h3>
                    {{ $proposer->name }}
                    <h3> Unlisted </h3>
                    {{ $topic->is_unlisted ? 'Yes' : 'No' }}
                    <h3> Close At </h3>
                    {{ $topic->close_at }}
                    <h3> Created Time</h3>
                    {{ $topic->created_at }}
                    <h3> Last Edit Time</h3>
                    {{ $topic->updated_at }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="popover">
    Test
</div>
@endsection

@section('scripts')
<script>
$(function()
{
    @if (Auth::check())
    $(document).on('click', '.option', function(e) {
        e.preventDefault();

        if($(this).hasClass('multi')) {
            if($(this).hasClass('list-group-item-info')) {
                $(this).removeClass('list-group-item-info');
            }
            else {
                $(this).addClass('list-group-item-info');
            }
        }
        else {
            if($(this).hasClass('list-group-item-info')) {
                $(this).removeClass('list-group-item-info');
            }
            else {
                $(this).siblings('.option').removeClass('list-group-item-info');
                $(this).addClass('list-group-item-info');
            }
        }
    });
    @else
    $(document).on('click', '.option', function(e) {
        $('.popover').remove();

        e.preventDefault();

        $(this).popover({
            'container' : 'body',
            'title' : 'Hint',
            'content' : 'You have to login before voting.',
            'placement' : 'right'
        }).popover('show');
    });
    @endif
});
</script>
@endsection