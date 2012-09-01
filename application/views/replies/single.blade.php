@layout('common.template')

@section('title')
    {{ $reply->user->display_name }}'s reply to {{ $reply->grandparent->title }}
@endsection

@section('main_content')
    <?php $post = $reply->grandparent; ?>
    @include('posts.view')
    <div style="clear: both; margin-bottom: 50px;"></div>
@section('header')
    View Reply
@endsection

@section('main_content')
    @include('replies.single_view')
@endsection