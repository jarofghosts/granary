@layout('common.template')

@section('title')
@if (isset($category))
{{ $category->title }}
@else
Posts
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