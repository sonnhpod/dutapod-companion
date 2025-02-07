(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

document.addEventListener('DOMContentLoaded', function () {
  var outermostContentContainerSelector = "div#content.site-content";
  var astraContentContainerSelector = "".concat(outermostContentContainerSelector, " > div.ast-container");
  var astraContentContainer = document.querySelector(astraContentContainerSelector);
  var astraContentContainerStyleData = window.getComputedStyle(astraContentContainer);
  var astContentContainerMarginLeft = astraContentContainerStyleData.getPropertyValue('margin-left');
  var astContentContainerMarginRight = astraContentContainerStyleData.getPropertyValue('margin-right');
  var astContentContainerPaddingLeft = astraContentContainerStyleData.getPropertyValue('padding-left');
  var astContentContainerPaddingRight = astraContentContainerStyleData.getPropertyValue('padding-right');
  console.log("astContentContainerMarginLeft : ".concat(astContentContainerMarginLeft));
  console.log("astContentContainerMarginRight : ".concat(astContentContainerMarginRight));
  console.log("astContentContainerPaddingLeft : ".concat(astContentContainerPaddingLeft));
  console.log("astContentContainerPaddingRight : ".concat(astContentContainerPaddingRight));
});

},{}]},{},[1]);
