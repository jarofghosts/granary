function meow( message, type )
{
	type = typeof type !== 'undefined' ? type : 'general';

	random_offset = Math.floor(Math.random()*256);

	placing = 200 + ( $(".meow").length * 30 );

	error = "icon-warning-sign";
	good = "icon-ok-sign";
	general = "icon-exclamation-sign";

	switch (type) {
		case 'error' :
		case 'bad' :
			icon_type = error;
			break;
		case 'good' :
		case 'success' :
			icon_type = good;
			break;
		case 'general' :
		case 'default' :
		case 'neutral' :
		default:
			icon_type = general;
			break;
	}

	$('#main').prepend('<div class="meow newest-meow"></div>');

	$('.meow').stop(true, true);

	$(".newest-meow").removeClass('newest-meow').addClass('' + random_offset).css('opacity', '0').
	html( '<span>' + message + '</span><div class="meow-icon"><i class="' + icon_type + '"></i></div>' ).show().animate({
		'top' : placing + 'px',
		'right' : '100px',
		'opacity' : '1'
	});

	setTimeout(function() {
		$("." + random_offset).stop(true, true).animate({
		'top' : '400px',
		'right' : '75px',
		'opacity' : '0'
		}, function() {
			$("." + random_offset).remove();
		});
	}, 2500);


}