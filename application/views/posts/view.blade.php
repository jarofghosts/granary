<article class="post" id="post-{{ $post->id }}">

    <h1><a href="{{ $post->absolute_path }}">{{ $post->title }}</a></h1>

    <div class="user_slug">
        <img src="{{ URL::base() }}{{ $post->user->avatar }}" alt="{{ $post->user->display_name }}"/>
        <a href="{{ URL::base() }}/~{{ $post->user->username }}">{{ $post->user->display_name }}</a></div>
    <div class="category_slug">
        <img src="{{ URL::base() }}{{ $post->category->logo }}" alt="{{ $post->category->title }}"/>
        <a href="{{ URL::base() }}/!{{ $post->category->handle }}">{{ $post->category->title }}</a>
    </div>
    <blockquote style="background-color: {{ $post->user->color }}">

        {{ $post->body }}
        
    </blockquote>
    <div class="reply_count">
        @if (Auth::check())
        <a
        class="vote-button @if (Auth::user()->check_vote( $post->id ) > 0)selected-vote@endif up button"
        href="{{ $post->absolute_path }}/up">+</a>
        <a
        class="vote-button @if (Auth::user()->check_vote( $post->id ) < 0)selected-vote@endif down button"
        href="{{ $post->absolute_path }}/down">-</a>
        @endif

        @if (Auth::check())
        <a href="#qr-{{ $post->id }}" class="quick-reply button"><i class="icon-bullhorn"></i> reply</a>
        @endif
        <a href="{{ $post->absolute_path }}"><i class="icon-eye-open"></i> replies: <span class="replies-count">{{ count($post->replies) }}</span></a>
    </div>
    <div class="post_admin" role="administration">
        @if (Auth::check() && (Auth::user()->can_edit_post($post->id)))
        <a class="post-edit button" href="{{ $post->absolute_path }}/edit"><i class="icon-edit"></i> edit</a>
        <a class="post-delete button" href="{{ $post->absolute_path }}/delete"><i class="icon-remove-sign"></i> delete</a>
        @endif
    </div>
</article>
<div class="quick-reply-container" id="qr-{{ $post->id }}">
    <textarea class="quick-reply-entry user-color" placeholder="quick reply" data-post-id="{{ $post->id }}"></textarea><br/>
    <a href="#" class="button" onclick="sendQuickReply({{ $post->id }})" style="margin-left: 350px"><i class="icon-circle-arrow-right"></i> send</a>
</div>