@layout('common.template')

@section('title')
    {{ $reply->user->display_name }}'s reply to {{ $reply->grandparent->title }}
@endsection

@section('main_content')
    <?php $post = $reply->grandparent; ?>
    @include('posts.view')
    <div style="clear: both; margin-bottom: 50px;"></div>
    <hr noshade/>
    <div style="height: 25px"></div>
    @include('replies.single_view')
@endsection