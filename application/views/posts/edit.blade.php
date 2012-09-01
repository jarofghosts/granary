@layout('common.template')

@section('title')
Edit Post
@endsection

@section('header')
Edit 
@if (Auth::user()->id != $post->user->id)
{{ $post->user->display_name }}'s
@else
your
@endif
 post
@endsection

@section('main_content')
<form method="post" action="{{ URL::base() }}/posts/edit" id="post_form">
    <input type="hidden" name="id" value="{{ $post->id }}"/>
    <br/>Category: 
    <select name="category_id" id="category_select">
        @foreach (Category::all() as $category)
        <option value="{{ $category->id; }}"
                @if ($category->id == $post->category->id)
                 selected
                 @endif
                >{{ $category->title; }}</option>
        @endforeach
    </select><br/>
    <input type="text" name="title" placeholder="Title" value="{{ $post->title }}"/><br/>
    <textarea name="body" placeholder="Body" class="post_body_input" style="background-color: {{ $post->user->color }}">{{ $post->body_source }}</textarea><br/>
    <button type="submit">Submit</button>
</form>
@endsection
