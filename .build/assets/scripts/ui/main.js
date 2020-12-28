import '@sayhellogmbh/maybe-set-link-target';

(function ($) {
    $(function () {
        $('a').maybeSetLinkTarget();

        // Replace broken links with their content. (So that the link isn't displayed to the visitor)
        $('.broken_link').each(function () {
            $(this).replaceWith($(this).html());
        });
    });
})(jQuery);
