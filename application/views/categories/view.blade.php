<img src="{{ URL::base() }}{{ $category->logo }}" alt="{{ $category->title }}"/><br/>
{{ $category->title }} 
@if (Auth::check() && (Auth::user()->can_edit($category->id)))
<a class="button" href="{{ URL::base() }}/categories/edit/{{ $category->id }}">edit</a>
@endif
<br/>created by <a href="{{ URL::base() }}/~{{ $category->creator->username }}">{{ $category->creator->display_name }}</a> <em>(posts: {{ count($posts) }})</em>
<br/>@if ( Auth::check() )
@if (Auth::user()->excludes($category->id))
<a href="{{ URL::base() }}/ignores/de/{{ $category->id }}" class="button">un-ignore</a>
@else
<a href="{{ URL::base() }}/ignores/exclude/{{ $category->id }}" class="button">ignore</a>
@endif
@endif