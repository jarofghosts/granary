$( function() {
    $(".messages").bind('click', function() {
        window.location = $(this).children('a').attr('href');
    });
    $(document).bind('scroll', function() {
    	if ($(document).scrollTop() > 115 && $("#float_content_box").css('opacity') < 1) {
    		$("#float_content_box").stop(false, true).css('margin-left', '300px').css('top', '-50px').
    		show().animate({
    			'opacity' : '1',
    			'top' : '15px',
    			'margin-left' : '0px'
    		}, 200);
    	} else if ($(document).scrollTop() <= 115) {
    		$("#float_content_box").stop(false, true).
    		animate({
    			'opacity' : '0',
    			'top' : '-50px',
    			'margin-left' : '300px'
    		}, 200, function() {
                $("#float_content_box").hide();
            });
    	}
    });
    $(".up").bind('click', function(e) {
        e.preventDefault();
        post = $(this).parents('article').attr('id');
        post_id = post.substring(5);

        $.post('/posts/up/' + post_id,
            function(res) {
                if (res.success && res.changed)
                {
                    $('#' + post + ' .down').animate( { opacity: .4 } );
                    $('#' + post + ' .up').animate( { opacity: 1 } );
                } else if (!res.success) {
                    meow('There was an error voting on the post.');
                }
            }, 'json');
    });
    $(".down").bind('click', function(e) {
        e.preventDefault();
        post = $(this).parents('article').attr('id');
        post_id = post.substring(5);

        $.post('/posts/down/' + post_id,
            function(res) {
                if (res.success && res.changed)
                {
                    $('#' + post + ' .up').animate( { opacity: .4 } );
                    $('#' + post + ' .down').animate( { opacity: 1 } );
                    if (res.hide_post)
                    {
                        $('#' + post).animate( {
                            opacity: 0,
                            height: '0px'
                        }, function() {
                            $('#' + post).remove();
                        });
                    }
                } else if (!res.success) {
                    meow('There was an error voting on the post.');
                }
            }, 'json');

    });
});