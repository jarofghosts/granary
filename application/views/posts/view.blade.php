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
        @if (Auth::check())
        <a class="vote-button selected-vote button" href="{{ URL::base() }}/!{{ $post->category->handle }}/<{{ $post->slug }}/up">+</a>
        <a class="vote-button button" href="{{ URL::base() }}/!{{ $post->category->handle }}/<{{ $post->slug }}/down">-</a>
        @endif
        <a class="button" href="{{ URL::base() }}/!{{ $post->category->handle }}/<{{ $post->slug }}">replies: {{ count($post->replies) }}</a>
    </div>
    <div class="post_admin" role="administration">
        @if (Auth::check() && (Auth::user()->can_edit_post($post->id)))
        <a class="post-edit button" href="{{ URL::base() }}/!{{ $post->category->handle }}/<{{ $post->slug }}/edit">edit</a>
        <a class="post-delete button" href="{{ URL::base() }}/!{{ $post->category->handle }}/<{{ $post->slug }}/delete">delete</a>
        @endif
    </div>
    
</article>