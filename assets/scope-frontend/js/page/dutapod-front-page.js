(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

document.addEventListener('DOMContentLoaded', function () {
  // Screen sizes variables - in pixel value
  var minXxlScreenWidth = 1400;
  var maxXlScreenWidth = 1399;
  var minXlScreenWidth = 1200;
  var maxLgScreenWidth = 1199;
  var minLgScreenWidth = 992;
  var maxMdScreenWidth = 991;
  var minMdScreenWidth = 768;
  var maxSmScreenWidth = 767;
  var minSmScreenWidth = 576;
  var maxXsScreenWidth = 575;
  var outermostContentContainerSelector = "div#content.site-content";
  var astraContentContainerSelector = "".concat(outermostContentContainerSelector, " > div.ast-container");
  var contentAreaContainerSelector = "".concat(astraContentContainerSelector, " > div#primary.content-area");
  var heroSectionSelector = "".concat(contentAreaContainerSelector, " > main#main > article.page > div.entry-content > div.hero-section-image-container");
  var testimonialSectionID = "sp-testimonial-free-wrapper-999";
  var heroSectionID = "hero-section-image-id";
  var astraContentContainer = document.querySelector(astraContentContainerSelector);
  var contentAreaContainer = document.querySelector(contentAreaContainerSelector);
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
  if (window.screen.width > minMdScreenWidth) {
    var testimonialSection = document.getElementById(testimonialSectionID);
    var testimonialSectionWidth = testimonialSection.offsetWidth; // get testimonial Section 90vw width in pixel    

    var testimonialSectionScreenMarginLeft = 0.05 * window.screen.width; // 5vw - 5% view port width

    var testimonialSectionMarginLeft = parseFloat(astContentContainerMarginLeft) + parseFloat(astContentContainerPaddingLeft) - parseFloat(testimonialSectionScreenMarginLeft);
    testimonialSectionMarginLeft *= -1;

    // Set negative margin left value 
    // testimonialSection.style.marginLeft = `-${testimonialSectionMarginLeft}px`;
    testimonialSection.style.marginLeft = "".concat(testimonialSectionMarginLeft, "px");
  }
  if (window.screen.width < maxXsScreenWidth) {
    // const heroSection = document.getElementById( heroSectionID );
    var heroSection = document.querySelector(heroSectionSelector); //OK      

    var heroSectionData = window.getComputedStyle(heroSection);
    var originalHeroSectionMarginLeft = heroSectionData.marginLeft; // Expect 24px

    originalHeroSectionMarginLeft = originalHeroSectionMarginLeft.substring(0, originalHeroSectionMarginLeft.length - 2);

    // let updateHeroSectionMarginLeft = parseFloat(astContentContainerPaddingLeft) + parseFloat(originalHeroSectionMarginLeft);
    var updateHeroSectionMarginLeft = parseFloat(astContentContainerPaddingLeft) + parseFloat(astContentContainerMarginLeft);
    updateHeroSectionMarginLeft *= -1;
    heroSection.style.marginLeft = "".concat(updateHeroSectionMarginLeft, "px");

    // astContentContainerMarginLeft
    // div.hero-section-image-id - heroSectionMarginLeft
  }

  // console.log(`astContentContainerMarginLeft : ${astContentContainerMarginLeft}`);
  // console.log(`astContentContainerMarginRight : ${astContentContainerMarginRight}`);
  // console.log(`astContentContainerPaddingLeft : ${astContentContainerPaddingLeft}`);
  // console.log(`astContentContainerPaddingRight : ${astContentContainerPaddingRight}`);
});

},{}]},{},[1]);
