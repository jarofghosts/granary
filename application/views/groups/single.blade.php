@layout('common.template')

@section('title')
{{ $group->title }}
@endsection

@section('header')
{{ $group->title }}
@endsection

@section('main_content')
<img src="{{ URL::base() }}{{ $group->logo }}" alt="{{ $group->title }}"/>
<br/>
<blockquote>{{ $group->description }}</blockquote>
<?php $members = count($group->members) ?>
{{ $members }} members:<br/>
<ol>
@foreach ( $group->members as $member )

    <li>{{ $member->display_name }}

@endforeach
</ol>
<a href="{{ URL::base() }}/messages/new_group/{{ $group->id }}" class="button">message</a>
@endsection