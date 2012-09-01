    <li style="background-color: {{ $unread_message->sender->color }}">
        <strong><a href="{{ URL::base() }}/messages/read/{{ $unread_message->id }}">{{ $unread_message->subject }}</a></strong>
        <span>from <a href="{{ URL::base() }}/~{{ $unread_message->sender->username }}">{{ $unread_message->sender->display_name }}</a>
            <img src="{{ $unread_message->sender->avatar }}"/>
        </span>
    </li>