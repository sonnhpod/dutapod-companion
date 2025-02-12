(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

document.addEventListener("DOMContentLoaded", function () {
  var wcProductsOuterContainerSelector = 'div.ast-woocommerce-container > ul.products'; //OK
  var wcProductsContainerSelector = "".concat(wcProductsOuterContainerSelector, " > li"); //OK
  var wcProductImagesContainersSelector = "".concat(wcProductsContainerSelector, " > div.astra-shop-thumbnail-wrap > a.woocommerce-loop-product__link");
  var wcProductImagesSelector = "".concat(wcProductImagesContainersSelector, " > img");

  // const wooProductsContainers = document.querySelectorAll( wooProductsContainerSelector );
  // const wooProductsOuterContainer = document.querySelector( wooProductsOuterContainerSelector );
  var wcProductImagesContainers = document.querySelectorAll(wcProductImagesContainersSelector);
  var wcProductImages = document.querySelectorAll(wcProductImagesSelector);
});

},{}]},{},[1]);
