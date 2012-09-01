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
<form method="post" action="{{ URL::base() }}/users/edit" id="user_edit_post">
    <input type="hidden" name="id" value="{{ $user->id }}"/>
    @if ( $change_avatar != 1 )
    <img src="{{ URL::base() }}{{ $user->avatar }}" alt="{{ $user->display_name }}"/><br/>
    <a class="button" href="{{ URL::base() }}/users/edit/{{ $user->id }}/avatar">change avatar</a><br/>
    @else
    <input type="text" name="avatar" placeholder="Avatar" value="{{ $user->avatar }}"/><br/>
    @endif
    <input type="password" name="password" placeholder="Change Password"/><br/>
    <input type="email" name="email" placeholder="E-mail" value="{{ $user->email }}"/><br/>
    <input type="text" name="name" placeholder="Real Name" value="{{ $user->name }}"/><br/>
    <input id="color_picker" type="text" name="color" placeholder="Color" value="{{ $user->color }}"/><br/>
    <textarea id="about_me_textarea" style="background-color: {{ $user->color }}" name="about_me" placeholder="About Me">{{ $user->about_me }}</textarea><br/>
    <button type="submit">Save User</button>
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