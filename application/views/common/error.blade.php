@layout('common.template')

@section('title')
    Codename Sailor: Error
@endsection

@section('main_content')
    There has been an error: {{ $error_message }}<br/>
    @foreach ($errors as $error)
        Error: {{ print_r($error) }}<br/>
    @endforeach
@endsection

@section('footer')
    The end
@endsection