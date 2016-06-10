@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class='col-md-8'>
                <h1 id="topic-name" style="display:inline">{{ $topic->name }}</h1>
            </div>
        @can('update-topic', $topic)
            <div class="col-md-8 input-group-lg hidden">
                <input id="topic-name-input" class="form-control" type="text"/>
            </div>
            <div class="col-md-1">
                <button id="topic-name-edit" type="button" class="btn btn-primary">
                    <span class="glyphicon glyphicon-pencil"> </span>
                </button>
            </div>
        @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3> Description 
                    @can('update-topic', $topic)
                        <button id="topic-des-edit" type="button" class="close">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                    @endcan
                    </h3>
                </div>
                <div class="panel-body">
                    <p id="topic-des">{{ $topic->description }}</p>
                @can('update-topic', $topic)
                    <textarea id="topic-des-input" class="form-control hidden" style="resize:none"></textarea>
                @endcan
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3> Question Sets
                    @can('update-topic', $topic)
                        <button id="qs-edit" type="button" class="close">
                         <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                    @endcan
                    </h3>
                </div>
                <div class="panel-body">
                    @include('showQuestionSet')
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3> Topic Information
                    @can('update-topic', $topic)
                        <button id="topic-attr-edit" type="button" class="close">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                    @endcan
                    </h3>
                </div>
                <div class="panel-body">
                    <h3> Proposer </h3>
                    <p> {{ $proposer->name }} </p>

                    <h3> Unlisted </h3>
                    <p class="topic-attr"> {{ $topic->is_unlisted ? 'Yes' : 'No' }} </p>
                @can('update-topic', $topic)
                    <select id="topic-unlist-input" class="form-control hidden">
                        <option>Yes</option>
                        <option>No</option>
                    </select>
                @endcan

                    <h3> End Time </h3>
                    <p class="topic-attr"> {{ $topic->close_at }} </p>
                @can('update-topic', $topic)
                    <input id="topic-end-time-input" class="form-control hidden" type="text"/>
                @endcan

                    <h3> Created Time </h3>
                    <p> {{ $topic->created_at }} </p>

                    <h3> Last Edit Time </h3>
                    <p> {{ $topic->updated_at }} </p>
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
@can('update-topic', $topic)
    $(document).on('click', '#topic-name-edit', function(e) {
        $('#topic-name').parent().addClass('hidden');
        $('#topic-name-input').val($('#topic-name').html()).parent().removeClass('hidden');
        $(this).attr('id', 'topic-name-update');
    });

    $(document).on('click', '#topic-name-update', function(e) {
        $('#topic-name').parent().removeClass('hidden');
        $('#topic-name-input').parent().addClass('hidden');
        $(this).attr('id', 'topic-name-edit');
        //POST
    });

    $(document).on('click', '#topic-des-edit', function(e) {
        $('#topic-des').addClass('hidden');
        $('#topic-des-input').val($('#topic-des').html()).removeClass('hidden');
        $(this).attr('id', 'topic-des-update').blur();
    });

    $(document).on('click', '#topic-des-update', function(e) {
        $('#topic-des-input').addClass('hidden');
        $('#topic-des').removeClass('hidden');
        $(this).attr('id', 'topic-des-edit').blur();
        //POST
    });

    $(document).on('click', '#topic-attr-edit', function(e) {
        $('.topic-attr').addClass('hidden');
        $('#topic-unlist-input').removeClass('hidden');
        $('#topic-end-time-input').removeClass('hidden');
        
        $(this).attr('id', 'topic-attr-update').blur();
    });

    $(document).on('click', '#topic-attr-update', function(e) {
        $('.topic-attr').removeClass('hidden');
        $('#topic-unlist-input').addClass('hidden');
        $('#topic-end-time-input').addClass('hidden');
        //POST
        $(this).attr('id', 'topic-attr-edit').blur();
    });

@endcan
});
</script>
@endsection