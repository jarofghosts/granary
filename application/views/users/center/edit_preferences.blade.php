<form id="board_prefs_edit" action="{{ URL::base() }}/users/save_preferences" method="post">
	<input type="text" name="front_page_posts" value="{{ $preferences->front_page_posts }}" placeholder="15"/> front page posts<br/>
	<input type="text" name="rating_threshold" value="{{ $preferences->rating_threshold }}" placeholder="0"/> rating threshold<br/>
	<input type="text" name="responses_per_page" value="{{ $preferences->responses_per_page }}" placeholder="0"/> replies per page<br/>
	<input type="checkbox" name="bot_messages"@if ($preferences->bot_messages == '1') checked@endif/> receive messages from bots<br/>
	<button type="submit" class="button">save</button>
</form>