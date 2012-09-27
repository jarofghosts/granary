$(document).ready( function() {

	$("#user_profile_edit").ajaxForm({
		success: function(res) {
			if (res !== 'success') {
				meow('There was an error saving your profile.', 'bad');
			} else {
				meow('Profile saved!', 'good');
			}
		}
	});
	$("#board_prefs_edit").ajaxForm({
		success: function(res) {
			if (res !== 'success') {
				meow('There was an error saving your preferences.', 'bad');
			} else {
				meow('Preferences saved!', 'good');
			}
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

				meow('There was an error changing your avatar.', 'error');

			}
		},
		error: function ( error ) {
			meow(error, 'error');
		}
	});

	$("li a").bind( 'click', function() {
		new_tab = $(this).attr('href');

		if (!$(new_tab).hasClass('tab_current')) 
		{

			$(".tab_current").removeClass('tab_current').stop(false, true)
			.css('width', '100%').css('position', 'absolute').css('top', 0).animate({
				'margin-top' : '50px',
				'opacity' : '0'
			}, function() {
				$(this).hide().removeClass('tab_current')
				.css('margin-top', 0);
			});
			$(new_tab).addClass('tab_current').stop(false, true).css('width', '100%').show().animate({
				'opacity' : '1'
			}).css('position', 'relative');

			$(".current").removeClass('current');
			$(this).parent().addClass('current');

		}

	});

	$(".exclusion_head").bind('click', function() {

		new_tab = $(this).children('a').attr('href');

		if ( $(new_tab).is(':visible')) {
			$(new_tab).hide('blinds');
		} else {
			$(new_tab).show('blinds');
		}
	});

	$(".exclusion_head a").bind('click', function(e) {
		e.preventDefault();
	});

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

});