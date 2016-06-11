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

                <div id="qs-list" class="panel-body">
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
                    <p id="updated-at"> {{ $topic->updated_at }} </p>
                </div>
            </div>
        </div>
    </div>
</div>

@can('update-topic', $topic)
<div id="error-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span></button>
            <h4 class="modal-title">Oops!</h4>
        </div>
        <div class="modal-body">
            <p></p>
        </div>
    </div>
</div>
@endcan
@endsection

@section('scripts')
<script>
$(function()
{
@if (Auth::check())
    $(document).on('click', '.option', function(e) {
        e.preventDefault();

        var qs_id = $(this).parents('.qs-entry').index() + 1;
        var opt_id = $('.qs-entry:nth(' + String(qs_id - 1) + ') .option').index($(this)) + 1;
        console.log([qs_id,opt_id]);

        if($(this).hasClass('multi')) {
            if($(this).hasClass('list-group-item-info')) {
                //destroy
                $.post('/topics/' + String({{$topic->id}}) + '/ballot/destroy',
                {
                    '_token' : '{{ csrf_token() }}',
                    'qsid' : qs_id,
                    'optid' : opt_id
                }, function(data) {
                    loadQuestionSet(qs_id - 1);
                }).error(function(data) {
                    loadQuestionSet(qs_id - 1);
                    // May add more complicated error message here.
                    $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
                    $('#error-modal').modal('show');
                });
            }
            else {
                //create
                $.post('/topics/' + String({{$topic->id}}) + '/ballot/store',
                {
                    '_token' : '{{ csrf_token() }}',
                    'qsid' : qs_id,
                    'optid' : opt_id
                }, function(data) {
                    loadQuestionSet(qs_id - 1);
                }).error(function(data) {
                    loadQuestionSet(qs_id - 1);
                    // May add more complicated error message here.
                    $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
                    $('#error-modal').modal('show');
                });
            }
        }
        else {
            if($(this).hasClass('list-group-item-info')) {
                //destroy
                $.post('/topics/' + String({{$topic->id}}) + '/ballot/destroy',
                {
                    '_token' : '{{ csrf_token() }}',
                    'qsid' : qs_id,
                    'optid' : opt_id
                }, function(data) {
                    loadQuestionSet(qs_id - 1);
                }).error(function(data) {
                    loadQuestionSet(qs_id - 1);
                    // May add more complicated error message here.
                    $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
                    $('#error-modal').modal('show');
                });
            }
            else {
                //update
                $.post('/topics/' + String({{$topic->id}}) + '/ballot/update',
                {
                    '_token' : '{{ csrf_token() }}',
                    'qsid' : qs_id,
                    'optid' : opt_id
                }, function(data) {
                    loadQuestionSet(qs_id - 1);
                }).error(function(data) {
                    loadQuestionSet(qs_id - 1);
                    // May add more complicated error message here.
                    $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
                    $('#error-modal').modal('show');
                });
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
        $(this).attr('id', 'topic-name-edit');

        $.post('/topics/' + String({{$topic->id}}) + '/update',
        {
            '_token' : '{{ csrf_token() }}',
            'type' : 'name',
            'data' : $('#topic-name-input').val(),
        }, function(data) {
            window.location = "/topics/{{$topic->id}}";
        }).error(function(data) {
            $('#topic-name').parent().removeClass('hidden');
            $('#topic-name-input').parent().addClass('hidden');

            // May add more complicated error message here.
            $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
            $('#error-modal').modal('show');
        });
    });

    $(document).on('click', '#topic-des-edit', function(e) {
        $('#topic-des').addClass('hidden');
        $('#topic-des-input').val($('#topic-des').html()).removeClass('hidden');
        $(this).attr('id', 'topic-des-update').blur();
    });

    $(document).on('click', '#topic-des-update', function(e) {
        $(this).attr('id', 'topic-des-edit').blur();

        $.post('/topics/' + String({{$topic->id}}) + '/update',
        {
            '_token' : '{{ csrf_token() }}',
            'type' : 'des',
            'data' : $('#topic-des-input').val(),
        }, function(data) {
            window.location = "/topics/{{$topic->id}}";
        }).error(function(data) {
            $('#topic-des-input').addClass('hidden');
            $('#topic-des').removeClass('hidden');

            // May add more complicated error message here.
            $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
            $('#error-modal').modal('show');
        });
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

        $(this).attr('id', 'topic-attr-edit').blur();
    });
@endcan
    loadQuestionSets();
});

function loadQuestionSets() {
    $.get('/topics/' + String({{$topic->id}}) + '/count', function(data) {
        for(var idx = 0; idx < data['qs_count']; ++idx) {
            loadQuestionSet(idx);
        }
    })
}

function loadQuestionSet(index) {
    $.get('/topics/' + String({{$topic->id}}) + '/' + String(index + 1), function(data) {
        var entry = $('.qs-entry:nth(' + String(index) + ')')
        
        if(data['question_set']['is_multiple_choice']){
            entry.find('.option-template').addClass('multi');
        }

        entry.find('.option').remove();
        for(var opt_idx = 0; opt_idx < data['options'].length; ++opt_idx) {
            var newOption = entry.find('.option-template').clone();
            var option = data['options'][opt_idx];

            newOption.removeClass('hidden').removeClass('option-template').addClass('option');
            newOption.children('label').text(option['content']);
            newOption.appendTo(entry.find('ul'));
        }
    @if(Auth::check())
        for(var ballot_idx = 0; ballot_idx < data['user_ballot'].length; ++ballot_idx) {
            entry.find('.option:nth(' + String(data['user_ballot'][ballot_idx]['option_id'] - 1) +')')
                .addClass('list-group-item-info');
        }
    @endif
        for(var ballot_count_idx = 0; ballot_count_idx < data['all_ballots'].length; ++ballot_count_idx) {
            entry.find('.badge:nth(' + String(ballot_count_idx + 1) + ')').html(data['all_ballots'][ballot_count_idx]['count']);
        }
    }).error(function(data) {
    });
}
</script>
@endsection