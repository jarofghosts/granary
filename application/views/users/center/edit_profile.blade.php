
    <input type="hidden" name="id" value="{{ Auth::user()->id }}"/>
    <div class="avatar_box">
        <img src="{{ URL::base() }}{{ Auth::user()->avatar }}" alt="{{ Auth::user()->display_name }}" class="mini_avatar"/><br/>
        <a class="button avatar-toggle" href="{{ URL::base() }}/users/edit/{{ Auth::user()->id }}/avatar">change avatar</a><br/>
        <form id="avatar-form" style="display: none" method="post" action="{{ URL::base() }}/users/change_avatar" enctype="multipart/form-data">
            <input type="text" name="avatar" placeholder="Avatar" value="{{ Auth::user()->edit_avatar }}"/>
            <input type="file" name="disabled" placeholder="Avatar" style="display: none"/><br/>
            <a href="#" class="button avatar-type-toggle">upload instead</a> <button type="submit" class="button">link avatar</button>
        </form>
    </div>


<form id="user_profile_edit" action="{{ URL::base() }}/users/save_profile" method="post">
    <br/>
    <input type="hidden" name="avatar" value=""/>
    <input type="password" name="password" placeholder="Change Password"/><br/>
    <input type="email" name="email" placeholder="E-mail" value="{{ Auth::user()->email }}"/><br/>
    <input type="text" name="name" placeholder="Real Name" value="{{ Auth::user()->name }}"/><br/>
    <input id="color_picker" type="text" name="color" placeholder="Color" value="{{ Auth::user()->color }}"/><br/>
    <textarea id="about_me_textarea" style="background-color: {{ Auth::user()->color }}" name="about_me" placeholder="About Me">{{ Auth::user()->about_me }}</textarea><br/>
    <button type="submit">save</button>
</form>