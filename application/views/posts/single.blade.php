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
@include('replies.view')
@endsection

@section('includes')
<script src="{{ URL::base() }}/js/post.js"></script>
@endsection