$(document).ready( function() {
    $(".messages").bind('click', function() {
        window.location = $(this).children('a').attr('href');
    });
    $(document).bind('scroll', function() {
    	if ($(document).scrollTop() > 115 && $("#float_content_box").css('opacity') < 1) {
    		$("#float_content_box").stop(false, true).css('margin-left', '300px').css('top', '-50px').
    		show().animate({
    			'opacity' : '1',
    			'top' : '10px',
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
    })
});