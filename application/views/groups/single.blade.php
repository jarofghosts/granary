@layout('common.template')

@section('title')
{{ $group->title }}
@endsection

@section('header')
{{ $group->title }}
@endsection

@section('main_content')
<?php $members = count($group->members) ?>
{{ $members }} members:<br/>
<ol>
@foreach ( $group->members as $member )

    <li>{{ $member->display_name }}

@endforeach
</ol>
@endsection