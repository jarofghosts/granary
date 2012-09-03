$(document).ready( function() {

	$("li a").bind( 'click', function() {

		new_tab = $(this).attr('href');

		if (!$(new_tab).hasClass('tab_current')) 
		{

			$(".center_action").animate({ height: $(new_tab).
				height() })

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

});