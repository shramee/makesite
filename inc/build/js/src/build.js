(function($) {
  var $body;
  $body = $('body');
  $('#build-button').click(function() {
    $(this).toggleClass('button-primary');
    if (!$body.hasClass('build-on')) {
      $body.removeClass('focus-off');
      $body.addClass('focus-on build-on');
      $('#build').fadeIn();
      $('.metabox-holder').removeClass('columns-2').addClass('columns-1');
      return $(document).trigger('postboxes-columnchange');
    } else {
      $body.removeClass('focus-on build-on');
      return $('#build').fadeOut();
    }
  });
  return $('#build .properties h2').click(function() {
    return $(this).parent().toggleClass('hover');
  });
})(jQuery);
