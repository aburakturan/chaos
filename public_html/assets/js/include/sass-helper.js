// Breakpoints
export const GRID_BREAKPOINTS = {
    xxs: 0,
    xs: 400,
    sm: 576,
    md: 768,
    lg: 992,
    xl: 1350,
    xxl: 1600,
    xxxl: 1900,
};

export const GRID_GUTTER_WIDTH = 20;

export function mediaBreakpointUp($name) {
    return window.matchMedia('(min-width: ' + GRID_BREAKPOINTS[$name] + 'px)').matches;
}

export function mediaBreakpointDown($name) {
    return window.matchMedia('(max-width: ' + GRID_BREAKPOINTS[$name] + 'px)').matches;
}
