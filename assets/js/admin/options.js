/**
 * Theme Options — media uploader for image fields.
 *
 * @package uk-mosque
 */
jQuery(function ($) {
    'use strict';

    var frame;

    $(document).on('click', '.uk-mosque-image-upload', function (e) {
        e.preventDefault();

        var $wrap = $(this).closest('.uk-mosque-image-field');

        frame = wp.media({
            title: 'Select image',
            button: { text: 'Use this image' },
            multiple: false
        });

        frame.on('select', function () {
            var att = frame.state().get('selection').first().toJSON();
            var src = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;

            $wrap.find('input[type="hidden"]').val(att.id);
            $wrap.find('.uk-mosque-image-field__preview').html($('<img>', { src: src, alt: '' }));
            $wrap.find('.uk-mosque-image-remove').prop('disabled', false);
        });

        frame.open();
    });

    $(document).on('click', '.uk-mosque-image-remove', function (e) {
        e.preventDefault();

        var $wrap = $(this).closest('.uk-mosque-image-field');

        $wrap.find('input[type="hidden"]').val('');
        $wrap.find('.uk-mosque-image-field__preview').empty();
        $(this).prop('disabled', true);
    });
});
