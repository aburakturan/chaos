$(function() {
    'use strict';

    function fullHeight() {
        let windowH = $(window).height(),
            headerH = $('.header').length > 0 ? $('.header').height() : 0;

        $('.js-full-height').each(function() {
            let $this = $(this);

            $this.css('min-height', windowH - headerH);
        });
    }

    fullHeight();
    $(window).resize(fullHeight);
});
