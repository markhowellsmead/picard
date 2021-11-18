(function ($) {
    $.extend($.fn, {
        anchorAnimate: function () {
            return this.each(function () {
                $(this).bind('click.js-hashscroll', function (e) {
                    if ($(this).attr('href')) {
                        var targetAnchor = $(this).attr('href').split('#');
                        var destination = $('#' + targetAnchor[1]);
                        if (destination && destination.length) {
                            $(destination).scrollToMe();
                        }
                    }
                });
            });
        },
        scrollToMe: function () {
            var destination = $(this);
            if (destination && destination.length) {
                var destinationTop = destination.offset().top;

                console.log(document.querySelector('.c-pageheader').offsetHeight);

                destinationTop =
                    destinationTop - document.querySelector('.c-pageheader').offsetHeight;

                $(window).trigger(
                    'sh-js-hashscroll/scroll-start',
                    document.querySelector('.c-pageheader').offsetHeight,
                    destinationTop
                );

                $('html:not(:animated),body:not(:animated)')
                    .stop()
                    .animate({ scrollTop: Math.floor(destinationTop) }, 600);
            }
            return this;
        },
    });

    $(window).on('load.js-hashscroll', function () {
        if (
            window.location.hash &&
            window.location.hash !== '' &&
            $(window.location.hash) &&
            $(window.location.hash).length === 1
        ) {
            setTimeout(function () {
                $(window.location.hash).scrollToMe();
            }, 200);
        }
    });
})(jQuery);
