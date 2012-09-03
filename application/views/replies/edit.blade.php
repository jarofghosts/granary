@layout('common.template')

@section('title')
Edit Reply
@endsection

@section('header')
Edit
@endsection

@section('main_content')
@include('posts.view')
<div class="reply_container">
    <form method="post" action="{{ URL::base() }}/!{{ $reply->grandparent->category->handle }}/<{{ $reply->grandparent->slug }}/>{{ $reply->slug }}/edit">
        <input type="hidden" name="reply_id" value="{{ $reply->id }}"/>
        <textarea class="reply_body_input" name="body" placeholder="reply">{{ $reply->body_source }}</textarea><br/>
        <button type="submit">save</button>
    </form>
</div>
@endsection

@section('post_includes')
<script language="javascript">
    $(document).ready( function() {
        $(".reply_body_input").css('background-color', '{{ Auth::user()-> color}}');
    });
</script>
@endsection