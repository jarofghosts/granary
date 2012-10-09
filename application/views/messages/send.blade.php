@layout('common.template')

@section('title')
Compose message@if ($recipient)
 to {{ $recipient->display_name }}
@endif
@endsection

@section('main_content')
@if ($parent_id)
<?php $messages = Message::thread($parent_id); ?>
<h1>{{ $messages[0]->subject}}</h1><br/>
@foreach ($messages as $message)
@include('messages.single_view')
@endforeach
@endif
@include('messages.send_form')
@endsection

@section('post_includes')
<script>
$(document).ready( function() {
    $('#recipient_id').flexbox('{{ URL::base() }}/search/users',
        {
            watermark: 'User',
            autoCompleteFirstMatch: true,
            paging: {
                pageSize: 20
            }

        });
});
</script>
@endsection