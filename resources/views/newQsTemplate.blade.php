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
            <div class="col-md-1">
                <label class="control-label">Type</label>
            </div>
            <div class="col-md-3">
                <select class="new-qs-type form-control">
                    <option value="GENERAL">General</option>
                    <option value="LOCATION">Location</option>
                    <option value="TIME">Time</option>
                    <option value="IMAGE">Image</option>
                    <option value="AUDIO">Audio</option>
                    <option value="VIDEO">Video</option>
                </select>
            </div>
        </div>

        <div class="new-qs-attrs">
            <div class="row form-group">
                <div class="col-md-1">
                    <label class="control-label">Attributes</label>
                </div>
                <div class="col-md-11">
                    <div class="checkbox col-md-12">
                        <label>
                            <input class="new-qs-mult" type="checkbox" value=""/>
                            Multiple Choice
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                        <label>
                            <input class="new-qs-anonymous" type="checkbox" value=""/>
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
                    <select class="new-qs-vis form-control">
                        <option value="VISIBLE">Visible</option>
                        <option value="INVISIBLE">Invisible</option>
                        <option value="VISIBLE_AFTER_ENDED">Visible after ended</option>
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