@layout('common.template')

@section('title')
{{ $user->display_name }}'s user settings
@endsection

@section('main_content')
<form id="user_settings" method="post" action="{{ URL::base() }}/users/settings">
    <input type="text" name="front_page_posts" placeholder="10" value="{{ $preference->front_page_posts }}"/> posts on the front page<br/>
    <input type="text" name="rating_threshold" placeholder="0" value="{{ $preference->rating_threshold }}"/> minimum rating for display<br/>
    <input type="text" name="replies_per_page" placeholder="0" value="{{ $preference->replies_per_page }}"/> replies per page (0 for unlimited)<br/>
    <button type="submit">save</button>
</form>
@endsection