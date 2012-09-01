@layout('common.template')

@section('title')
{{ $user->display_name }}
@endsection

@section('header')
{{ $user->display_name }}
@endsection

@section('main_content')
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
    @if (Auth::check() && Auth::user()->id != $user->id)
    <hr noshade/>
    <a class="button" href="{{ URL::base() }}/messages/send/{{ $user->id }}">message</a>
    @if (Auth::user()->ignores($user->id))
    <a class="button" href="{{ URL::base() }}/ignores/un/{{ $user->id }}">un-ignore</a>
    @else
    <a class="button" href="{{ URL::base() }}/ignores/jerk/{{ $user->id }}">ignore</a>
    @endif
    @endif
</div>
<div style="clear: both;"></div>
<blockquote class="profile_block" style="background-color: {{ $user->color }}">{{ Sparkdown\Markdown ($user->about_me) }}</blockquote><br/>
@if (Auth::check())
@if (Auth::user()->id == $user->id || Auth::user()->access_level > $user->access_level)
<a class="button" href="{{ URL::base() }}/users/edit/{{ $user->id }}">edit</a>
@endif
@endif
@endsection

@section('footer')

@endsection