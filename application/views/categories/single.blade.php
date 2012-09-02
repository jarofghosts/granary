@layout('common.template')

@section('title')
{{ $category->title }}
@endsection

@section('main_content')
@include('categories.view')
@endsection