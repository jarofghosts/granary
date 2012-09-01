@layout('common.template')

@section('title')
Category not found
@endsection

@section('main_content')
@if (!$results)
<img src="/sailor/attic/404.jpg" alt="YOU WIN!!!!"/><br/>
YOU WON TODAY'S PRIZE!
@else
@foreach ($possibilities as $category)
<?php $posts = count($category->posts) ?>
@include('categories.single')
@endforeach
@endif
@endsection