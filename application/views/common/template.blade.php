<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width">
        @yield('pre_includes')
        @if (Auth::check())
        {{ HTML::style('css/user.css'); }}
        @endif
        {{ HTML::style('css/main.css'); }}
        {{ HTML::style('css/vendor/jquery-ui-1.8.23.custom.css'); }}
        {{ HTML::style('css/vendor/font-awesome.css'); }}
        {{ HTML::style('js/plugins/flexbox/css/jquery.flexbox.css'); }}
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Alfa+Slab+One' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        @if (Auth::check())
        <style type="text/css">
            .user-color {
                background-color: {{ Auth::user()->color }};
            }
        </style>
        @endif
    </head>
    <body>
        <div id="wrapper">
            <header>
                <h1 class="title"><a href="{{ URL::base() }}/posts">Granary</a></h1>
                @yield('head_name')
                <div id="head_user_box" class="user_box">
                    @if (Auth::check())
                    <div id="user" class="messages">
                        <i class="icon-home"></i><a href="{{ URL::base() }}/~/settings">{{ Auth::user()->display_name }}</a>
                    </div>
                    <div id="logout" class="messages">
                        <i class="icon-signout"></i><a href="{{ URL::base() }}/logout">Logout</a>
                    </div>        
                    <?php
                    $unread = Auth::user()->unread_messages();
                    $unread_count = count($unread);
                    ?>
                    <div id="unread" class="messages">
                        @if ($unread_count <= 1)
                        <i class="icon-comment"></i>
                        @else
                        <i class="icon-comments"></i>
                        @endif
                        <a href="{{ URL::base() }}/messages">{{ $unread_count }} unread message@if ($unread_count != 1)s@endif</a>
                    </div>
                    @else
                    <form method="post" action="{{ URL::base() }}/login">
                        <input type="text" name="username" placeholder="username"/>
                        <input type="password" name="password" placeholder="password"/>
                        <button type="submit">get in here</button>
                    </form>
                    @endif
                </div>
                @if (Auth::check())
                <div id="head_nav_box" class="nav_box">
                    <ul>
                        <li><a href="{{ URL::base() }}/posts/new">new post</a></li>
                        <li><a href="{{ URL::base() }}/categories/new">new category</a></li>
                        <li><a href="{{ URL::base() }}/groups/new">new group</a></li>
                        @if (Auth::user()->access_level > 5)
                        <li><a href="{{ URL::base() }}/smilies/new">new emoticon</a></li>
                        @endif
                    </ul>
                </div>
                <div id="float_content_box" class="fixed-left">
                    <div id="new-post" class="messages">
                        <i class="icon-pencil"></i><a href="{{ URL::base() }}/posts/new">new post</a>
                    </div>
                    <div id="new-category" class="messages">
                        <i class="icon-tag"></i><a href="{{ URL::base() }}/categories/new">new category</a>
                    </div>
                    <div id="new-group" class="messages">
                        <i class="icon-group"></i><a href="{{ URL::base() }}/groups/new">new group</a>
                    </div>
                    @if (Auth::user()->access_level > 5)
                    <div id="new-smiley" class="messages">
                        <i class="icon-bolt"></i><a href="{{ URL::base() }}/smilies/new">new emoticon</a>
                    </div>
                    @endif
                </div>
                @endif
            </header>
            <div id="main" role="main">
                <div class="header">
                    @yield('header')
                </div>
                <div id="main_pane">
                    @yield('main_content')
                </div>
            </div>
            <div id="push"></div>
        </div>
        <footer><div role="container" class="footer"><h6>Most of this crap is &copy; 2012 <a href="/~jarofghosts">jarofghosts</a></h6>@yield('footer')</div></footer>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
<script src="{{ URL::base() }}/js/plugins/mousetrap.min.js"></script>
<script defer src="{{ URL::base() }}/js/plugins/flexbox/js/jquery.flexbox.min.js"></script>
<script defer src="{{ URL::base() }}/js/sailaway.js"></script>
<script defer src="{{ URL::base() }}/js/plugins/keystrokes.js"></script>
<script defer src="{{ URL::base() }}/js/plugins/meow.js"></script>

@if (!Auth::check())
<script>
    $(document).ready( function() {
        $("input[name=username]").focus();
    });

</script>
@endif
@yield('post_includes')
    </body>
</html>