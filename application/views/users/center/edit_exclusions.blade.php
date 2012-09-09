<h1 class="subtitle">Excluded Categories</h1>
<?php 

	$categories = Auth::user()->excluded(); 
	$users = Auth::user()->ignored();

	$category_count = $categories ? count($categories) : 0;
	$user_count = $users ? count($users) : 0;

	if ($category_count === 0) { $category_count = Diceman::nothing(); }
	if ($user_count === 0) { $user_count = Diceman::nothing(); }

?>

<div class="exclusion_head">
	<a href="#excluded_cats">{{ $category_count }}</a>
</div>

<div id="excluded_cats" class="exclusions" style="display: none">
	@if ($categories)
	@foreach ($categories as $category)
		<?php $posts = count($category->posts); ?>
		@include('categories.view')
	@endforeach
	@endif
</div>

<h1 class="subtitle">Ignored Users</h1>

<div class="exclusion_head">
	<a href="#ignored_users">{{ $user_count }}</a>
</div>

<div id="ignored_users" class="exclusions" style="display: none">
 	@if ($users)
 	@foreach ($users as $user)
 		@include('users.center.user_profile')
 	@endforeach
 	@endif
</div>