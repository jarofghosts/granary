<form id="message_form" method="post" action="{{ URL::base() }}/messages/send">
    To: 
    @if ($recipient)
    <input type="hidden" name="recipient_id" value="{{ $recipient->id }}"/>
    <strong>{{ $recipient->display_name }}</strong><br/>
    @else
    <div id="recipient_id"></div>
    <br/>
    @endif
    <input type="text" name="subject" placeholder="subject"/><br/>
    <textarea style="background-color: {{ Auth::user()->color }}" name="body" placeholder="message"></textarea><br/>
    <button type="submit" class="button">send</button>
</form>