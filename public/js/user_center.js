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

			$(new_tab).css('position', 'relative').
				show('slide', { direction: 'left' });
			$(new_tab).addClass('tab_current');

			$(".current").removeClass('current');
			$(this).parent().addClass('current');

		}

	});

});