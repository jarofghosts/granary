@layout('common.template')

@section('title')
    New Post
@endsection

@section('main_content')
<form method="post" action="new" id="post_form">

    <br/>Category: 
    <select name="category_id" id="category_select">
    @foreach (Category::all() as $category)

        <option value="{{ $category->id; }}">{{ $category->title; }}</option>

    @endforeach
    </select><br/>
    <input type="text" name="title" placeholder="Title"/><br/>
    <textarea name="body" placeholder="Body" class="post_body_input" style="background-color: {{ Auth::user()->color }};"></textarea><br/>
    <button type="submit">Submit</button>
</form>
@endsection
