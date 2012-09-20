<div class="profile_image">
    <img src="{{ URL::base() }}{{ $user->avatar }}" alt="{{ $user->display_name }}"/>
</div>

<div class="profile_summary">
    @if ($user->activity || $user->id == 1)
    <strong>Online</strong>
    @else
    <em>Offline</em>
    @endif
    <hr noshade/>
    Posts: {{ count($user->posts) }}<br/>
    Replies: {{ count($user->replies) }}<br/>
    Categories: {{ count($user->categories) }}<br/>
    Groups: {{ count($user->groups) }}<br/>
    <hr noshade/>
    Experience: {{ $user->experience }}<br/>
    Registered: {{ date('m/d/Y', strtotime($user->created_at)) }}
    @if (Auth::check())
    <hr noshade/>
    @if (Auth::user()->id != $user->id)
    <a class="button" href="{{ URL::base() }}/messages/send/{{ $user->id }}">message</a>
    @endif
    @if (Auth::user()->ignores($user->id))
    <a class="button" href="{{ URL::base() }}/ignores/un/{{ $user->id }}">un-ignore</a>
    @else
    <a class="button" href="{{ URL::base() }}/ignores/jerk/{{ $user->id }}">ignore</a>
    @endif
    @endif
@if (Auth::check())
@if (Auth::user()->can_edit_user($user->id))
<a class="button" href="{{ URL::base() }}/users/edit/{{ $user->id }}">edit</a>
@endif
@endif
</div>