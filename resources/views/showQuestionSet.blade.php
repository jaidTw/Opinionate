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
                        <span class="label label-primary">{{ trans('views.multiple_choice') }}</span>
                    @else
                        <span class="label label-primary">{{ trans('views.single_choice') }}</span>
                    @endif
                    @if($question_sets[$qs_idx]->is_anonymous)
                        <span class="label label-warning">{{ trans('views.anonymous') }}</span>
                    @endif
                    </h4>
                </div>
                <div class="col-md-4 col-md-offset-2">
                    <select class="qs-vis form-control qs-edit-control hidden">
                        <option value="VISIBLE">{{ trans('views.visible') }}</option>
                        <option value="INVISIBLE">{{ trans('views.invisible') }}</option>
                        <option value="VISIBLE_AFTER_ENDED">{{ trans('views.visible_after_end') }}</option>
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
            <label class="new-opt-show"><a><span class="glyphicon glyphicon-triangle-bottom"></span>{{ trans('views.add_more_opts') }}</a></label>
            <div class="opt-controls panel-collapse collapse" role="tabpanel" aria-expanded="false">
                <div class="opt-entry col-md-6 input-group form-group">
                    <input class="new-qs-opt form-control" type="text" autocomplete="no" />
                    <span class="input-group-btn">
                        <button class="btn btn-success opt-add" type="button">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    @endcan
        <div class="panel-footer view-chart hidden">
            <label class="chart-show"><a><span class="glyphicon glyphicon-triangle-bottom"></span>{{ trans('views.view_chart') }}</a></label>
            <div class="chart-controls panel-collapse collapse" role="tabpanel" aria-expanded="false">
                <div class="chart-type">
                    <div class="radio row">
                        <div class="col-md-3">
                            <label class="chart-type-opt"><input name="chart-type-{{$qs_idx}}" type="radio" value="bar" checked>{{trans('views.bar_chart')}}</label>
                        </div>
                        <div class="col-md-3">
                            <label class="chart-type-opt"><input name="chart-type-{{$qs_idx}}" type="radio" value="polarArea">{{trans('views.polar_chart')}}</label>
                        </div>
                        <div class="col-md-3">
                            <label class="chart-type-opt"><input name="chart-type-{{$qs_idx}}" type="radio" value="pie">{{trans('views.pie_chart')}}</label>
                        </div>
                        <div class="col-md-3">
                            <label class="chart-type-opt"><input name="chart-type-{{$qs_idx}}" type="radio" value="doughnut">{{trans('views.doughnut_chart')}}</label>
                        </div>
                    </div>
                </div>
                <canvas class="qs-chart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
@endfor
