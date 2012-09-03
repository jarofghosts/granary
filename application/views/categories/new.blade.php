@layout('common.template')

@section('title')
    New Category
@endsection

@section('main_content')
<form method="post" action="/categories/new">
    <input type="hidden" name="creator_id" value="{{ Auth::user()->id }}"/>
    <input type="hidden" name="logo_switch" value="0"/>
    <input type="text" name="title" placeholder="title"/><br/>
    <input type="text" name="logo" placeholder="logo"/><br/>
    <input type="text" name="handle" placeholder="handle"/> (cannot be changed)<br/>
    <textarea name="description" placeholder="description"></textarea><br/>
    <button type="submit">save category</button>
</form>
@endsection