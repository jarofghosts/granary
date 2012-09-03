@layout('common.template')

@section('title')
Edit {{ $group->title }}
@endsection

@section('main_content')
<form id="group_form" method="post" action="{{ URL::base() }}/groups/edit">
	<img src="{{ URL::base() }}{{ $group->logo }}" alt="{{ $group->name }}"/><br/>
	<a href="{{ URL::base() }}/groups/edit/logo" class="button">edit logo</a><br/>
	<input type="text" name="logo" placeholder="logo" value="" style="display: none"/><br/>
    <input type="text" name="title" placeholder="title" value="{{ $group->title }}"/><br/>
    <input type="text" name="handle" placeholder="handle"/><br/>
    <textarea name="description" placeholder="description"></textarea><br/>
    <button type="submit" class="button">save group</button>
</form>
@endsection