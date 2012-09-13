$(document).ready( function() {

	$("#user_profile_edit").ajaxForm({
		success: function(res) {
			if (res !== 'success') {
				alert('There was an error saving your profile.');
			}
		}
	});
	$("#board_prefs_edit").ajaxForm({
		success: function(res) {
			if (res !== 'success') {
				alert('There was an error saving your profile.');
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

				window.alert('There was an error changing your avatar.');

			}
		},
		error: function ( error ) {
			window.alert(error);
		}
	});

	$("li a").bind( 'click', function() {

		new_tab = $(this).attr('href');

		if (!$(new_tab).hasClass('tab_current')) 
		{

			$(".tab_current").css('position', 'absolute').
				fadeOut();
			$(".tab_current").removeClass('tab_current');

			$(new_tab).show('slide', { direction: 'left' }, function() {
				$(new_tab).css('position', 'relative');
			});
			$(new_tab).addClass('tab_current');

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