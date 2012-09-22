function meow( message )
{

	random_offset = Math.floor(Math.random()*256);

	$('#main').prepend('<div class="roar newest-roar"></div>');

	$(".newest-roar").removeClass('newest-roar').addClass('' + random_offset).css('opacity', '0').
	html( '<span>' + message + '</span><div class="roar-icon"><i class="icon-warning-sign"></i></div>' ).show().animate({
		'top' : '300px',
		'right' : '100px',
		'opacity' : '1'
	});

	setTimeout(function() {
		$("." + random_offset).animate({
		'top' : '400px',
		'right' : '75px',
		'opacity' : '0'
		}, function() {
			$("." + random_offset).remove();
		});
	}, 3000);


}