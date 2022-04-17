import {URL_HASH, findElementAsScrollIdByHash} from "./hash";
import {scrollTo} from "./scroll-to";

$(function() {
    'use strict';

    function autoScrollToElementByHash() {
        if (!URL_HASH) {
            return;
        }

        let $element = findElementAsScrollIdByHash();

        if (typeof $element === 'undefined') {
            return;
        }

        scrollTo({
            element: $element
        });
    }

    autoScrollToElementByHash();
});