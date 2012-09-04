<div class="profile_image">
<img src="{{ URL::base() }}{{ $category->logo }}" alt="{{ $category->title }}"/>
</div>
<div class="profile_summary">
	Created by <a href="{{ URL::base() }}/~{{ $category->creator->username }}">{{ $category->creator->display_name }}</a>
    <hr noshade/>
    Permalink: <a href="{{ URL::base() }}/!{{ $category->handle }}">/!{{ $category->handle }}</a><br/>
    Posts: {{ count($category->posts) }}<br/>
    Moderators: {{ count($category->mods()) }}<br/>
    <hr noshade/>
    Clearance Required: {{ $category->clearance_required() }}<br/>
    Created: {{ date('m/d/Y', strtotime($category->created_at)) }}
    @if (Auth::check() && Auth::user()->id != $category->creator->id)
    <hr noshade/>
    @if (Auth::user()->ignores($user->id))
    <a class="button" href="{{ URL::base() }}/ignores/de/{{ $category->id }}">un-ignore</a>
    @else
    <a class="button" href="{{ URL::base() }}/ignores/exclude/{{ $category->id }}">ignore</a>
    @endif
    @endif
</div>
<div style="clear: both;"></div>
<blockquote class="profile_block">{{ Sparkdown\Markdown ($category->description) }}</blockquote><br/>
@if (Auth::check())
@if (Auth::user()->can_edit($category->id))
<a class="button" href="{{ URL::base() }}/categories/edit/{{ $category->id }}">edit</a>
@endif
@endif
</div>