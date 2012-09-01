<img src="{{ URL::base() }}{{ $category->logo }}" alt="{{ $category->title }}"/><br/>
{{ $category->title }} 
@if ($category->creator->id == Auth::user()->id || $category->creator->access_level < Auth::user()->access_level)
<a class="button" href="{{ URL::base() }}/categories/edit/{{ $category->id }}">edit</a>
@endif
<br/>created by {{ $category->creator->display_name }} <em>({{ count($posts) }} posts)</em>
