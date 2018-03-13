// Add class for .aligncenter images so that they can be targeted in scss

(function($) {
  $('figure.wp-caption.aligncenter').removeAttr('style');
  $('img.aligncenter').wrap('<figure class="centered-image" />');
}) (jQuery);