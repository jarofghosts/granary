<ul class="center_options">
	<li>Profile Options</li>
	<li>Board Preferences</li>
	<li>Manage Content</li>
	<li>Define Exclusions</li>
	@if (Auth::user()->access_level > 1)<li>Admin Panel</li>@endif
</ul>
<div class="center_action">
<div id="center_profile">

</div>
<div id="center_preferences">

</div>
<div id="center_my_content">

</div>
<div id="center_exclusions">

</div>
@if (Auth::user()->access_level > 1)
<div id="center_admin">

</div>
@endif
</div>