jQuery(document).ready(function () {
  'use strict';

  jQuery(document).on('click', '.upload-button', function (e) {
    e.preventDefault();
    var clickedElement = jQuery(this);
    var image = wp.media().open()
      .on('select', function (e) {
        var uploaded_image = image.state().get('selection').first();
        var image_url = uploaded_image.toJSON().url;
        clickedElement.prev('.image-url').val(image_url).trigger('change');
      });
  });
});