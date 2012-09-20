@layout('common.template')

@section('title')
All Users
@endsection

@section('main_content')
@foreach ($users as $user)
<div class="category_container" style="background-color: {{ $user->color }}; width: 600px;">
	<h1 style="color: #333;">{{ $user->display_name }}</h1>
	@include('users.center.user_profile')
</div>
@endforeach
@endsection