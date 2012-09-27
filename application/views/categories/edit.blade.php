@layout('common.template')

@section('title')
    Edit {{ $category->name }}
@endsection

@section('main_content')
    <div class="avatar_box">
        <img src="{{ URL::base() }}{{ $category->logo }}" alt="{{ $category->title }}" class="mini_avatar"/><br/>
        <a class="button avatar-toggle" href="{{ URL::base() }}/!{{ $category->handle }}/edit/logo">change logo</a><br/>
        <form id="logo-form" style="display: none" method="post" action="{{ URL::base() }}/categories/change_logo" enctype="multipart/form-data">
            <input type="text" name="logo" placeholder="logo link" value="{{ $category->edit_logo }}"/>
            <input type="file" name="disabled" placeholder="logo upload" style="display: none"/><br/>
            <a href="#" class="button avatar-type-toggle">upload instead</a> <button type="submit" class="button">link logo</button>
        </form>
    </div>

<form method="post" action="/!{{ $category->handle }}/edit" id="category-form">
    <input type="hidden" name="id" value="{{ $category->id }}"/>
    <input type="text" name="title" placeholder="Title" value="{{ $category->title }}"/><br/>
    <a href="{{ URL::base() . '/!' . $category->handle }}">{{ $category->handle }}</a><br/>
    <input type="hidden" name="logo" value="{{ $category->edit_logo }}"/><br/>
    <textarea name="description" placeholder="Description">{{ $category->description }}</textarea><br/>
    <button type="submit">save category</button>
</form>
@endsection

@section('post_includes')
<script src="{{ URL::base() }}/js/plugins/jquery.form.js"></script>
<script src="{{ URL::base() }}/js/category_edit.js"></script>
@endsection