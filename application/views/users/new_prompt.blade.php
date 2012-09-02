@layout('common.template')

@section('title')
Hmm...
@endsection

@section('main_content')
{{ $username }} isn't in our database anywhere. If you'd like, though, you can <a class="button" href="{{ URL::base() }}/users/confirm/{{ $username }}">register it right now</a>.
<br/><br/>
Alternatively, you could try that login again
@include('users.login_form_only')
@endsection