	$("#avatar-form").ajaxForm({
		dataType: 'json',
		success: function( res ) {

			if ( res.success ){

				$(".mini_avatar").attr('src', res.img_src );
				$("#user_profile_edit input[name=avatar]").val(res.img_src);
				$(".avatar-toggle").trigger('click');

			} else {

				meow('There was an error changing that there avatar.');

			}
		},
		error: function ( error ) {
			meow(error);
		}
	});