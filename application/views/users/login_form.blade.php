@layout('common.template')

@section('title')
    Login
@endsection

@section('header')
    Login to Sailor
@endsection

@section('main_content')
<form method="post" action="{{ URL::base() }}/login" id="login_form">
    <input type="text" name="username" placeholder="username"/><br/>
    <input type="password" name="password" placeholder="password"/><br/>
    <button type="submit">Login</button>
</form>
@endsection