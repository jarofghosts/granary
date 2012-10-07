@layout('common.template')

@section('title')
New smiley
@endsection

@section('header')
Smilies
@endsection

@section('main_content')
<div class="reply_container">
	<form method="post" action="{{ URL::base() }}/smilies/upload_image">
		<input type="text" name="image_link" placeholder="http://www.zombo.com/whatzombodoes.jpeg"/>
		<input type="file" name="image_file" placeholder="mysecretpornpicture.gif" style="display: none"/>
	</form>
    <form method="post" action="{{ URL::base() }}/smilies/new">
        <input type="text" name="trigger" placeholder=":D"/><br/>
        <input type="checkbox" name="resize" checked/>resize image<br/>
        <input type="hidden" name="replacement"/>
        <button type="submit">submit</button>
    </form>
</div>
@endsection