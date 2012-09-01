@layout('common.template')

@section('title')
    New Category
@endsection

@section('main_content')
<form method="post" action="/categories/new">
    <input type="hidden" name="creator_id" value="{{ Auth::user()->id }}"/>
    <input type="text" name="title" placeholder="Title"/><br/>
    <input type="text" name="logo" placeholder="Logo"/><br/>
    <input type="text" name="handle" placeholder="Handle"/> (cannot be changed)<br/>
    <textarea name="description" placeholder="Description"></textarea><br/>
    <button type="submit">Save Category</button>
</form>
@endsection