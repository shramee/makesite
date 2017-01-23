do ( $ = jQuery ) ->
	$body = $('body')

	$('#build-button').click ->
		$(this).toggleClass('button-primary')
		if ! $body.hasClass('build-on')
			$body.removeClass('focus-off');
			$body.addClass('focus-on build-on');
			$('#build').fadeIn();
			$('.metabox-holder').removeClass('columns-2').addClass('columns-1');
			$( document ).trigger( 'postboxes-columnchange' );
		else
			$body.removeClass('focus-on build-on');
			$( '#build' ).fadeOut();

	$('#build .properties h2').click -> $(this).parent().toggleClass 'hover'