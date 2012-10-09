<form id="admin_form" method="post" action="{{ URL::base() }}/users/admin">
	<div id="user_id"></div><br/>
	<select name="access_level">
		<option value="10">make @op</option>
		<option value="5">make +mod</option>
		<option value="0">make ~user</option>
		<option value="-5">make -prob</option>
		<option value="-10">make [ban]</option>
	</select>
	<button type="submit" class="button"><i class="icon-magic"></i> admin</button>
</form>