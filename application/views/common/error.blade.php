@layout('common.template')

@section('title')
    BRRAAAAAPPPP ERROR ERROR WWWEEEEEEOOOOOOOOOOOOOWWWW
@endsection

@section('header')
THAT DOESN'T GO THERE.
@endsection

@section('main_content')
<img src="/img/error.jpg" alt="OH GOD WHY?"/><br/>
<marquee behavior="scroll" direction="left" scrollamount="30">{{ $error_message }}</marquee>
@endsection

@section('footer')
    The end
@endsection