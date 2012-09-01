@layout('common.template')

@section('title')
{{ Auth::user()->display_name }}'s Inbox
@endsection

@section('main_content')
<?php $read_count = count($read); ?>
<?php $unread_count = count($unread); ?>
<h1 class="subtitle">Unread Messages ({{ $unread_count }})</h1>
<ul class="unread_mail">

    @foreach ($unread as $unread_message)
    <li style="background-color: {{ $unread_message->sender->color }}">
        <strong><a href="{{ URL::base() }}/messages/read/{{ $unread_message->id }}">{{ $unread_message->subject }}</a></strong>
        <span>from <a href="{{ URL::base() }}/~{{ $unread_message->sender->username }}">{{ $unread_message->sender->display_name }}</a>
            <img src="{{ $unread_message->sender->avatar }}"/>
        </span>
    </li>
    @endforeach
</ul>
<h1 class="subtitle">Read Messages ({{ $read_count }})</h1>
<ul class="read_mail">
    @foreach ($read as $read_message)
    <li>
        <strong><a href="{{ URL::base() }}/messages/read/{{ $read_message->id }}">{{ $read_message->subject }}</a></strong>
        <span>from <a href="{{ URL::base() }}/~{{ $read_message->sender->username }}">{{ $read_message->sender->display_name }}</a>
            <img src="{{ $read_message->sender->avatar }}"/>
        </span>
    </li>
    @endforeach
</ul>
@endsection