@layout('common.template')

@section('title')
@if (isset($category))
{{ $category->title }}
@else
Posts
@endif
@endsection

@section('head_name')
@if (isset($category))
<div style="position: absolute; left: 280px; top: 45px; width: auto">{{ $category->title }}
	@if (Auth::user()->can_edit($category->id))
	<span style="font-size: .5em"><a href="{{ URL::base() }}/!{{ $category->handle }}/edit">edit</a></span>
	@endif
</div>
@endif
@endsection

@section('main_content')
@if (count($posts) < 1)
	{{ Diceman::nothing() }}
@endif
@foreach ($posts as $post)
@include('posts.view')
@endforeach
<div style="clear: both"></div>
@endsection