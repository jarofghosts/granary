@layout('common.template')

@section('title')
{{ $category->name }}
@endsection

@section('main_content')
@include('categories.view')
@endsection