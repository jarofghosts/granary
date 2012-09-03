@layout('common.template')

@section('title')
    New Post
@endsection

@section('main_content')
<form method="post" action="new" id="post_form">
<?php
if ($category_id) {
    $category = Category::find($category_id);
}
?>
    <br/>Category: @if (!$category)
    <select name="category_id" id="category_select">
    @foreach (Auth::user()->category_list() as $category)

        <option value="{{ $category->id; }}">{{ $category->title; }}</option>

    @endforeach
    </select><br/>
    @else
    <strong>{{ $category->title }}</strong><br/>
    <input type="hidden" name="category_id" value="{{ $category_id }}"/>
    @endif
    <input type="text" name="title" placeholder="Title"/><br/>
    <textarea name="body" placeholder="Body" class="post_body_input" style="background-color: {{ Auth::user()->color }};"></textarea><br/>
    <button type="submit">Submit</button>
</form>
@endsection
