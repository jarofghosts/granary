@layout('common.template')

@section('title')
New smiley
@endsection

@section('header')
Smilies
@endsection

@section('main_content')
<div class="reply_container">
	<form method="post" action="{{ URL::base() }}/smilies/upload_image" id="smiley-image">
		<input type="text" name="image_link" placeholder="http://www.zombo.com/whatzombodoes.jpeg"/>
		<input type="file" name="image_file" placeholder="mysecretpornpicture.gif" style="display: none"/>
		<div style="float:right">
			<img src="/img/defaults/smiley.png" class="smiley" alt=":D"/>
		</div>
		<button type="submit">change picture</button>
	</form>
    <form method="post" action="{{ URL::base() }}/smilies/new" id="smiley-edit">
        <input type="text" name="trigger" placeholder=":D"/><br/>
        <input type="checkbox" name="resize" checked/>resize image<br/>
        <input type="hidden" name="replacement"/>
        <button type="submit">submit</button>
    </form>
</div>
@endsection

@section('post_includes')
<script src="{{ URL::base() }}/js/plugins/jquery.form.js"></script>
<script src="{{ URL::base() }}/js/smiley.js"></script>
@endsection