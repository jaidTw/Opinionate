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
                    @include('showQuestionSet')
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

@section('scripts')
<script>
$(function()
{
    $(document).on('click', '.option', function(e) {
        e.preventDefault();

        if($(this).hasClass('multi')) {
            if($(this).hasClass('info')) {
                $(this).removeClass('info');
            }
            else {
                $(this).addClass('info');
            }
        }
        else {
            if($(this).hasClass('info')) {
                $(this).removeClass('info');
            }
            else {
                $(this).siblings('.option').removeClass('info');
                $(this).addClass('info');
            }
        }
    });
});
</script>
@endsection