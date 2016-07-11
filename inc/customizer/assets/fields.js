/**
 * file_description
 * @author shramee
 * @since 1.0.0
 */
jQuery(document).ready(function($){
	$( '.field-type-color' ).wpColorPicker();
	var ms_frame, $textField;
	$('.upload-button').on('click', function (event) {
		event.preventDefault();
		$textField = $(this).siblings('input');
		// If the media frame already exists, reopen it.
		if (ms_frame) {
			ms_frame.open();
			return;
		}
		// Create the media frame.
		ms_frame = wp.media.frames.ms_frame = wp.media({
			title: 'Choose Background Image',
			button: {text: 'Set As Background Image'},
			multiple: false  // Set to true to allow multiple files to be selected
		});
		// When an image is selected, run a callback.
		ms_frame.on('select', function () {
			// We set multiple to false so only get one image from the uploader
			attachment = ms_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here
			$textField.val(attachment.url).change();
		});
		// Finally, open the modal
		ms_frame.open();
	});
});
