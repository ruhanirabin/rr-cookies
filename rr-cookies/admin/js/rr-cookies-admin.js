(function($) {
    'use strict';

    $(function() {
        // Initialize color pickers
        $('.rr-cookies-color-picker').wpColorPicker();

        // Preview updates
        function updatePreview() {
            const theme = $('#theme').val();
            const position = $('#banner_position').val();
            const backgroundColor = $('#banner_background_color').val();
            const textColor = $('#text_color').val();
            const buttonColor = $('#button_color').val();
            const buttonTextColor = $('#button_text_color').val();

            // Update preview styles
            const $preview = $('.rr-cookies-preview');
            $preview.css({
                'background-color': backgroundColor,
                'color': textColor
            });

            $('.rr-cookies-preview .button').css({
                'background-color': buttonColor,
                'color': buttonTextColor
            });
        }

        // Bind change events
        $('.rr-cookies-admin-wrapper select, .rr-cookies-admin-wrapper input').on('change', updatePreview);
        $('.rr-cookies-color-picker').wpColorPicker({
            change: updatePreview
        });

        // Initialize tooltips
        $('.rr-cookies-help-tip').tooltip({
            position: {
                my: 'left center',
                at: 'right+10 center'
            }
        });
    });
})(jQuery);
