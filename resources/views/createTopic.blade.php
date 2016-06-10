@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1> {{ $name }} </h1>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Question Sets
                </div>
                <div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-1">
                            <label class="control-label">Description</label>
                        </div>
                        <div class="col-md-8">
                            <textarea id="description" class="form-control" style="resize:none"></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-1">
                            <label class="control-label">End Time</label>
                        </div>
                        <div class="col-md-3">
                            <input id="end-time" class="form-control" type="text"/>
                        </div>
                    </div>

                    <div class="qs-attrs hidden">
                        <div class="row form-group">
                            <div class="col-md-1">
                                <label class="control-label">Attributes</label>
                            </div>
                            <div class="col-md-11">
                                <div class="checkbox col-md-12">
                                    <label>
                                        <input class="qs-mult" type="checkbox" value=""/>
                                        Multiple Choice
                                    </label>
                                </div>
                                <div class="checkbox col-md-12">
                                    <label>
                                        <input class="qs-sync" type="checkbox" value=""/>
                                        Synchronized
                                    </label>
                                </div>
                                <div class="checkbox col-md-12">
                                    <label>
                                        <input class="qs-anonymous" type="checkbox" value=""/>
                                        Anonymous
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-1">
                                <label class="control-label">Result Visbility</label>
                            </div>
                            <div class="col-md-3">
                                <select class="qs-vis form-control">
                                    <option>Visible</option>
                                    <option>Invisible</option>
                                    <option>Visible after ended</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="checkbox col-md-12">
                            <label>
                                <input id="unlisted" type="checkbox" value=""/>
                                Unlisted
                            </label>
                        </div>
                        <div class="checkbox col-md-12">
                            <label>
                                <input id="same-attr" type="checkbox" value=""/>
                                Use same attribute for all question Sets.
                            </label>
                        </div>
                    </div>

                    <div class="qs-entry-template panel panel-default" hidden>
                        <div class="panel-heading"> 
                            <div class="row">
                                <div class="col-md-4">
                                    <input class="qs-name form-control" type="text" placeholder="Question Set Name"/>
                                </div>
                                <div class="col-md-1 col-md-offset-7">
                                    <button type="button" class="close btn-qs-remove">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>                    
                        <div class="panel-body">
                            <div class="row form-group">
                                <div class="col-md-1">
                                    <label class="control-label">Type</label>
                                </div>
                                <div class="col-md-3">
                                    <select class="qs-type form-control">
                                        <option>General</option>
                                        <option>Location</option>
                                        <option>Time</option>
                                        <option>Image</option>
                                        <option>Audio</option>
                                        <option>Video</option>
                                    </select>
                                </div>
                            </div>

                            <div class="qs-attrs">
                                <div class="row form-group">
                                    <div class="col-md-1">
                                        <label class="control-label">Attributes</label>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="checkbox col-md-12">
                                            <label>
                                                <input class="qs-mult" type="checkbox" value=""/>
                                                Multiple Choice
                                            </label>
                                        </div>
                                        <div class="checkbox col-md-12">
                                            <label>
                                                <input class="qs-sync" type="checkbox" value=""/>
                                                Synchronized
                                            </label>
                                        </div>
                                        <div class="checkbox col-md-12">
                                            <label>
                                                <input class="qs-anonymous" type="checkbox" value=""/>
                                                Anonymous
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-1">
                                        <label class="control-label">Result Visbility</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="qs-vis form-control">
                                            <option>Visible</option>
                                            <option>Invisible</option>
                                            <option>Visible after ended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-1">
                                    <label class="control-label">Options</label>
                                </div>

                                <div class="col-md-10 opt-controls">
                                    <div class="opt-entry col-md-6 input-group form-group">
                                        <input class="qs-opt form-control" type="text"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-success btn-opt-add" type="button">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="qs-controls">
                    </div>


                    <div class="form-group">
                        <div class="col-md-1">
                            <button class="btn btn-primary btn-qs-add">
                                Add Question Set
                            </button>
                        </div>
                        <div class="col-md-1 col-md-offset-4">
                            <button class="btn btn-primary btn-submit">
                                Create
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
    $(document).on('click', '.btn-qs-add', function(e) {
        e.preventDefault();

        var controlForm = $('.qs-controls:first')
        var newEntry = $($('.qs-entry-template').clone()).appendTo(controlForm);

        newEntry.removeAttr('hidden')
                .removeClass('qs-entry-template')
                .addClass('qs-entry')

        // If same-attr is checked , don't show qs-attrs
        if($('#same-attr')[0].checked) {
            newEntry.find('.qs-attrs').addClass('hidden')
        }
    }).on('click', '.btn-qs-remove', function(e) {
        $(this).parents('.qs-entry:first').remove();
        e.preventDefault();
        return false;
    });

    $(document).on('click', '.btn-opt-add', function(e) {
        e.preventDefault();

        var controlForm = $(this).parents('.opt-controls:first');
        var currentEntry = $(this).parents('.opt-entry:first');
        var newEntry = $(currentEntry.clone()).appendTo(controlForm);

        // Clean the value of the new option add setup button
        newEntry.find('input').val('');
        controlForm.find('.opt-entry:not(:last) .btn-opt-add')
            .removeClass('btn-opt-add').addClass('btn-opt-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');

    }).on('click', '.btn-opt-remove', function(e) {
        $(this).parents('.opt-entry:first').remove();
        e.preventDefault();
        return false;
    });

    $(document).on('change', '#same-attr', function(e) {
        e.preventDefault();

        if($(this)[0].checked) {
            $('.qs-attrs:first').removeClass('hidden');
            $('.qs-entry .qs-attrs').addClass('hidden');
        }
        else {
            $('.qs-attrs:first').addClass('hidden');
            $('.qs-entry .qs-attrs').removeClass('hidden');
        }
    });

    // Add the first quesetion set and remove the remove button
    $('.btn-qs-add').trigger('click');
    $('.btn-qs-remove:last').remove();

    // If same-attr is checked by autocomplete, show the general qs-attrs
    if($('#same-attr')[0].checked) {
        $('.qs-attrs:first').removeClass('hidden');
    }

    $(document).on('click', '.btn-submit', function(e) {
        var data = [];
        var qs_cnt = $('.qs-entry').length;

        for(var i = 1; i <= qs_cnt; ++i) {
            var name = $('.qs-entry:nth-child(' + String(i) + ') .qs-name').val();
            var type = $('.qs-entry:nth-child(' + String(i) + ') .qs-type').val();

            var is_multiple_choice, is_synced, is_anonymous, result_visibility;
            if($('#same-attr')[0].checked) {
                is_multiple_choice = $('.qs-attrs:first .qs-mult').is(':checked') ? 1 : 0;
                is_synced = $('.qs-attrs:first .qs-sync').is(':checked') ? 1 : 0;
                is_anonymous = $('.qs-attrs:first .qs-anonymous').is(':checked') ? 1 : 0;
                result_visibility = $('.qs-attrs:first .qs-vis').val();
            }
            else {
                is_multiple_choice = $('.qs-entry:nth-child(' + String(i) + ') .qs-mult').is(':checked') ? 1 : 0;
                is_synced = $('.qs-entry:nth-child(' + String(i) + ') .qs-sync').is(':checked') ? 1 : 0;
                is_anonymous = $('.qs-entry:nth-child(' + String(i) + ') .qs-anonymous').is(':checked') ? 1 : 0;
                result_visibility = $('.qs-entry:nth-child(' + String(i) + ') .qs-vis').val();   
            }
            var opts = [];

            var opt_cnt = $('.qs-entry:nth-child(' + String(i) + ') .opt-entry').length;
            for(var j = 1; j <= opt_cnt; ++j) {
                opts.push($('.qs-entry:nth-child(' + String(i) + ') .opt-entry:nth-child(' + String(j) + ') .qs-opt').val());
            }

            data.push(
            {
                'name' : name,
                'type' : type,
                'is_multiple_choice' : is_multiple_choice,
                'is_synced' : is_synced,
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
                'close_at' : 0
            }, function(returned_id) {
            window.location = '{{ url('topics') }}/' + String(returned_id)
        });

        // Has to replaced with a more friendly and integrated error message.
        jqxhr.error(function(data) { alert('Some field is empty'); });
    });
});
</script>
@endsection