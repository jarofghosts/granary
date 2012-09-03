<div class="reply" id="reply-{{ $reply->id }}">
    <div class="user_slug">
        <img src="{{ URL::base() }}{{ $reply->user->avatar }}" alt="{{ $reply->user->display_name }}"/>
        <a href="{{ URL::base() }}/~{{ $reply->user->username }}">{{ $reply->user->display_name }}</a>
    </div>
    <blockquote style="background-color: {{ $reply->user->color }}">{{ Sparkdown\Markdown ($reply->body) }}</blockquote>
    <a class="button" href="{{ URL::base() }}/!{{ $reply->grandparent->category->handle }}/<{{ $reply->grandparent->slug }}/>{{ $reply->slug }}">permalink</a>
</div>
<div style="clear: both;"></div>
