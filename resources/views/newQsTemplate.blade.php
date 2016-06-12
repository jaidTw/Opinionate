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
                    <option>General</option>
                    <option>Location</option>
                    <option>Time</option>
                    <option>Image</option>
                    <option>Audio</option>
                    <option>Video</option>
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