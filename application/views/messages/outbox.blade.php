@layout('common.template')

@section('title')
{{ Auth::user()->display_name }}'s Outbox
@endsection

@section('main_content')
<?php $read_count = count($read); ?>
<?php $unread_count = count($unread); ?>
<h1 class="subtitle">Unread Messages ({{ $unread_count }})</h1>
<ul class="unread_mail">
	@if ($unread_count < 1)
	<em>{{ Diceman::nothing() }}</em>
	@else
    @foreach ($unread as $unread_message)
        @include('messages.unread_outbox')
    @endforeach
    @endif
</ul>
<h1 class="subtitle">Read Messages ({{ $read_count }})</h1>
<ul class="read_mail">
	@if ($read_count < 1)
	<em>{{ Diceman::nothing() }}</em>
	@else
    @foreach ($read as $read_message)
        @include('messages.read_outbox')
    @endforeach
    @endif
</ul>
@endsection