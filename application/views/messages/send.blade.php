@layout('common.template')

@section('title')
Compose message@if ($recipient)
 to {{ $recipient->display_name }}
@endif
@endsection

@section('main_content')
@include('messages.send_form')
@endsection