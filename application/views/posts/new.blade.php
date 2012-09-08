@layout('common.template')

@section('title')
    New Post
@endsection

@section('main_content')
<form method="post" action="new" id="post_form">
<?php
if ($category_id) {
    $category = Category::find($category_id);
} else {
    $category = false;
}
?>
    @if (!$category)
    <div id="category_id"></div>
    @else
    <strong>{{ $category->title }}</strong><br/>
    <input type="hidden" name="category_id" value="{{ $category_id }}"/>
    @endif
    <div style="clear: both"></div>
    <input type="text" name="title" placeholder="Title"/><br/>
    <textarea name="body" placeholder="Body" class="post_body_input" style="background-color: {{ Auth::user()->color }};"></textarea><br/>
    <button type="submit">Submit</button>
</form>
@endsection

@section('post_includes')
<script>
$(document).ready( function() {
    $('#category_id').flexbox('{{ URL::base() }}/search/categories',
        {
            watermark: 'Category',
            autoCompleteFirstMatch: true,
            paging: {
                pageSize: 20
            }

        });
});
</script>
@endsection