require('@fancyapps/fancybox');

(function ($) {
    document.querySelectorAll('.wp-block-gallery').forEach(gallery => {
        const links = gallery.querySelectorAll(
            'a[href$=".jpg"]:not([target]):not([download]), a[href$=".png"]:not([target]):not([download]), a[href$=".gif"]:not([target]):not([download]), a[href$=".svg"]:not([target]):not([download]), a[href$=".webp"]:not([target]):not([download])'
        );

        if (!!links.length) {
            const random = Math.floor(Math.random() * 10000);
            const gallery_id = `gallery_${random}`;
            links.forEach(link => {
                link.setAttribute('data-fancybox', gallery_id);
            });
        }
    });

    $(
        "a[href$='.jpg']:not([target]):not([download]), a[href$='.png']:not([target]):not([download]), a[href$='.gif']:not([target]):not([download]), a[href$='.svg']:not([target]):not([download]), a[href$='.webp']:not([target]):not([download])"
    ).fancybox({
        transitionIn: 'elastic',
        transitionOut: 'elastic',
        speedIn: 600,
        speedOut: 200,
        overlayShow: false,
    });
})(jQuery);
