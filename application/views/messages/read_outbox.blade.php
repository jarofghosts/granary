    <li>
        <strong><a href="{{ URL::base() }}/messages/read/{{ $read_message->id }}">{{ $read_message->subject }}</a></strong>
        <span>to <a href="{{ URL::base() }}/~{{ $read_message->recipient->username }}">{{ $read_message->recipient->display_name }}</a>
            <img src="{{ $read_message->recipient->avatar }}"/>
        </span>
    </li>