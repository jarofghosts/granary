<form id="message_form" method="post" action="{{ URL::base() }}/messages/send">
    To: 
    @if ($recipient)
    <input type="hidden" name="recipient_id" value="{{ $recipient->id }}"/>
    <strong>{{ $recipient->display_name }}</strong><br/>
    @else
    <select name="recipient_id">
        @foreach (User::where('active', '=', 1)->where('id', '!=', Auth::user()->id)->get() as $user)
        <option value="{{ $user->id }}">{{ $user->display_name }}</option>
        @endforeach
    </select><br/>
    @endif
    <input type="text" name="subject" placeholder="subject"/><br/>
    <textarea style="background-color: {{ Auth::user()->color }}" name="body" placeholder="message"></textarea><br/>
    <button type="submit" class="button">send</button>
</form>