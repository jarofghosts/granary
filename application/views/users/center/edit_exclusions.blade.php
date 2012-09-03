<h1 class="subtitle">Excluded Categories</h1>
<?php 

	$categories = Auth::user()->exclusions; 
	$users = Auth::user()->ignore;

	$category_count = count($categories);
	$user_count = count($users);

	if ($category_count == 0) { $category_count = Diceman::nothing(); }
	if ($user_count == 0) { $user_count = Diceman::nothing(); }

?>

<div class="exclusion_head">
	<a href="#excluded_cats">{{ $category_count }}</a>
</div>

<div id="excluded_cats" class="exclusions" style="display: none">
	@foreach ($categories as $category)
		
	@endforeach
</div>

<h1 class="subtitle">Ignored Users</h1>

<div class="exclusion_head">
	<a href="#ignored_users">{{ $user_count }}</a>
</div>

<div id="ignored_users" class="exclusions" style="display: none">
 	@foreach ($users as $user)
 		@include('users.center.user_profile')
 	@endforeach
</div>