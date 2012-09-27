$( function() {
	$(".avatar-type-toggle").bind('click', function(e) {

		e.preventDefault();

		$("#avatar-form input[type=text]").toggle();
		$("#avatar-form input[type=file]").toggle();
			
		if ( $("#avatar-form input[type=text]").is(':visible') ) {

			$("#avatar-form input[type=text]").attr('name', 'avatar');
			$("#avatar-form input[type=file]").attr('name', 'disabled');
			$(".avatar-type-toggle").text('upload instead');
			$("#avatar-form button").text('link avatar');

		} else {

			$("#avatar-form input[type=text]").attr('name', 'disabled')
			$("#avatar-form input[type=file]").attr('name', 'avatar-upload');
			$(".avatar-type-toggle").text('link instead');
			$("#avatar-form button").text('upload avatar');

		}

	});

	$(".avatar-toggle").bind('click', function(e) {
		e.preventDefault();
		$("#avatar-form").toggle();
		if ($(".avatar-toggle").text() === 'change avatar') {
			$(".avatar-toggle").text('keep avatar');
		} else {
			$(".avatar-toggle").text('change avatar');
		}
	});

	$("#avatar-form").ajaxForm({
		dataType: 'json',
		success: function( res ) {

			if ( res.success ){

				$(".mini_avatar").attr('src', res.img_src );
				$("#user_profile_edit input[name=avatar]").val(res.img_src);
				$(".avatar-toggle").trigger('click');

			} else {

				meow('There was an error changing that there avatar.', 'bad');

			}
		},
		error: function ( error ) {
			meow(error, 'bad');
		}
	});
	$("#user_profile_edit").ajaxForm({
		success: function(res) {
			if (res !== 'success') {
				meow('There was an error saving your profile.', 'bad');
			} else {
				meow('Profile saved!', 'good');
			}
		}
	});
});