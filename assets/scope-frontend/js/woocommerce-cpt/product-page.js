(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

document.addEventListener('DOMContentLoaded', function () {
  var productDesToggleBtn = document.getElementById('custom-product-description-toggle');
  var productDesContentContainer = document.getElementById('custom-description-content');
  productDesToggleBtn.addEventListener('click', function (e) {
    e.preventDefault();
    if (productDesContentContainer.classList.contains('open')) {
      // Close the accordion description
      // productDesContentContainer.style.maxHeight = null;      
      productDesContentContainer.style.maxHeight = '0';
    } else {
      // Open the accordion description
      // let height = getFullHeightDOMElement( productDesContentContainer );
      var productDesContentContainerHeight = parseFloat(productDesContentContainer.scrollHeight) + 30; // Add 20 pixel more
      // productDesContentContainer.style.height = `${height}px`;
      productDesContentContainer.style.maxHeight = "".concat(productDesContentContainerHeight, "px");
      // productDesContentContainer.style.maxHeight = '100%';
      // productDesContentContainer.style.height = '100%';  
    }
    productDesContentContainer.classList.toggle('open');
    productDesToggleBtn.classList.toggle('open');
  });
});
function getFullHeightDOMElement(element) {
  // Temporarily make the element visible if it's hidden
  element.style.visibility = "hidden";
  element.style.position = "absolute";
  element.style.display = "block";

  // Get the full height
  var fullHeight = element.scrollHeight;

  // Revert styles back
  element.style.removeProperty("visibility");
  element.style.removeProperty("position");
  element.style.display = "none";
  return fullHeight;
}

},{}]},{},[1]);
