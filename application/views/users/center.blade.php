@layout('common.template')

@section('title')
{{ Auth::user()->display_name }}'s User Center
@endsection

@section('pre_includes')
<link rel="stylesheet" href="{{ URL::base() }}/js/plugins/colorpick/jquery.miniColors.css" type="text/css"/>
@endsection


@section('header')
{{ Auth::user()->display_name }}
@endsection

@section('main_content')
@include('users.center_actions')
@endsection

@section('post_includes')
<script src="{{ URL::base() }}/js/plugins/jquery.form.js"></script>
<script src="{{ URL::base() }}/js/plugins/colorpick/jquery.miniColors.min.js"></script>
<script src="{{ URL::base() }}/js/user_center.js"></script>
<script>
$( function() {
	$("#color_picker").miniColors( {
		change: function(hex) {
			$("#about_me_textarea").css('background-color', hex);
		}
	});
	$('#user_id').flexbox('{{ URL::base() }}/search/users',
	{
		watermark: 'User',
		autoCompleteFirstMatch: true,
		paging: {
			pageSize: 20
		}

	});
});
</script>
@endsection