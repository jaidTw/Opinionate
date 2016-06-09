@for($qs_idx = 0; $qs_idx < count($question_sets); ++$qs_idx)
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>
                {{ $question_sets[$qs_idx]->name }}
            </h3>

            <h4>
                @if($question_sets[$qs_idx]->is_multiple_choice)
                    <span class="label label-primary">Multiple choice</span>
                @else
                    <span class="label label-primary">Single choice</span>
                @endif
                @if($question_sets[$qs_idx]->is_synced)
                    <span class="label label-success">Synchronous</span>
                @else
                    <span class="label label-success">Asynchronous</span>
                @endif
                @if($question_sets[$qs_idx]->is_anonymous)
                    <span class="label label-warning">Anonymous</span>
                @endif
            </h4>
        </div>
        <ul class="list-group">
        @for($opt_idx = 0; $opt_idx < count($options[$qs_idx]); ++$opt_idx)
            <a class="list-group-item option{{ $question_sets[$qs_idx]->is_multiple_choice ? ' multi' : '' }}">
                <label> {{ $options[$qs_idx][$opt_idx]->content }}</label>
            </a>
        @endfor
        </ul>
    </div>
@endfor