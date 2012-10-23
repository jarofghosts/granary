@layout('common.template')

@section('title')
Edit message to {{ $message->recipient->display_name }}
@endsection

@section('main_content')
<form id="message_form" method="post" action="{{ URL::base() }}/messages/change">
    To: 
    <input type="hidden" name="recipient_id" value="{{ $message->recipient_id }}"/>
    <input type="hidden" name="message_id" value="{{ $message->id }}"/>
    <strong>{{ $message->recipient->display_name }}</strong><br/>
    <input type="text" name="subject" placeholder="subject" value="{{ $message->subject }}"/><br/>
    <textarea style="background-color: {{ Auth::user()->color }}" name="body" placeholder="message">{{ $message->body }}</textarea><br/>
    <button type="submit" class="button">save</button>
</form>
@endsection