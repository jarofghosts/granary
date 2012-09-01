@layout('common.template')

@section('title')
    Edit {{ $category->name }}
@endsection

@section('main_content')
<form method="post" action="new">
    <br/>
    <input type="hidden" name="id" value="{{ $category->id }}"/>
    <input type="text" name="title" placeholder="Title" value="{{ $category->title }}"/><br/>
<<<<<<< HEAD
    @if (!$category->handle)
    <input type="text" name="handle" placeholder="Handle" value="{{ $category->handle }}"/><br/>
    @else
    <a href="{{ URL::base() . '/!' . $category->handle }}">{{ $category->handle }}</a><br/>
    @endif
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