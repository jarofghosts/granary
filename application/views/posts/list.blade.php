@layout('common.template')

@section('title')
Posts index
@endsection

@section('main_content')
@foreach ($posts as $post)
@include('posts.view')
@endforeach
<div style="clear:both;"></div>
@endsection