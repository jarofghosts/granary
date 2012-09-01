@layout('common.template')

@section('title')
{{ Auth::user()->display_name }}'s Messages
@endsection

@section('header')
{{ Auth::user()->display_name }}'s Unread Messages
@endsection

@section('main_content')
<?php $inbox_count = count($inbox); ?>
<?php $outbox_count = count($outbox); ?>
<h1 class="subtitle"><a href="{{ URL::base() }}/messages/inbox">Inbox</a> ({{ $inbox_count }})</h1>
<ul class="unread_mail">
	@if ($inbox_count < 1)
	<em>{{ Diceman::nothing() }}</em>
	@else
    @foreach ($inbox as $unread_message)
        @include('messages.unread_inbox')
    @endforeach
    @endif
</ul>
<h1 class="subtitle"><a href="{{ URL::base() }}/messages/outbox">Outbox</a> ({{ $outbox_count }})</h1>
<ul class="unread_mail">
    @foreach ($outbox as $unread_message)
        @include('messages.unread_outbox')
    @endforeach
</ul>
@endsection