@layout('common.template')

@section('title')
New smiley
@endsection

@section('header')
Smilies
@endsection

@section('main_content')
<div class="reply_container">
    <form method="post" action="{{ URL::base() }}/smilies/new">
        <input type="text" name="trigger" placeholder=":D"/>
        <input type="text" name="replacement" placeholder="url of image"/><br/>
        <button type="submit">submit</button>
    </form>
</div>
@endsection