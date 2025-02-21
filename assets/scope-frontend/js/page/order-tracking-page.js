(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.minXxlScreenWidth = exports.minXlScreenWidth = exports.minSmScreenWidth = exports.minMdScreenWidth = exports.minLgScreenWidth = exports.maxXsScreenWidth = exports.maxXlScreenWidth = exports.maxSmScreenWidth = exports.maxMdScreenWidth = exports.maxLgScreenWidth = void 0;
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

},{}],2:[function(require,module,exports){
"use strict";

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
var _variables = _interopRequireWildcard(require("../../../bases/js/_variables.js"));
function _getRequireWildcardCache(e) { if ("function" != typeof WeakMap) return null; var r = new WeakMap(), t = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(e) { return e ? t : r; })(e); }
function _interopRequireWildcard(e, r) { if (!r && e && e.__esModule) return e; if (null === e || "object" != _typeof(e) && "function" != typeof e) return { "default": e }; var t = _getRequireWildcardCache(r); if (t && t.has(e)) return t.get(e); var n = { __proto__: null }, a = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var u in e) if ("default" !== u && {}.hasOwnProperty.call(e, u)) { var i = a ? Object.getOwnPropertyDescriptor(e, u) : null; i && (i.get || i.set) ? Object.defineProperty(n, u, i) : n[u] = e[u]; } return n["default"] = e, t && t.set(e, n), n; }
/** Package dutapod-companion */

window.addEventListener('load', function () {
  var orderSearchForm = document.getElementById('order-search-form-id');
  orderSearchForm.addEventListener('submit', function (e) {
    e.preventDefault();
    var spinner = document.getElementById('loading-spinner-result-id');
    var orderResults = document.getElementById('order-search-result-container-id');
    spinner.style.display = "block"; // Show spinner
    orderResults.style.display = "none"; // Hide results

    setTimeout(function () {
      spinner.style.display = "none"; // Hide spinner after loading
      orderResults.style.display = "block"; // Show order details
    }, 2000); // Simulating API delay
  });
});

},{"../../../bases/js/_variables.js":1}]},{},[2]);
