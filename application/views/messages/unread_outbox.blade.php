    <li style="background-color: {{ Auth::user()->color }}">
        <strong><a href="{{ URL::base() }}/messages/read/{{ $unread_message->id }}">{{ $unread_message->subject }}</a></strong>
        <span>to <a href="{{ URL::base() }}/~{{ $unread_message->recipient->username }}">{{ $unread_message->recipient->display_name }}</a>
            <img src="{{ $unread_message->recipient->avatar }}"/>
        </span>
    </li>