export function scrollTo(obj) {
    if (obj.speed === undefined) {
        obj.speed = 500;
    }

    if (obj.animation === undefined) {
        obj.animation = false;
    }

    if (obj.offset === undefined) {
        obj.offset = $('.header').height();
    }

    if (obj.element.length > 0) {
        $('html, body').animate({
            scrollTop: obj.element.offset().top - obj.offset
        }, obj.speed, function () {
            if (obj.animation) {
                obj.element.addClass(obj.animation);
            }
        });
    } else {
        console.warn('ScrollTo function: "element" does not exists!');
    }
}

$(function() {
    'use strict';

    $('body').on('click', '.js-scroll-to', function(e) {
        e.preventDefault();

        let $this = $(this);

        let targetSelector = $this.attr('data-target');
        if (!targetSelector) {
            targetSelector = $this.attr('href');
        }

        if (targetSelector.indexOf(window.location.pathname) >= 0) {
            targetSelector = targetSelector.replace(window.location.pathname, '');
        }

        let $target = $(targetSelector);
        if ($target.length === 0) {
            return;
        }

        scrollTo({
            element: $target
        });
    });
});
