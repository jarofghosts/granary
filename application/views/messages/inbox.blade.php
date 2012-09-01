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
        @include('messages.unread_inbox')
    @endforeach
</ul>
<h1 class="subtitle">Read Messages ({{ $read_count }})</h1>
<ul class="read_mail">
    @foreach ($read as $read_message)
        @include('messages.read_inbox')
    @endforeach
</ul>
@endsection