<div class="user_slug">

    <img src="{{ URL::base() }}{{ $message->sender->avatar }}" alt="{{ $message->sender->display_name }}"/>
    <a href="{{ URL::base() }}/~{{ $message->sender->username }}">{{ $message->sender->display_name }}</a></div>

<blockquote style="background-color: {{ $message->sender->color }}">

    {{ $message->body }}

</blockquote>
<br/>

<a class="button" href="{{ URL::base() }}/messages/send/{{ $message->sender->id }}/{{ $message->id }}">reply</a>