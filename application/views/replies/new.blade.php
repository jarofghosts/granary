@layout('common.template')

@section('title')
New reply
@endsection

@section('header')
Reply
@endsection

@section('main_content')
@include('posts.view')
<div class="reply_container">
    <form method="post" action="{{ URL::base() }}/reply/new">
        <input type="hidden" name="grandparent_id" value="{{ $post->id }}"/>
        <input type="hidden" name="parent_id" value="0"/>
        <textarea class="reply_body_input" name="body" placeholder="reply"></textarea><br/>
        <button type="submit">submit</button>
    </form>
</div>
@endsection

@section('post_includes')
@if (Auth::check())
<script language="javascript">
    $(document).ready( function() {
        $(".reply_body_input").css('background-color', '{{ Auth::user()-> color}}');
    });
</script>
@endif
@endsection