
    <input type="hidden" name="id" value="{{ Auth::user()->id }}"/>
    <div class="avatar_box">
        <img src="{{ URL::base() }}{{ Auth::user()->avatar }}" alt="{{ Auth::user()->display_name }}" class="mini_avatar"/><br/>
        <a class="button avatar-toggle" href="{{ URL::base() }}/users/edit/{{ Auth::user()->id }}/avatar">change avatar</a><br/>
    </div>

<form id="user_profile_edit" action="{{ URL::base() }}/users/save_profile" method="post">
    <input type="text" name="avatar" placeholder="Avatar" value="{{ Auth::user()->edit_avatar }}" style="display: none"/>
    <input type="file" name="avatar_upload" placeholder="Avatar" style="display: none"/>
    <br/>
    <input type="password" name="password" placeholder="Change Password"/><br/>
    <input type="email" name="email" placeholder="E-mail" value="{{ Auth::user()->email }}"/><br/>
    <input type="text" name="name" placeholder="Real Name" value="{{ Auth::user()->name }}"/><br/>
    <input id="color_picker" type="text" name="color" placeholder="Color" value="{{ Auth::user()->color }}"/><br/>
    <textarea id="about_me_textarea" style="background-color: {{ Auth::user()->color }}" name="about_me" placeholder="About Me">{{ Auth::user()->about_me }}</textarea><br/>
    <button type="submit">save</button>
</form>