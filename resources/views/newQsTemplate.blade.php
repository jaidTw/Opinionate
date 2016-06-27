<div class="new-qs-entry-template panel panel-default hidden">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-4">
                <input class="new-qs-name form-control" type="text" placeholder="Question Set Name"/>
            </div>
            <div class="col-md-1 col-md-offset-7">
                <button type="button" class="close new-qs-remove">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row form-group">
            <div class="col-md-2">
                <label class="control-label">{{ trans('views.type') }}</label>
            </div>
            <div class="col-md-3">
                <select class="new-qs-type form-control">
                    <option value="GENERAL">{{ trans('views.general') }}</option>
                    <option value="LOCATION">{{ trans('views.location') }}</option>
                    <option value="TIME">{{ trans('views.time') }}</option>
                    <option value="IMAGE">{{ trans('views.image') }}</option>
                    <option value="AUDIO">{{ trans('views.audio') }}</option>
                    <option value="VIDEO">{{ trans('views.video') }}</option>
                </select>
            </div>
        </div>

        <div class="new-qs-attrs">
            <div class="row form-group">
                <div class="col-md-2">
                    <label class="control-label">{{ trans('views.attrs') }}</label>
                </div>
                <div class="col-md-10">
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
                <div class="col-md-2">
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
            <div class="col-md-2">
                <label class="control-label">{{ trans('views.options') }}</label>
            </div>

            <div class="col-md-10 opt-controls">
                <div class="opt-entry col-md-6 input-group form-group">
                    <input class="new-qs-opt form-control" type="text"/>
                    <span class="input-group-btn">
                        <button class="btn btn-success opt-add" type="button">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
