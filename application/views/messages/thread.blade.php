@layout('common.template')

@section('title')
{{ $messages[0]->subject }} -{{ $messages[0]->sender->display_name }}
@endsection

@section('header')
{{ $messages[0]->subject }}
@endsection

@section('main_content')
@foreach ($messages as $message)
@include('messages.single_view')
@endforeach
@endsection