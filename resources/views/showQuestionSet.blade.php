@for($qs_idx = 0; $qs_idx < count($question_sets); ++$qs_idx)
    <div class="qs-entry panel panel-default">
        <div class="panel-heading">
            <h3>
                {{ $question_sets[$qs_idx]->name }}
            @can('update-topic', $topic)
                <button type="button" class="close qs-remove qs-edit-control hidden">
                    <span aria-hidden="true">&times;</span>
                </button>
            @endcan
            </h3>
            <div class="row">
                <div class="col-md-6">
                    <h4>
                    @if($question_sets[$qs_idx]->is_multiple_choice)
                        <span class="label label-primary">Multiple choice</span>
                    @else
                        <span class="label label-primary">Single choice</span>
                    @endif
                    @if($question_sets[$qs_idx]->is_anonymous)
                        <span class="label label-warning">Anonymous</span>
                    @endif
                    </h4>
                </div>
                <div class="col-md-3 col-md-offset-3">
                    <select class="qs-vis form-control qs-edit-control hidden">
                        <option>Visible</option>
                        <option>Invisible</option>
                        <option>Visible after ended</option>
                    </select>
                </div>
            </div>
        </div>
        <ul class="list-group">
            <a class="list-group-item option-template hidden">
                <label></label>
                <span class="badge"></span>
            </a>
        @for($opt_idx = 0; $opt_idx < count($options[$qs_idx]); ++$opt_idx)
            <a class="list-group-item option{{ $question_sets[$qs_idx]->is_multiple_choice ? ' multi' : '' }}">
                <label> {{ $options[$qs_idx][$opt_idx]->content }}</label>
                <span class="badge"></span>
            </a>
        @endfor
        </ul>
    @can('update-topic', $topic)
        <div class="panel-footer qs-edit-control hidden">
            <button id="opt-add" type="button" class="btn btn-success">
                <span class="glyphicon glyphicon-plus"> </span>
            </button>
        </div>
    @endcan
    </div>
@endfor