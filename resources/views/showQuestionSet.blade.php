@for($qs_idx = 0; $qs_idx < count($question_sets); ++$qs_idx)
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3> {{ $question_sets[$qs_idx]->name }} </h3>
        </div>
        <table class="table table-hover">
        @for($opt_idx = 0; $opt_idx < count($options[$qs_idx]); ++$opt_idx)
            <tr class="option{{ $question_sets[$qs_idx]->is_multiple_choice ? ' multi' : '' }}">
                <td>
                    <label>{{ $options[$qs_idx][$opt_idx]->content }}</label>
                </td>
            </tr>
        @endfor
        </table>
    </div>
@endfor