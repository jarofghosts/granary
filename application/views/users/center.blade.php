@layout('common.template')

@section('title')
{{ Auth::user()->display_name }}'s User Center
@endsection

@section('header')
{{ Auth::user()->display_name }}
@endsection

@section('main_content')
@include('users.center_actions')
@endsection