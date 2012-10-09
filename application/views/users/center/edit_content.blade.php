<?php
$user_posts = Post::where('author_id', '=', Auth::user()->id)->get(); ?>
@foreach ($user_posts as $post)
@include('posts.view')
@endforeach