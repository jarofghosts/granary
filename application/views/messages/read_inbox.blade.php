    <li>
        <strong><a href="{{ URL::base() }}/messages/read/{{ $read_message->id }}">{{ $read_message->subject }}</a></strong>
        <span>from <a href="{{ URL::base() }}/~{{ $read_message->sender->username }}">{{ $read_message->sender->display_name }}</a>
            <img src="{{ $read_message->sender->avatar }}"/>
        </span>
    </li>