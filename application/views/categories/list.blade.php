@layout('common.template')

@section('title')
All Categories
@endsection

@section('header')
View all categories
@endsection

@section('main_content')
@foreach ($categories as $category)
<?php $posts = $category->posts; ?>
<div class="category_container">
@include('categories.view')
</div>
@endforeach
@endsection