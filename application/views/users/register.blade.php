@layout('common.template')

@section('title')
Be Somebody
@endsection

@section('header')
New User
@endsection

@section('pre_includes')
<link rel="stylesheet" href="{{ URL::base() }}/js/plugins/colorpick/jquery.miniColors.css" type="text/css"/>
@endsection

@section('main_content')
<form method="post" action="new" id="new_user_form">
    <input type="text" name="username" placeholder="Username"/><br/>
    <input type="password" name="password" placeholder="Password"/><br/>
    <input type="email" name="email" placeholder="E-mail"/><br/>
    <input type="text" name="real_name" placeholder="Real Name"/><br/>
    <input id="color_picker" type="text" name="color" placeholder="Color" value="#FFFFFF"/><br/>
    <textarea id="about_me_textarea" name="about_me" placeholder="About Me"></textarea><br/>
    <button type="submit">Register!</button>

</form>
@endsection

@section('post_includes')
<script src="{{ URL::base() }}/js/plugins/colorpick/jquery.miniColors.min.js"></script>
<script>

    $("#color_picker").miniColors( {
        change: function(hex) {
            $("#about_me_textarea").css('background-color', hex);
        }
    });
</script>
@endsection

@section('includes')
<script src="{{ URL::base() }}/js/plugins/colorpick/jquery.miniColors.min.js"></script>
@endsection