@extends('layouts.frontend')

@section('content')
<div class="container">
    <div id="app">
        <quiz-play :quiz-id={{$quiz->quiz_id}}></quiz-play>
    </div>
</div>
@endsection