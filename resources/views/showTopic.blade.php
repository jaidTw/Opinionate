@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header">
        <h1> {{ $topic->name }}</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Question Sets
                    </div>
                <div class="panel-body">
                @for($qs_idx = 0; $qs_idx < count($question_sets); ++$qs_idx)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $question_sets[$qs_idx]->name }}
                        </div>
                        <table class="table table-hover">
                        @for($opt_idx = 0; $opt_idx < count($options[$qs_idx]); ++$opt_idx)
                            <tr>
                                <td>
                                    {{ $options[$qs_idx][$opt_idx]->content }}
                                </td>
                            </tr>
                        @endfor
                        </table>
                    </div>
                @endfor
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Topic Information
                </div>
                <div class="panel-body">
                    <h3> Proposer </h3>
                    {{ $proposer->name }}
                    <h3> Unlisted</h3>
                    {{ $topic->is_unlisted ? 'Yes' : 'No' }}
                    <h3> Created Time</h3>
                    {{ $topic->created_at }}
                    <h3> Last Edit Time</h3>
                    {{ $topic->updated_at }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection