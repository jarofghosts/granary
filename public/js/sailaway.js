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

    $(".quick-reply").bind('click', function(e) {
        e.preventDefault();
        container = $(this).attr('href');
        $(container).css('opacity', 0).css('height', 0)
        .toggle().animate({
            height: 125,
            opacity: 1
        }, function() {
            $(container + ' textarea').focus();
        });
    });
    $(".quick-reply-entry").bind('keydown', function(e) {
        if (e.keyCode === 10 || e.keyCode == 13 && e.ctrlKey) {
            sendQuickReply($(this).data('post-id'));
        }
    });
    $(".quick-reply-entry").bind('keyup', function(e) {
        if (e.keyCode === 27) {
            $("#post-" + $(this).data('post-id') + " .quick-reply").trigger('click');
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

function sendQuickReply( post_id ) {
    $.post('/replies/new',
        { grandparent_id: post_id,
          body: $("#qr-" + post_id + " textarea").val() },
        function(res) {
            if (res.success === 'success') {
                $("#post-" + post_id + " .replies-count").text(res.reply_count);
                $("#qr-" + post_id).fadeOut(100, function() {
                    $("#qr-" + post_id + " textarea").val('');
                });
                meow('Reply saved!', 'good');
            } else {
                meow('There was an error sending the quick reply', 'error');
            }
        }, 'json');
}