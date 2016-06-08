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

                    <div class="qs-entry-template panel panel-default" hidden>
                        <div class="panel-heading"> 
                            <div class="row">
                                <div class="col-md-4">
                                    <input class="qs-name form-control" name="qs-name[]" type="text" class="form-control" placeholder="Question Set Name"/>
                                </div>
                                <div class="col-md-1 col-md-offset-7">
                                    <button type="button" class="close btn-qs-remove">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                </div>
                            </div>
                        </div>                    
                        <div class="panel-body">
                            <div class="row form-group">
                                <div class="col-md-1">
                                    <label class="col-md-4 control-label">Type</label>
                                </div>
                                <div class="col-md-3">
                                    <select class="qs-type form-control" name="qs-type[]" class="form-control">
                                        <option>General</option>
                                        <option>Location</option>
                                        <option>Time</option>
                                        <option>Photo</option>
                                    </select>
                                </div>
                            </div>                    
                            <div class="col-md-1">
                                <label class="control-label">Options</label>
                            </div>                    
                            <div class="row form-group">
                                <div class="col-md-4 opt-controls">
                                    <div class="opt-entry input-group form-group">
                                        <input class="qs-opt form-control" name="fields[]" type="text"/>
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
                        <div class="qs-entry panel panel-default">
                            <div class="panel-heading"> 
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="qs-name form-control" name="qs-name[]" type="text" class="form-control" placeholder="Question Set Name"/>
                                    </div>
                                </div>
                            </div>
    
                            <div class="panel-body">
                                <div class="row form-group">
                                    <div class="col-md-1">
                                        <label class="col-md-4 control-label">Type</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="qs-type form-control" name="qs-type[]" class="form-control">
                                            <option>General</option>
                                            <option>Location</option>
                                            <option>Time</option>
                                            <option>Photo</option>
                                        </select>
                                    </div>
                                </div>
    
                                <div class="col-md-1">
                                    <label class="control-label">Options</label>
                                </div>
    
                                <div class="row form-group">
                                    <div class="col-md-4 opt-controls">
                                        <div class="opt-entry input-group form-group">
                                            <input class="qs-opt form-control" name="fields[]" type="text"/>
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
                    </div>

                    <button class="btn btn-primary btn-qs-add">
                        Add Question Set
                    </button>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
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
    $(document).on('click', '.btn-opt-add', function(e)
    {
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

    }).on('click', '.btn-opt-remove', function(e)
    {
        $(this).parents('.opt-entry:first').remove();
        e.preventDefault();
        return false;
    });

    $(document).on('click', '.btn-qs-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.qs-controls:first')
        var newEntry = $($('.qs-entry-template').clone()).appendTo(controlForm);

        newEntry.removeAttr('hidden')
                .removeClass('qs-entry-template')
                .addClass('qs-entry')
    }).on('click', '.btn-qs-remove', function(e)
    {
        $(this).parents('.qs-entry:first').remove();
        e.preventDefault();
        return false;
    });

    $(document).on('click', '.btn-submit', function(e) {
        var data = [];
        var qs_cnt = $('.qs-entry').length;
        for(var i = 1; i <= qs_cnt; ++i) {
            var name = $('.qs-entry:nth-child(' + String(i) + ') .qs-name').val();
            var type = $('.qs-entry:nth-child(' + String(i) + ') .qs-type').val();
            var opts = [];

            var opt_cnt = $('.qs-entry:nth-child(' + String(i) + ') .opt-entry').length;
            for(var j = 1; j <= opt_cnt; ++j) {
                opts.push($('.qs-entry:nth-child(' + String(i) + ') .opt-entry:nth-child(' + String(j) + ') .qs-opt').val());
            }

            data.push({
                'name' : name,
                'type' : type,
                'is_multiple_choice' : false,
                'is_synced' : false,
                'is_anonymous' : false,
                'result_visibility' : false,
                'close_at' : 0,
                'visualization' : 0,
                'opts' : opts
            });
        }
        var jqxhr = $.post('/topics/store',
            {
                '_token' : '{{ csrf_token() }}',
                'data' : data,
                'name' : '{{ $name }}',
                'description' : 'D',
                'is_unlisted' : 0,
                'is_same_attr' : 0
            }, function(data) {
            window.location = '{{ url('topics') }}'
        });

        // Has to replaced with a more friendly and integrated error message.
        jqxhr.error(function(data) { alert('Some field is empty'); });
    });
});
</script>
@endsection