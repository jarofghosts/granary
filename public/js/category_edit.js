$( function() {
		$("#logo-form").ajaxForm({
		dataType: 'json',
		success: function( res ) {

			if ( res.success ){

				$(".mini_avatar").attr('src', res.img_src );
				$("#category-form input[name=logo]").val(res.img_src);
				$(".avatar-toggle").trigger('click');

			} else {

				meow('There was an error changing the logo.', 'error');

			}
		},
		error: function ( error ) {
			meow(error, 'error');
		}
	});
	$(".avatar-type-toggle").bind('click', function(e) {

		e.preventDefault();

		$("#logo-form input[type=text]").toggle();
		$("#logo-form input[type=file]").toggle();
			
		if ( $("#logo-form input[type=text]").is(':visible') ) {

			$("#logo-form input[type=text]").attr('name', 'avatar');
			$("#logo-form input[type=file]").attr('name', 'disabled');
			$(".avatar-type-toggle").text('upload instead');
			$("#logo-form button").text('link logo');

		} else {

			$("#logo-form input[type=text]").attr('name', 'disabled')
			$("#logo-form input[type=file]").attr('name', 'avatar-upload');
			$(".avatar-type-toggle").text('link instead');
			$("#logo-form button").text('upload avatar');

		}

	});

	$(".avatar-toggle").bind('click', function(e) {
		e.preventDefault();
		$("#logo-form").toggle();
		if ($(".avatar-toggle").text() === 'change logo') {
			$(".avatar-toggle").text('keep logo');
		} else {
			$(".avatar-toggle").text('change logo');
		}
	});
});