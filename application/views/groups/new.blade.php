@layout('common.template')

@section('title')
New Group
@endsection

@section('main_content')
<form id="group_form" method="post" action="{{ URL::base() }}/groups/new">
    <input type="text" name="title" placeholder="title"/><br/>
    <input type="text" name="handle" placeholder="handle"/><br/>
    <input type="text" name="logo" placeholder="logo"/><br/>
    <textarea name="description" placeholder="description"></textarea><br/>
    <button type="submit" class="button">save</button>
</form>
@endsection