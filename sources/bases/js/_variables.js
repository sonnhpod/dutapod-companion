
// Screen sizes variables - in pixel value
const minXxlScreenWidth = 1400;

const maxXlScreenWidth = 1399;
const minXlScreenWidth = 1200;

const maxLgScreenWidth = 1199;
const minLgScreenWidth = 992;

const maxMdScreenWidth = 991;
const minMdScreenWidth = 768;

const maxSmScreenWidth = 767;
const minSmScreenWidth = 576;

const maxXsScreenWidth = 575;

// Redraw the DOM element with the delay of 20ms
const redrawDelay = 20;//ms

var forceRedraw = function(element){

    if (!element) { return; }

    var n = document.createTextNode(' ');
    var disp = element.style.display;  // don't worry about previous display style

    element.appendChild(n);
    element.style.display = 'none';

    setTimeout(function(){
        element.style.display = disp;
        n.parentNode.removeChild(n);
    },redrawDelay); // you can play with this timeout to make it as short as possible
}

// Screen size parameter
export { maxXsScreenWidth };
export { minSmScreenWidth, maxSmScreenWidth };
export { minMdScreenWidth, maxMdScreenWidth };
export { minLgScreenWidth, maxLgScreenWidth };
export { minXlScreenWidth, maxXlScreenWidth };
export { minXxlScreenWidth };

// Force redraw parameter
export { redrawDelay };
export { forceRedraw };