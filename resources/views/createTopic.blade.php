@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1> {{ $name }} </h1>
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('views.qs') }}
                </div>
                <div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-1">
                            <label class="control-label">{{ trans('views.description') }}</label>
                        </div>
                        <div class="col-md-8">
                            <textarea id="description" class="form-control" style="resize:none"></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-1">
                            <label class="control-label">{{ trans('views.end_time') }}</label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="new-qs-attrs hidden">
                        <div class="row form-group">
                            <div class="col-md-1">
                                <label class="control-label">{{ trans('views.attrs') }}</label>
                            </div>
                            <div class="col-md-11">
                                <div class="checkbox col-md-12">
                                    <label>
                                        <input class="new-qs-mult" type="checkbox" value=""/>
                                        {{ trans('views.multiple_choice') }}
                                    </label>
                                </div>
                                <div class="checkbox col-md-12">
                                    <label>
                                        <input class="new-qs-anonymous" type="checkbox" value=""/>
                                        {{ trans('views.anonymous') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-1">
                                <label class="control-label">{{ trans('views.result_visibility') }}</label>
                            </div>
                            <div class="col-md-3">
                                <select class="new-qs-vis form-control">
                                    <option value="VISIBLE">{{ trans('views.visible') }}</option>
                                    <option value="INVISIBLE">{{ trans('views.invisible') }}</option>
                                    <option value="VISIBLE_AFTER_ENDED">{{ trans('views.visible_after_end') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="checkbox col-md-12">
                            <label>
                                <input id="unlisted" type="checkbox" value=""/>
                                {{ trans('views.unlisted') }}
                            </label>
                        </div>
                        <div class="checkbox col-md-12">
                            <label>
                                <input id="same-attr" type="checkbox" value=""/>
                                {{ trans('views.same_attr') }}
                            </label>
                        </div>
                    </div>

                    @include('newQsTemplate')

                    <div class="qs-controls">
                    </div>

                    <div class="form-group">
                        <div class="col-md-1">
                            <button class="btn btn-primary qs-add">
                                {{ trans('views.add_qs') }}
                            </button>
                        </div>
                        <div class="col-md-1 col-md-offset-4">
                            <button class="btn btn-success btn-submit">
                                {{ trans('views.create') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function()
{
    // Register handlers
    $('#datetimepicker').datetimepicker({
        format : 'YYYY-MM-DD HH:mm:ss',
        minDate : moment().add(10, 'minutes')
    });

    $(document).on('click', '.qs-add', function(e) {
        e.preventDefault();

        var controlForm = $('.qs-controls:first')
        var newEntry = $($('.new-qs-entry-template').clone()).removeClass('hidden').appendTo(controlForm);

        newEntry.removeClass('new-qs-entry-template')
                .addClass('new-qs-entry')

        // If same-attr is checked , don't show qs-attrs
        if($('#same-attr')[0].checked) {
            newEntry.find('.new-qs-attrs').addClass('hidden')
        }

    }).on('click', '.new-qs-remove', function(e) {
        $(this).parents('.new-qs-entry').remove();
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
        e.preventDefault();
        return false;
    });

    $(document).on('change', '#same-attr', function(e) {
        e.preventDefault();

        if($(this)[0].checked) {
            $('.new-qs-attrs:first').removeClass('hidden');
            $('.new-qs-entry .new-qs-attrs').addClass('hidden');
        }
        else {
            $('.new-qs-attrs:first').addClass('hidden');
            $('.new-qs-entry .new-qs-attrs').removeClass('hidden');
        }
    });

    // Add the first quesetion set and remove the remove button
    $('.qs-add').trigger('click');
    $('.new-qs-remove:last').remove();

    // If same-attr is checked by autocomplete, show the general qs-attrs
    if($('#same-attr')[0].checked) {
        $('.new-qs-attrs:first').removeClass('hidden');
    }

    $(document).on('click', '.btn-submit', function(e) {
        var data = [];
        var qs_cnt = $('.new-qs-entry').length;

        // TODO : rewrite with .index()
        for(var i = 1; i <= qs_cnt; ++i) {
            var name = $('.new-qs-entry:nth-child(' + String(i) + ') .new-qs-name').val();
            var type = $('.new-qs-entry:nth-child(' + String(i) + ') .new-qs-type').val();

            var is_multiple_choice, is_anonymous, result_visibility;
            if($('#same-attr')[0].checked) {
                is_multiple_choice = $('.new-qs-attrs:first .new-qs-mult').is(':checked') ? 1 : 0;
                is_anonymous = $('.new-qs-attrs:first .new-qs-anonymous').is(':checked') ? 1 : 0;
                result_visibility = $('.new-qs-attrs:first .new-qs-vis').val();
            }
            else {
                is_multiple_choice = $('.new-qs-entry:nth-child(' + String(i) + ') .new-qs-mult').is(':checked') ? 1 : 0;
                is_anonymous = $('.new-qs-entry:nth-child(' + String(i) + ') .new-qs-anonymous').is(':checked') ? 1 : 0;
                result_visibility = $('.new-qs-entry:nth-child(' + String(i) + ') .new-qs-vis').val();
            }
            var opts = [];

            var opt_cnt = $('.new-qs-entry:nth-child(' + String(i) + ') .opt-entry').length;
            for(var j = 1; j <= opt_cnt; ++j) {
                opts.push($('.new-qs-entry:nth-child(' + String(i) + ') .opt-entry:nth-child(' + String(j) + ') .new-qs-opt').val());
            }

            data.push(
            {
                'name' : name,
                'type' : type,
                'is_multiple_choice' : is_multiple_choice,
                'is_anonymous' : is_anonymous,
                'result_visibility' : result_visibility,
                'opts' : opts
            });
        }
        var jqxhr = $.post('/topics/store',
        {
            '_token' : '{{ csrf_token() }}',
            'data' : data,
            'name' : '{{ $name }}',
            'description' : $('#description').val(),
            'is_unlisted' : $('#unlisted').is(':checked') ? 1 : 0,
            'close_at' : $('#datetimepicker').data('DateTimePicker').date().format('YYYY-MM-DD HH:mm:ss')
        }, function(returned_id) {
            window.location = '{{ url('topics') }}/' + String(returned_id)
        });

        // Has to replaced with a more friendly and integrated error message.
        jqxhr.error(function(data) { alert('Some field is empty'); });
    });
});
</script>
@endsection
