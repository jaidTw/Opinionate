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
                    {{ trans('views.save') }}
                </button>
            </div>
            <div class="col-md-1">
                <button id="topic-name-edit" type="button" class="btn btn-primary btn-lg">
                    <span class="glyphicon glyphicon-pencil"> </span>
                </button>
            </div>
        @else
            <div class="col-md-2"></div>
        @endcan
        @can('delete-topic', $topic)
            <div class="col-md-1">
                <button id="topic-delete" type="button" class="btn btn-danger btn-lg">
                    {{ trans('views.delete_topic') }}
                </button>
            </div>
        @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3> {{ trans('views.description') }}
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
                                {{ trans('views.save') }}
                            </button>
                        </div>
                    </div>
                @endcan
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{ trans('views.qs') }}
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
                    <div id="new-qs-control">
                        @include('newQsTemplate')
                    </div>

                    <div class="row">
                        <div class="col-md-1">
                            <button id="qs-add" class="btn btn-primary qs-edit-control hidden">
                                {{ trans('views.add_qs') }}
                            </button>
                        </div>
                        <div class="col-md-1 col-md-offset-9">
                            <button id="qs-update" class="btn btn-success qs-edit-control hidden">
                                {{ trans('views.save') }}
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
                    <h3>{{ trans('views.topic_info') }}
                    @can('update-topic', $topic)
                        <button id="topic-attr-edit" type="button" class="close">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                    @endcan
                    </h3>
                </div>
                <div class="panel-body">
                    <h3>{{ trans('views.proposer') }}</h3>
                    <p> <a href="{{ url('home/' . $proposer->id) }}">{{ $proposer->name }}</a> </p>

                    <h3>{{ trans('views.unlisted') }}</h3>
                    <p class="topic-attr"> {{ $topic->is_unlisted ? trans('views.yes') : trans('views.no') }} </p>
                @can('update-topic', $topic)
                    <select id="topic-unlist-input" class="form-control hidden">
                        <option value="0">{{ trans('views.no') }}</option>
                        <option value="1">{{ trans('views.yes') }}</option>
                    </select>
                @endcan

                    <h3>{{ trans('views.end_time') }}
                        @can('update-topic', $topic)
                        <button id="end_now" class="btn btn-danger btn-sm">{{ trans('views.end_now') }}</button>
                        @endcan
                    </h3>
                    <p class="topic-attr"> {{ $topic->close_at }} </p>
                @can('update-topic', $topic)
                    <div class='input-group date hidden' id='topic-end-time-input'>
                        <input type='text' class="form-control"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                @endcan

                    <h3>{{ trans('views.created_time') }}</h3>
                    <p> {{ $topic->created_at }} </p>

                    <h3> {{ trans('views.last_edit_time') }} </h3>
                    <p id="updated-at"> {{ $topic->updated_at }} </p>
                @can('update-topic', $topic)
                    <div class="col-md-1 col-md-offset-9">
                        <button id="topic-attr-update" class="btn btn-success hidden">
                            {{ trans('views.save') }}
                        </button>
                    </div>
                @endcan
                </div>
            </div>
        </div>
    </div>
    <div id="disqus_thread"></div>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
</div>

@can('update-topic', $topic)
<div id="error-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{ trans('views.close') }}</span>
                </button>
                <h4 class="modal-title">{{ trans('views.oops') }}</h4>
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
                    <span class="sr-only">{{ trans('views.close') }}</span></button>
                <h4 class="modal-title">{{ trans('views.warning') }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            {{ trans('views.delete_warning_message') }}
                        </p>
                    </div>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/topics/' . $topic->id . '/destroy') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 col-md-offset-4">
                            <button class="btn submit btn-primary">
                                {{ trans('views.confirm') }}
                            </button>
                            <button class="btn btn-default" data-dismiss="modal">
                                {{ trans('views.cancel') }}
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
                    <span class="sr-only">{{ trans('views.close') }}</span></button>
                <h4 class="modal-title">{{ trans('views.ballot') }}</h4>
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

@if(Auth::check())
// If user is logged in
    @can('vote', $topic)
    // And ended time is not pass.
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
                }).error(function(data) {
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
    @endcan
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
        minDate : moment().add(5, 'minutes'),
        defaultDate : moment().add(10, 'minutes').isAfter('{{$topic->close_at}}') ?
            moment().add(10, 'minutes') : '{{$topic->close_at}}'
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
            // TODO : add more complicated error message here.
            $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
            $('#error-modal').modal('show');
        });
    }).on('click', '#end_now', function(e) {
        $.post('/topics/' + String({{$topic->id}}) + '/update',
        {
            '_token' : '{{ csrf_token() }}',
            'type' : 'attr',
            'close_at' : moment().format("YYYY-MM-DD HH:mm:ss")
        }, function(data) {
            window.location = "/topics/{{$topic->id}}";
        }).error(function(data) {
            // TODO : add more complicated error message here.
            $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
            $('#error-modal').modal('show');
        });
    });

    // Handlers for edit question set
    $(document).on('click', '#qs-edit', function(e) {
        $('.view-chart').addClass('hidden');
        $('.qs-edit-control').removeClass('hidden');
        $(document).off('click', '.option');

        $(this).attr('id', 'qs-edit-cancel').blur();

    }).on('click', '#qs-edit-cancel', function(e) {
        $('.new-qs-entry').remove();
        $('.qs-edit-control').addClass('hidden');
        $('.view-chart').removeClass('hidden');
        $('.qs-entry-toDel').css('opacity', '1').removeClass('qs-entry-toDel');
        $(document).on('click', '.option', vote_action);

        $(this).attr('id', 'qs-edit').blur();

    }).on('click', '#qs-add', function(e) {
        var newEntry = $('.new-qs-entry-template');
        newEntry.clone()
                .appendTo($('#new-qs-control'))
                .removeClass('hidden')
                .removeClass('new-qs-entry-template')
                .addClass('new-qs-entry');

    }).on('click', '.new-qs-remove', function(e) {
        $(this).parents('.new-qs-entry').remove();

    }).on('click', '.qs-remove', function(e) {
        if($(this).parents('.qs-entry').hasClass('qs-entry-toDel')) {
            $(this).parents('.qs-entry').css('opacity', '1').removeClass('qs-entry-toDel');
        }
        else {
            $(this).parents('.qs-entry').css('opacity', '0.5').addClass('qs-entry-toDel');
        }

    }).on('click', '#qs-update', function() {
        var del_list = [];
        var alter_list = [];
        var new_list = [];

        $('.qs-entry').each(function(index) {
            if($(this).hasClass('qs-entry-toDel')) {
                del_list.push(index + 1);
            }
            else {
                var opts = [];
                if($(this).find('.panel-footer label').hasClass('new-opt-hide')) {
                    $(this).find('.new-qs-opt').each(function () {
                        opts.push($(this).val());
                    });
                }

                alter_list.push({
                    'id' : index + 1,
                    'result_visibility' : $(this).find('.qs-vis').val(),
                    'opts' : opts
                });
            }
        });

        $('.new-qs-entry').each(function() {
            var entry = $(this);
            var opts = [];
            $(this).find('.new-qs-opt').each(function() {
                opts.push($(this).val());
            });
            new_list.push({
                'name' : entry.find('.new-qs-name').val(),
                'type' : entry.find('.new-qs-type').val(),
                'is_multiple_choice' : entry.find('.new-qs-mult').is(':checked') ? 1 : 0,
                'is_anonymous' : entry.find('.new-qs-anonymous').is(':checked') ? 1 : 0,
                'result_visibility' : entry.find('.new-qs-vis').val(),
                'opts' : opts
            });
        });

        $.post('/topics/' + String({{$topic->id}}) + '/update',
        {
            '_token' : '{{ csrf_token() }}',
            'type' : 'qs',
            'del' : del_list,
            'alter' : alter_list,
            'new' : new_list
        }, function(data) {
            window.location = "/topics/{{$topic->id}}";
        }).error(function(data) {
            // TODO : add more complicated error message here.
            $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
            $('#error-modal').modal('show');
        });
    });

    $(document).on('click', '.new-opt-show', function(e) {
        $(this).find('.glyphicon').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top');
        $(this).removeClass('new-opt-show').addClass('new-opt-hide')
        $(this).siblings('.panel-collapse').collapse('show');

    }).on('click', '.new-opt-hide', function(e) {
        $(this).find('.glyphicon').removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom');
        $(this).removeClass('new-opt-hide').addClass('new-opt-show')
        $(this).siblings('.panel-collapse').collapse('hide');
    });

    $(document).on('click', '.opt-add', function(e) {
        e.preventDefault();

        var controlForm = $(this).parents('.opt-controls:first');
        var currentEntry = $(this).parents('.opt-entry:first');
        var newEntry = $(currentEntry.clone()).appendTo(controlForm);

        // Clean the value of the new option add setup button
        newEntry.find('input').val('');
        controlForm.find('.opt-entry:not(:last) .opt-add')
            .removeClass('opt-add').addClass('opt-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');

    }).on('click', '.opt-remove', function(e) {
        $(this).parents('.opt-entry:first').remove();
    });
    // Handlers for delete topic
    $(document).on('click', '#topic-delete', function(e) {
        $('#delete-modal').modal('show');
    });
@endcan
// handlers for charts
    $(document).on('click', '.chart-show', function(e) {
        $(this).find('.glyphicon').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top');
        $(this).removeClass('chart-show').addClass('chart-hide');
        $(this).siblings('.panel-collapse').collapse('show');
        var type = $(this).siblings('.chart-controls').find('input:checked').val()
        var ctx = $(this).siblings('.chart-controls').find('.qs-chart');
        var chart_data = ctx.data('chart');
        var options = {}
        if(type == 'bar') {
            options.scales = {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                    }
                }]
            }
        }
        else if(type == 'polarArea') {
            options.scale = {
                ticks: {
                    maxTicksLimit: 5
                }
            }
        }
        var chart = new Chart(ctx, {
            type: type,
            data: {
                labels: chart_data.options,
                datasets: [{
                    data: chart_data.counts,
                    label: '# of votes',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ]
                }]
            },
            options: options
        });
        ctx.data('chart-object', chart);

    }).on('click', '.chart-hide', function(e) {
        $(this).find('.glyphicon').removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom');
        $(this).removeClass('chart-hide').addClass('chart-show')
        $(this).siblings('.panel-collapse').collapse('hide');

    }).on('click', ".chart-type-opt input[type='radio']", function(e) {
        var ctx = $(this).parents('.chart-type').siblings('.qs-chart')
        var chart = ctx.data('chart-object');
        var chart_data = ctx.data('chart');
        var options = {}
        var type = $(this).val()
        if(type == 'bar') {
            options.scales = {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                    }
                }]
            }
        }
        else if(type == 'polarArea') {
            options.scale = {
                ticks: {
                    maxTicksLimit: 5
                }
            }
        }
        chart.destroy();
        chart = new Chart(ctx, {
            type: type,
            label: '# of votes',
            data: {
                labels: chart_data.options,
                datasets: [{
                    data: chart_data.counts,
                    label: '# of votes',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ]
                }]
            },
            options: options
        });
        chart.update();
        ctx.data('chart-object', chart);
    });


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
                template.clone()
                        .removeClass('hidden')
                        .appendTo(template.siblings('.list-group'))
                        .find('a')
                        .html('<a href="/home/'+data[idx]['id']+'">'+data[idx]['name']+'</a>');
            }
        }).error(function(data) {
            // TODO : add more complicated error message here.
            $('#error-modal .modal-body p').html("Some error occured! Please try again later.");
            $('#error-modal').modal('show');
        });

        $('#ballot-modal').modal('show');
    });

    var disqus_config = function () {
        this.page.url = {!! '\''.Request::url().'\'' !!};
        this.page.identifier = {!! '\''.$topic->id.'\'' !!};
    };
    (function() {
        var d = document, s = d.createElement('script');
        s.src = '//opinionate-ntnu.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
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

            newOption.children('label').text(option['content']);
            newOption.removeClass('hidden')
                     .removeClass('option-template')
                     .addClass('option')
                     .appendTo(entry.find('ul'));
        }

        // If user is logged in, load the votes and change the color
    @if(Auth::check())
        for(var ballot_idx = 0; ballot_idx < data['user_ballot'].length; ++ballot_idx) {
            entry.find('.option:nth(' + String(data['user_ballot'][ballot_idx]['option_id'] - 1) +')').addClass('list-group-item-info');
        }
    @endif
        // Set badge
        if(typeof data['all_ballots'] != 'undefined') {
            for(var ballot_count_idx = 0; ballot_count_idx < data['all_ballots'].length; ++ballot_count_idx) {
                entry.find('.badge:nth(' + String(data['all_ballots'][ballot_count_idx]['option_id']) + ')').html(data['all_ballots'][ballot_count_idx]['count']);
            }

            entry.find('.view-chart').removeClass('hidden');

            var options = []
            for(var idx = 0; idx < data['options'].length; ++idx) {
                options.push(data['options'][idx]['content']);
            }
            var counts = new Array(options.length)
            counts.fill(0)
            for(var idx = 0; idx < data['all_ballots'].length; ++idx) {
                counts[data['all_ballots'][idx]['option_id'] - 1] = data['all_ballots'][idx]['count'];
            }

            entry.find('.qs-chart').data('chart', {
                name : data['question_set']['name'],
                options : options,
                counts : counts
            });
            entry.find("input:checked").click();
        }
    }).error(function(data) {
        // TODO : add more complicated error message here.
        $('#error-modal .modal-body p').html("Some error occured while loading question sets! Please try again later.");
        $('#error-modal').modal('show');
    });
}
</script>
@endsection
