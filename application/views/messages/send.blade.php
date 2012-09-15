@layout('common.template')

@section('title')
Compose message@if ($recipient)
 to {{ $recipient->display_name }}
@endif
@endsection

@section('main_content')
@if ($parent_id)
<?php $thread = Message::thread($parent_id); ?>
@include('messages.thread');
@endif
@include('messages.send_form')
@endsection