@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class='col-md-8'>
                <h1 id="topic-name" style="display:inline">{{ $topic->name }}</h1>
            </div>
        @can('update-topic', $topic)
            <div class="col-md-8 input-group-lg topic-name-control hidden">
                <input id="topic-name-input" class="form-control" type="text"/>
            </div>
            <div class="col-md-1">
                <button id="topic-name-update" type="button" class="btn btn-success btn-lg topic-name-control hidden">
                    Save
                </button>
            </div>
            <div class="col-md-1">
                <button id="topic-name-edit" type="button" class="btn btn-primary btn-lg">
                    <span class="glyphicon glyphicon-pencil"> </span>
                </button>
            </div>
            <div class="col-md-1">
                <button id="topic-delete" type="button" class="btn btn-danger btn-lg">
                    Delete Topic
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
                    <div class="row">
                        <div class="col-md-1 col-md-offset-10">
                            <br/>
                            <button id="topic-des-update" type="button" class="btn btn-success hidden">
                                Save
                            </button>
                        </div>
                    </div>
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

                @can('update-topic', $topic)
                    @include('newQsTemplate')

                    <div class="row">
                        <div class="col-md-1">
                            <button id="qs-add" class="btn btn-primary qs-edit-control hidden">
                                Add Question Set
                            </button>
                        </div>
                        <div class="col-md-1 col-md-offset-9">
                            <button id="qs-update" class="btn btn-danger qs-edit-control hidden">
                                Save
                            </button>
                        </div>
                    </div>
                @endcan
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
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                @endcan

                    <h3> End Time </h3>
                    <p class="topic-attr"> {{ $topic->close_at }} </p>
                @can('update-topic', $topic)
                    <div class='input-group date hidden' id='topic-end-time-input'>
                        <input type='text' class="form-control"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                @endcan

                    <h3> Created Time </h3>
                    <p> {{ $topic->created_at }} </p>

                    <h3> Last Edit Time </h3>
                    <p id="updated-at"> {{ $topic->updated_at }} </p>
                @can('update-topic', $topic)
                    <div class="col-md-1 col-md-offset-9">
                        <button id="topic-attr-update" class="btn btn-success hidden">
                            Save
                        </button>
                    </div>
                @endcan
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
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Oops!</h4>
            </div>
            <div class="modal-body">
            <p></p>
            </div>
        </div>
    </div>
</div>
<div id="delete-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <h4 class="modal-title">Warning!</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            You are going to delete the topic. <br/>
                            This will destroy all the things related (question sets, ballots, etc.)
                        </p>
                    </div>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/topics/' . $topic->id . '/destroy') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 col-md-offset-4">
                            <button class="btn submit btn-primary">
                                Confirm
                            </button>
                            <button class="btn btn-default">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endcan
<div id="ballot-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ballots</h4>
            </div>
            <div class="modal-body">
                <li class="list-group-item hidden"><a class="h4"></a></li>
                <ul class="list-group">
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function()
{
    loadQuestionSets();

// If user is logged in, register voting handlers
@if (Auth::check())
    $(document).on('click', '.option', vote_action);

    function vote_action(e) {
        e.preventDefault();

        var qs_id = $(this).parents('.qs-entry').index() + 1;
        var opt_id = $('.qs-entry:nth(' + String(qs_id - 1) + ') .option').index($(this)) + 1;

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
                }).ballot(function(data) {
                    loadQuestionSet(qs_id - 1);
                    // TODO : add more complicated error message here.
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
                    // TODO : add more complicated error message here.
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
                    // TODO : add more complicated error message here.
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
                    // TODO : add more complicated error message here.
                    $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
                    $('#error-modal').modal('show');
                });
            }
        }
    }
// If is not logged in, trigger the hint.
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

// If user is the proposer, register the edit handlers
@can('update-topic', $topic)
    // Setup datetimpicker
    $('#topic-end-time-input').datetimepicker({
        useCurrent : false,
        format : 'YYYY-MM-DD HH:mm:ss',
        minDate : moment().add(10, 'minutes'),
        defaultDate : '{{$topic->close_at}}'
    });

    // Handlers for edit topic name
    $(document).on('click', '#topic-name-edit', function(e) {
        $('#topic-name').parent().addClass('hidden');
        $('#topic-name-input').val($('#topic-name').html())
        $('.topic-name-control').removeClass('hidden');
        $(this).attr('id', 'topic-name-edit-cancel').removeClass('btn-primary').addClass('btn-danger').blur();

    }).on('click', '#topic-name-edit-cancel', function(e) {
        $('.topic-name-control').addClass('hidden');
        $('#topic-name').parent().removeClass('hidden');
        $(this).attr('id', 'topic-name-edit').addClass('btn-primary').removeClass('btn-danger').blur();

    }).on('click', '#topic-name-update', function(e) {
        $.post('/topics/' + String({{$topic->id}}) + '/update',
        {
            '_token' : '{{ csrf_token() }}',
            'type' : 'name',
            'data' : $('#topic-name-input').val(),
        }, function(data) {
            window.location = "/topics/{{$topic->id}}";
        }).error(function(data) {
            $('.topic-name-control').addClass('hidden');
            $('#topic-name').parent().removeClass('hidden');
            $('#topic-name-edit-cancel').attr('id', 'topic-name-edit').addClass('btn-primary').removeClass('btn-danger').blur();

            // TODO : add more complicated error message here.
            $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
            $('#error-modal').modal('show');
        });
    });

    // Handlers for edit topic description
    $(document).on('click', '#topic-des-edit', function(e) {
        $('#topic-des').addClass('hidden');
        $('#topic-des-input').val($('#topic-des').html()).removeClass('hidden');
        $('#topic-des-update').removeClass('hidden');
        $(this).attr('id', 'topic-des-edit-cancel').blur();

    }).on('click', '#topic-des-edit-cancel', function(e) {
        $('#topic-des-input').addClass('hidden');
        $('#topic-des').removeClass('hidden');
        $('#topic-des-update').addClass('hidden');
        $(this).attr('id', 'topic-des-edit').blur();

    }).on('click', '#topic-des-update', function(e) {
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
            $('#topic-des-edit-cancel').attr('id', 'topic-des-edit').blur();
            $(this).addClass('hidden');

            // TODO : add more complicated error message here.
            $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
            $('#error-modal').modal('show');
        });
    });

    // Handlers for edit topic attributes(end time and unlist property)
    $(document).on('click', '#topic-attr-edit', function(e) {
        $('.topic-attr').addClass('hidden');
        $('#topic-attr-edit-cancel').removeClass('hidden');
        $('#topic-unlist-input').val({{$topic->is_unlisted}}).removeClass('hidden');
        $('#topic-end-time-input').data('DateTimePicker').minDate(moment().add(10, 'minutes'));
        $('#topic-end-time-input').removeClass('hidden');
        $('#topic-attr-update').removeClass('hidden');
        
        $(this).attr('id', 'topic-attr-edit-cancel').blur();

    }).on('click', '#topic-attr-edit-cancel', function(e) {
        $('.topic-attr').removeClass('hidden');
        $('#topic-unlist-input').addClass('hidden');
        $('#topic-end-time-input').addClass('hidden');
        $('#topic-attr-update').addClass('hidden');
        
        $(this).attr('id', 'topic-attr-edit').blur();

    }).on('click', '#topic-attr-update', function(e) {
        $.post('/topics/' + String({{$topic->id}}) + '/update',
        {
            '_token' : '{{ csrf_token() }}',
            'type' : 'attr',
            'close_at' : $('#topic-end-time-input').data('DateTimePicker').date().format('YYYY-MM-DD HH:mm:ss'),
            'is_unlisted' : $('#topic-unlist-input').val()
        }, function(data) {
            window.location = "/topics/{{$topic->id}}";
        }).error(function(data) {
            $('.topic-attr').removeClass('hidden');
            $('#topic-unlist-input').addClass('hidden');
            $('#topic-end-time-input').addClass('hidden');
            $('#topic-attr-edit-cancel').attr('id', 'topic-attr-edit').blur();
            $(this).addClass('hidden');
            
            // TODO : add more complicated error message here.
            $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
            $('#error-modal').modal('show');
        });
    });

    // Handlers for edit question set
    $(document).on('click', '#qs-edit', function(e) {
        $('.qs-edit-control').removeClass('hidden');
        $(document).off('click', '.option');

        $(this).attr('id', 'qs-edit-cancel').blur();

    }).on('click', '#qs-edit-cancel', function(e) {
        $('.new-qs-entry').remove();
        $('.qs-edit-control').addClass('hidden');
        $('.qs-entry-toDel').css('opacity', '1').removeClass('qs-entry-toDel');
        $(document).on('click', '.option', vote_action);

        $(this).attr('id', 'qs-edit').blur();

    }).on('click', '#qs-update', function(e) {
        $('.qs-edit-control').addClass('hidden');
        $(document).on('click', '.option', vote_action);

        $('#qs-edit-cancel').attr('id', 'qs-edit').blur();

    }).on('click', '#qs-add', function(e) {
        var newEntry = $('.new-qs-entry-template');
        newEntry.clone()
                .insertAfter(newEntry)
                .removeClass('hidden')
                .removeClass('new-qs-entry-template')
                .addClass('new-qs-entry')

    }).on('click', '.new-qs-remove', function(e) {
        $(this).parents('.new-qs-entry').remove();

    }).on('click', '.qs-remove', function(e) {
        if($(this).parents('.qs-entry').hasClass('qs-entry-toDel')) {
            $(this).parents('.qs-entry').css('opacity', '1').removeClass('qs-entry-toDel');
        }
        else {
            $(this).parents('.qs-entry').css('opacity', '0.5').addClass('qs-entry-toDel');
        }
    });

    // Handlers for delete topic
    $(document).on('click', '#topic-delete', function(e) {
        $('#delete-modal').modal('show');
    });
@endcan
// register handlers for ballot querying and question sets loading.
    $(document).on('click', '.not-anonymous', function(e) {
        e.stopPropagation();

        var option = $(this).parents('.option');
        var qs_id = option.parents('.qs-entry').index() + 1;
        var opt_id = $('.qs-entry:nth(' + String(qs_id - 1) + ') .option').index(option) + 1;

        $.post('/topics/' + String({{$topic->id}}) + '/ballot',
        {
            '_token' : '{{ csrf_token() }}',
            'qsid' : qs_id,
            'optid' : opt_id
        }, function(data) {
            $('#ballot-modal .list-group .list-group-item').remove();

            var template = $('#ballot-modal .list-group-item:first');
            for(var idx in data) {
                template.clone().removeClass('hidden').appendTo(template.siblings('.list-group')).find('a').html(data[idx]['name']);
            }
        }).error(function(data) {
            // TODO : add more complicated error message here.
            $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
            $('#error-modal').modal('show');
        });

        $('#ballot-modal').modal('show');
    });
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
        if(!data['question_set']['is_anonymous']){
            entry.find('.option-template .badge').addClass('not-anonymous');
        }
        entry.find('.qs-vis').val(data['question_set']['result_visibility']);

        entry.find('.option').remove();
        for(var opt_idx = 0; opt_idx < data['options'].length; ++opt_idx) {
            var newOption = entry.find('.option-template').clone();
            var option = data['options'][opt_idx];

            newOption.removeClass('hidden').removeClass('option-template').addClass('option');
            newOption.children('label').text(option['content']);
            newOption.appendTo(entry.find('ul'));
        }

        // If user is logged in, load the votes and change the color
    @if(Auth::check())
        for(var ballot_idx = 0; ballot_idx < data['user_ballot'].length; ++ballot_idx) {
            entry.find('.option:nth(' + String(data['user_ballot'][ballot_idx]['option_id'] - 1) +')').addClass('list-group-item-info');
        }
    @endif
        // Set badge
        for(var ballot_count_idx = 0; ballot_count_idx < data['all_ballots'].length; ++ballot_count_idx) {
            entry.find('.badge:nth(' + String(data['all_ballots'][ballot_count_idx]['option_id']) + ')').html(data['all_ballots'][ballot_count_idx]['count']);
        }
    }).error(function(data) {
        // TODO : add more complicated error message here.
        $('#error-modal .modal-body p').html("Some error occured while loading question sets! Please try again later.");
        $('#error-modal').modal('show');
    });
}
</script>
@endsection