@layout('common.template')

@section('title')
Granary
@endsection

@section('main_content')
This is Granary.<br/>

@if (Auth::check())
<a href="{{ URL::base() }}/posts/new">Make a new post</a>.. or <a href="{{ URL::base() }}/logout">logout</a>.<br/>
Also, possibly <a href="{{ URL::base() }}/categories/new">make a new category</a> or <a href="{{ URL::base() }}/posts/">Look at some posts</a>
@else
You pretty much need to <a href="{{ URL::base() }}/login">login</a> to do anything.<br/>
If you don't already have an account, try to <a href="{{ URL::base() }}/login">login</a> anyway. Or, if you're feeling more official, you can always 
<a href="{{ URL::base() }}/users/new">register an account</a> like a big boy.
@endif
@endsection

@section('post_includes')
<script src="{{ URL::base() }}/sailor/js/post.js"></script>
@endsection
