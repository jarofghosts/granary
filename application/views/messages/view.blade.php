@layout('common.template')

@section('title')
{{ $message->subject }} -{{ $message->sender->display_name }}
@endsection

@section('header')
{{ $message->subject }}
@endsection

@section('main_content')
@include('messages.single_view')
@endsection