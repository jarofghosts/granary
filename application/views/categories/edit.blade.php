@layout('common.template')

@section('title')
    Edit {{ $category->name }}
@endsection

@section('main_content')
<form method="post" action="new">
    <br/>
    <input type="hidden" name="id" value="{{ $category->id }}"/>
    <input type="text" name="title" placeholder="Title" value="{{ $category->title }}"/><br/>
    <a href="{{ URL::base() . '/!' . $category->handle }}">{{ $category->handle }}</a><br/>
    @if (substr($category->logo, 0, 6) == '/attic')
    <img src="{{ $category->logo }}" alt="{{ $category->title }}" class="category_logo_preview"/><br/>
    <a id="logo_edit" class="button" href="/categories/edit_logo">change</a><br/>
    @else
    <input type="text" name="logo" placeholder="Logo" value="{{ $category->logo }}"/><br/>
    @endif
    <textarea name="description" placeholder="Description">{{ $category->description }}</textarea><br/>
    <button type="submit">save category</button>
</form>
@endsection

@section('post_includes')
<script src="{{ URL::base() }}/js/plugins/jquery.form.js"></script>
<script src="{{ URL::base() }}/js/category_edit.js"></script>
@endsection