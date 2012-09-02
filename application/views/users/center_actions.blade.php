<ul class="center_options">
	<li class="current"><a href="#center_profile">Profile Options</a></li>
	<li><a href="#center_preferences">Board Preferences</a></li>
	<li><a href="#center_my_content">Manage Content</a></li>
	<li><a href="#center_exclusions">Define Exclusions</a></li>
	@if (Auth::user()->access_level > 1)<li><a href="#center_admin">Admin Panel</a></li>@endif
</ul>
<div class="center_action">
<div id="center_profile" class="tab_current">
@include('users.center.edit_profile')
</div>
<div style="display: none" id="center_preferences">
@include('users.center.edit_preferences')
</div>
<div style="display: none" id="center_my_content">
My content
</div>
<div style="display: none" id="center_exclusions">
Exclusions
</div>
@if (Auth::user()->access_level > 1)
<div style="display: none" id="center_admin">
Admin
</div>
@endif
</div>