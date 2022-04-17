export const URL_HASH = window.location.hash.replace('#', '');

export function findElementAsScrollIdByHash() {
    let $element = $(`[data-scroll-id=${URL_HASH}]`);

    if ($element.length === 0) {
        console.log(`"data-scroll-id -> ${URL_HASH}" element is not found!`);
        return;
    }

    return $element;
}

export function findElementAsHrefIdByHash() {
    let $element = $(`[href="#${URL_HASH}"]`).not('active');

    if ($element.length === 0) {
        console.log(`"href -> ${URL_HASH}" element is not found!`);
        return;
    }

    return $element;
}