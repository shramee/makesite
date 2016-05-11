/**
 * file_description
 * @author shramee
 * @since 1.0.0
 */
jQuery(document).ready(function($){
	$( '.field-type-color' ).wpColorPicker();
	var wpd_frame, $textField;
	$('.upload-button').on('click', function (event) {
		event.preventDefault();
		$textField = $(this).siblings('input');
		// If the media frame already exists, reopen it.
		if (wpd_frame) {
			wpd_frame.open();
			return;
		}
		// Create the media frame.
		wpd_frame = wp.media.frames.wpd_frame = wp.media({
			title: 'Choose Background Image',
			button: {text: 'Set As Background Image'},
			multiple: false  // Set to true to allow multiple files to be selected
		});
		// When an image is selected, run a callback.
		wpd_frame.on('select', function () {
			// We set multiple to false so only get one image from the uploader
			attachment = wpd_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here
			$textField.val(attachment.url).change();
		});
		// Finally, open the modal
		wpd_frame.open();
	});
});
