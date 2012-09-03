<article class="post" id="post-{{ $post->id }}">

    <h1><a href="{{ URL::base() }}/!{{ $post->category->handle }}/<{{ $post->slug }}">{{ $post->title }}</a></h1>

    <div class="user_slug">
        
        <img src="{{ URL::base() }}{{ $post->user->avatar }}" alt="{{ $post->user->display_name }}"/>
        <a href="{{ URL::base() }}/~{{ $post->user->username }}">{{ $post->user->display_name }}</a></div>
    <div class="category_slug">
        <img src="{{ URL::base() }}{{ $post->category->logo }}" alt="{{ $post->category->title }}"/><br/>
        <a href="{{ URL::base() }}/!{{ $post->category->handle }}">{{ $post->category->title }}</a>
    </div>
    <blockquote style="background-color: {{ $post->user->color }}">

        {{ $post->body }}
        
    </blockquote>
    <div class="reply_count">
        <a class="button" href="{{ URL::base() }}/!{{ $post->category->handle }}/<{{ $post->slug }}">replies: {{ count($post->replies) }}</a>
    </div>
    <div class="post_admin" role="administration">
        @if (Auth::check() && (Auth::user()->can_edit_post($post->id)))
        <a class="post-edit button" href="{{ URL::base() }}/posts/edit/{{ $post->id }}">edit</a>
        <a class="post-delete button" href="{{ URL::base() }}/posts/delete/{{ $post->id }}">delete</a>
        @endif
    </div>
    
</article>