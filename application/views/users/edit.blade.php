@layout('common.template')

@section('title')
Edit {{ $user->display_name }}
@endsection

@section('pre_includes')
<link rel="stylesheet" href="{{ URL::base() }}/js/plugins/colorpick/jquery.miniColors.css" type="text/css"/>
@endsection


@section('header')
Edit {{ $user->display_name }}
@endsection

@section('main_content')
    <div class="avatar_box">
        <img src="{{ URL::base() }}{{ $user->avatar }}" alt="{{ $user->display_name }}" class="mini_avatar"/><br/>
        <a class="button avatar-toggle" href="{{ URL::base() }}/users/edit/{{ $user->id }}/avatar">change avatar</a><br/>
        <form id="avatar-form" style="display: none" method="post" action="{{ URL::base() }}/users/change_avatar" enctype="multipart/form-data">
            <input type="text" name="avatar" placeholder="Avatar" value="{{ $user->edit_avatar }}"/>
            <input type="file" name="disabled" placeholder="Avatar" style="display: none"/><br/>
            <a href="#" class="button avatar-type-toggle">upload instead</a> <button type="submit" class="button">link avatar</button>
        </form>
    </div>
<form id="user_profile_edit" action="{{ URL::base() }}/users/save_profile" method="post">
    <br/>
    <input type="hidden" name="id" value="{{ $user->id }}"/>
    <input type="hidden" name="avatar" value="{{ $user->edit_avatar }}"/>
    <input type="password" name="password" placeholder="Change Password"/><br/>
    <input type="email" name="email" placeholder="E-mail" value="{{ $user->email }}"/><br/>
    <input type="text" name="real_name" placeholder="Real Name" value="{{ $user->real_name }}"/><br/>
    <input id="color_picker" type="text" name="color" placeholder="Color" value="{{ $user->color }}"/><br/>
    <textarea id="about_me_textarea" style="background-color: {{ $user->color }}" name="about_me" placeholder="About Me">{{ $user->about_me }}</textarea><br/>
    <button type="submit">save</button>
</form>
@endsection

@section('post_includes')
<script src="{{ URL::base() }}/js/plugins/jquery.form.js"></script>
<script src="{{ URL::base() }}/js/plugins/colorpick/jquery.miniColors.min.js"></script>
<script src="{{ URL::base() }}/js/user_edit.js"></script>
<script>

    $("#color_picker").miniColors( {
        change: function(hex) {
            $("#about_me_textarea").css('background-color', hex);
        }
    });
</script>
@endsection