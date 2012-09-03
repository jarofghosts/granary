@layout('common.template')

@section('title')
{{ $post->title }}
@endsection

@section('main_content')
<a href="{{ URL::base() }}/posts" class="button">&laquo; Back</a>
@include('posts.view')<br/>
<a class="button" href="{{ URL::base() }}/posts/{{ $post->id }}/reply/new">add a reply</a>
<br/><hr/><br/>
<?php $replies = $post->replies; ?>
@if (count($replies) > 0)
@include('replies.view')
@else
<em>{{ Diceman::nothing() }}</em>
@endif
@endsection

@section('includes')
<script src="{{ URL::base() }}/js/post.js"></script>
@endsection