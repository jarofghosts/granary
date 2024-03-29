<div class="reply" id="reply-{{ $reply->id }}">
    <div class="user_slug">
        <img src="{{ URL::base() }}{{ $reply->user->avatar }}" alt="{{ $reply->user->display_name }}"/>
        <a href="{{ URL::base() }}/~{{ $reply->user->username }}">{{ $reply->user->display_name }}</a>
    </div>
    <blockquote style="background-color: {{ $reply->user->color }}">{{ $reply->body }}</blockquote>

    <div class="reply_count">
        <a class="button" href="{{ URL::base() }}/!{{ $reply->grandparent->category->handle }}/<{{ $reply->grandparent->slug }}/>{{ $reply->slug }}"><i class="icon-link"></i> permalink</a>
    </div>
    <div class="post_admin" role="administration">
        @if (Auth::check() && (Auth::user()->can_edit_reply($reply->id)))
        <a class="reply-edit button" href="{{ URL::base() }}/!{{ $reply->grandparent->category->handle }}/<{{ $reply->grandparent->slug }}/>{{ $reply->slug }}/edit"><i class="icon-edit"></i> edit</a>
        <a class="reply-delete button" href="{{ URL::base() }}/!{{ $reply->grandparent->category->handle }}/<{{ $reply->grandparent->slug }}/>{{ $reply->slug }}/delete"><i class="icon-remove-sign"></i> delete</a>
        @endif
    </div>
</div>