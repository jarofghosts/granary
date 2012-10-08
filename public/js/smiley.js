$( function() {
	$("#smiley-image").ajaxForm({
		dataType: 'json',
		success: function( res ) {

			if ( res.success ){

				$(".smiley").attr('src', res.img_src );
				$("#smiley-edit input[name=replacement]").val(res.img_src);

			} else {

				meow('There was an error changing the smiley image.', 'error');

			}
		},
		error: function ( error ) {
			meow(error, 'error');
		}
	});
})