(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.redrawDelay = exports.minXxlScreenWidth = exports.minXlScreenWidth = exports.minSmScreenWidth = exports.minMdScreenWidth = exports.minLgScreenWidth = exports.maxXsScreenWidth = exports.maxXlScreenWidth = exports.maxSmScreenWidth = exports.maxMdScreenWidth = exports.maxLgScreenWidth = exports.forceRedraw = void 0;
// Screen sizes variables - in pixel value
var minXxlScreenWidth = exports.minXxlScreenWidth = 1400;
var maxXlScreenWidth = exports.maxXlScreenWidth = 1399;
var minXlScreenWidth = exports.minXlScreenWidth = 1200;
var maxLgScreenWidth = exports.maxLgScreenWidth = 1199;
var minLgScreenWidth = exports.minLgScreenWidth = 992;
var maxMdScreenWidth = exports.maxMdScreenWidth = 991;
var minMdScreenWidth = exports.minMdScreenWidth = 768;
var maxSmScreenWidth = exports.maxSmScreenWidth = 767;
var minSmScreenWidth = exports.minSmScreenWidth = 576;
var maxXsScreenWidth = exports.maxXsScreenWidth = 575;

// Redraw the DOM element with the delay of 20ms
var redrawDelay = exports.redrawDelay = 20; //ms

var forceRedraw = exports.forceRedraw = function forceRedraw(element) {
  if (!element) {
    return;
  }
  var n = document.createTextNode(' ');
  var disp = element.style.display; // don't worry about previous display style

  element.appendChild(n);
  element.style.display = 'none';
  setTimeout(function () {
    element.style.display = disp;
    n.parentNode.removeChild(n);
  }, redrawDelay); // you can play with this timeout to make it as short as possible
};

// Screen size parameter

// Force redraw parameter

},{}],2:[function(require,module,exports){
"use strict";

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
var _variables = _interopRequireWildcard(require("../../../bases/js/_variables.js"));
function _getRequireWildcardCache(e) { if ("function" != typeof WeakMap) return null; var r = new WeakMap(), t = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(e) { return e ? t : r; })(e); }
function _interopRequireWildcard(e, r) { if (!r && e && e.__esModule) return e; if (null === e || "object" != _typeof(e) && "function" != typeof e) return { "default": e }; var t = _getRequireWildcardCache(r); if (t && t.has(e)) return t.get(e); var n = { __proto__: null }, a = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var u in e) if ("default" !== u && {}.hasOwnProperty.call(e, u)) { var i = a ? Object.getOwnPropertyDescriptor(e, u) : null; i && (i.get || i.set) ? Object.defineProperty(n, u, i) : n[u] = e[u]; } return n["default"] = e, t && t.set(e, n), n; }
/** Package dutapod-companion */

/** 1. Add functions when the HTML document is fully loaded and parsed, but before external stylesheet, images, iframes are loaded
 * - This stage is ealier than window.onload ( window.addEventListener('load', function({ // callback function goes here } ) ) )
 */
document.addEventListener('DOMContentLoaded', function () {
  // 1. Genera variables
  // Screen sizes variables - in pixel value -import from _variables module - 'bases' directory

  // 2. Content selector variables
  var outermostContentContainerSelector = "div#content.site-content";
  var astraContentContainerSelector = "".concat(outermostContentContainerSelector, " > div.ast-container");
  var contentAreaContainerSelector = "".concat(astraContentContainerSelector, " > div#primary.content-area");
  var entryContentContainerSelector = "".concat(contentAreaContainerSelector, " > main#main > article.page > div.entry-content");
  var heroSectionSelector = "".concat(entryContentContainerSelector, "  > div.hero-section-image-container");
  var bestSellingProductsSectionSelector = "".concat(entryContentContainerSelector, " > div.best-selling-products-lazy-load-container");
  var testimonialSectionID = "sp-testimonial-free-wrapper-999";
  var heroSectionID = "hero-section-image-id";
  var astraContentContainer = document.querySelector(astraContentContainerSelector);
  var contentAreaContainer = document.querySelector(contentAreaContainerSelector);
  var astraScrollTopBtn = document.getElementById('ast-scroll-top');
  var astraContentContainerStyleData = window.getComputedStyle(astraContentContainer);

  // const astContentContainerMarginLeft = astraContentContainerStyleData.getPropertyValue('margin-left');//OK - 126.667px. Expect 437.22px
  // const astContentContainerMarginRight = astraContentContainerStyleData.getPropertyValue('margin-right');//OK - 126.667px. Expect 437.22px

  var astContentContainerMarginLeft = astraContentContainerStyleData.marginLeft; //OK. Got 437.22px
  astContentContainerMarginLeft = astContentContainerMarginLeft.substring(0, astContentContainerMarginLeft.length - 2); //437.22 in string format

  var astContentContainerMarginRight = astraContentContainerStyleData.marginRight; //OK. Got 437.22px
  astContentContainerMarginRight = astContentContainerMarginRight.substring(0, astContentContainerMarginRight.length - 2); //437.22 in string format

  // const astContentContainerPaddingLeft = astraContentContainerStyleData.getPropertyValue('padding-left');//OK - 20px
  // const astContentContainerPaddingRight = astraContentContainerStyleData.getPropertyValue('padding-right');//OK - 20px

  var astContentContainerPaddingLeft = astraContentContainerStyleData.paddingLeft;
  astContentContainerPaddingLeft = astContentContainerPaddingLeft.substring(0, astContentContainerPaddingLeft.length - 2); // 20 in string format

  var astContentContainerPaddingRight = astraContentContainerStyleData.paddingRight;
  astContentContainerPaddingRight = astContentContainerPaddingRight.substring(0, astContentContainerPaddingRight.length - 2); // 20 in string format

  /** 1. Add negative margin value to widen the size of the testimonial section - with the screen size >= md width */
  if (window.screen.width > _variables.minMdScreenWidth) {
    // 1. Recalculate the margin to centralize the testimonial section 
    var testimonialSection = document.getElementById(testimonialSectionID);
    var testimonialSectionWidth = testimonialSection.offsetWidth; // get testimonial Section 90vw width in pixel    

    var testimonialSectionScreenMarginLeft = 0.05 * window.screen.width; // 5vw - 5% view port width

    var testimonialSectionMarginLeft = parseFloat(astContentContainerMarginLeft) + parseFloat(astContentContainerPaddingLeft) - parseFloat(testimonialSectionScreenMarginLeft);
    testimonialSectionMarginLeft *= -1;

    // Set negative margin left value 
    // testimonialSection.style.marginLeft = `-${testimonialSectionMarginLeft}px`;
    testimonialSection.style.marginLeft = "".concat(testimonialSectionMarginLeft, "px");

    // 2. Update sp-testimonial height - move to a function that bound to 'load' event.        
  }

  /** 2. Reposition the hero section in the mobile display */
  if (window.screen.width < _variables.maxXsScreenWidth) {
    // 1. 
    // const heroSection = document.getElementById( heroSectionID );
    var heroSection = document.querySelector(heroSectionSelector); //OK      

    var heroSectionData = window.getComputedStyle(heroSection);
    var originalHeroSectionMarginLeft = heroSectionData.marginLeft; // Expect 24px

    originalHeroSectionMarginLeft = originalHeroSectionMarginLeft.substring(0, originalHeroSectionMarginLeft.length - 2);

    // let updateHeroSectionMarginLeft = parseFloat(astContentContainerPaddingLeft) + parseFloat(originalHeroSectionMarginLeft);
    var updateHeroSectionMarginLeft = parseFloat(astContentContainerPaddingLeft) + parseFloat(astContentContainerMarginLeft);
    updateHeroSectionMarginLeft *= -1;
    heroSection.style.marginLeft = "".concat(updateHeroSectionMarginLeft, "px");

    // 2. Disable the Astra scroll top button:
    // astContentContainerMarginLeft
    // div.hero-section-image-id - heroSectionMarginLeft
    // Disable the astra scroll top button in mobile screen
    astraScrollTopBtn.style.display = 'none';
    // console.log( 'astraScrollTopBtn :' );
    // console.log( astraScrollTopBtn );
  }

  /** 3. Lazy load the best_selling_products shortcode */
  var lazyBestSellingProductsLoaded = false;
  var bestSellingProductsSection = document.getElementById('best-selling-products-lazy-load-container-id');
  var observerActive = true;
  if (!bestSellingProductsSection) return;
  var bsProductsSectionObserver = new IntersectionObserver(function (entries, observer) {
    // Prevent observer from running when pagination is active
    if (!observerActive) return;
    entries.forEach(function (entry) {
      if (entry.isIntersecting && !lazyBestSellingProductsLoaded) {
        lazyBestSellingProductsLoaded = true;

        // Show a loading indicator
        // bestSellingProductsSection.innerHTML = `<div class="loading-spinner">Loading products ...</div>`;

        // Fetch best selling products data via AJAX
        // return response OK. Contain dedicated data
        fetch(woocommerce_params.ajax_url + "?action=load_lazy_best_selling_products").then(function (response) {
          return response.json();
        }).then(function (responseData) {
          // responseData is OK
          if (responseData.success) {
            // bestSellingProductsSection.innerHTML = responseData.data.html;//OK
            bestSellingProductsSection.innerHTML = "<div class=\"lazy-load-best-selling-products-inner-container\">".concat(responseData.data.html, "</div>");

            // Ensure the fade-in effect is applied after DOM update
            // requestAnimationFrame( () => {
            //     const bestSellingProductsInnerContainer = document.querySelector( 'div.lazy-load-best-selling-products-inner-container' );
            //     bestSellingProductsInnerContainer.classList.add('fade-in');
            // } );                           

            setTimeout(function () {
              var bestSellingProductsRelativeSelector = "div.lazy-load-best-selling-products-inner-container > div.woocommerce > ul.products > li.product";
              var bestSellingProducts = document.querySelectorAll("".concat(bestSellingProductsSectionSelector, " > ").concat(bestSellingProductsRelativeSelector));
              bestSellingProducts.forEach(function (product) {
                return product.classList.add('fade-in');
              });
            }, 50);
          } else {
            bestSellingProductsSection.innerHTML = "<p>Error loading products. There is no data success </p>";
          }
        })["catch"](function (error) {
          bestSellingProductsSection.innerHTML = "<p>Error loading products at Fetch API Catch statement ! ... </p>";
          console.error('Detail error message is :');
          console.error(error);
        });
        observer.unobserve(bestSellingProductsSection);
        observerActive = false;
      }
    });
  }, {
    threshold: 0.5,
    rootMargin: '0px 0px -25% 0px'
  }); //Trigger when 50% of the section reach 50%  of the view port baseline

  // Start observing the bestSellingProductsSection
  bsProductsSectionObserver.observe(bestSellingProductsSection);

  // const bsProductSectionNavigation = bestSellingProductsSection.querySelector('div.lazy-load-best-selling-products-inner-container > nav.woocommerce-pagination > ul.page-numbers');
  // console.log(`astContentContainerMarginLeft : ${astContentContainerMarginLeft}`);
  // console.log(`astContentContainerMarginRight : ${astContentContainerMarginRight}`);
  // console.log(`astContentContainerPaddingLeft : ${astContentContainerPaddingLeft}`);
  // console.log(`astContentContainerPaddingRight : ${astContentContainerPaddingRight}`);
});

/** 2. Ensure all page assets (images, styles, iframes) are fully loaded before execution
 * - This stage is later than document.addEventListener('DOMContentLoaded', function(){ //callback function goes here });
 */

window.addEventListener('load', function () {
  // 1. Genera variables
  // Screen sizes variables - in pixel value
  var outermostContentContainerSelector = "div#content.site-content";
  var astraContentContainerSelector = "".concat(outermostContentContainerSelector, " > div.ast-container");
  var contentAreaContainerSelector = "".concat(astraContentContainerSelector, " > div#primary.content-area");
  var entryContentContainerSelector = "".concat(contentAreaContainerSelector, " > main#main > article.page > div.entry-content");
  var testimonialSectionID = "sp-testimonial-free-wrapper-999";
  if (window.screen.width > _variables.minMdScreenWidth) {
    // 1. Update sp-testimonial height - after all other scripts from testimonial plugins completed
    // Implement a delay again to ensure all DOM are fully loaded and rendered by other scripts
    setTimeout(function () {
      var testimonialSection = document.getElementById(testimonialSectionID);

      // 2. Update sp-testimonial height
      var testimonialItemsWrapper = testimonialSection.querySelector("div.sp-testimonial-free-section");
      var testimonialItemsInnerContainer = testimonialSection.querySelector("div.sp-testimonial-free-section > div.swiper-wrapper"); //OK
      var testimonialItems = testimonialSection.querySelectorAll("div.sp-testimonial-free-section > div.swiper-wrapper > div.sp-testimonial-item");
      var testimonialItemsInnerContainerCssObj = window.getComputedStyle(testimonialItemsInnerContainer); //OK. Got valid computed style in CSS object

      var testimonialItemsInnerContainerHeight = testimonialItemsInnerContainerCssObj.height; // Got the right value here: 440.087px

      testimonialItems.forEach(function (item) {
        return item.style.height = testimonialItemsInnerContainerHeight;
      }); // OK but not fully resize all height    

      // if( window.requestIdleCallback ){
      //     requestIdleCallback( () => { 
      //         console.log('requestIdleCallback existed !');
      //     });
      // }
    }, 100);

    // setTimeout( () => {        }, 100);             
  } //End of window.screen.width > minMdScreenWidth    
});

},{"../../../bases/js/_variables.js":1}]},{},[2]);
