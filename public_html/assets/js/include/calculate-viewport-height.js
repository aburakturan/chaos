import {debounce} from "debounce";

$(function() {
    'use strict';

    function calcViewPortH() {
        var vh = $(window).height() / 100;
        document.documentElement.style.setProperty('--vh', vh + 'px');
    }

    calcViewPortH();
    window.onresize = debounce(calcViewPortH, 100);
});