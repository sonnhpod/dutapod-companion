(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

/** Package dutapod-companion WordPresss plugin  */
// console.log('Hello world from the settings-management-subpage.js !');

jQuery(document).ready(function (_$) {
  var mediaUploader;

  /** 1. Add click event listener for upload button */
  $('#upload-logo-button-id').click(function (e) {
    e.preventDefault();

    // 1.1. If the media uploader has already existed, open it
    if (mediaUploader) {
      mediaUploader.open();
      return;
    }

    // 1.2. If the media uploader has not been existed, create a new one
    mediaUploader = wp.media({
      title: 'Choose Logo Image',
      button: {
        text: 'Use this logo'
      },
      multiple: false
    });

    // When an image is selected, set the input field 
    mediaUploader.on('select', function () {
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      $('#plugin-company-logo-id').val(attachment.url);
      $('#plugin-company-logo-preview-id').attr('src', attachment.url).show();
      $('#remove-logo-button-id').show();
    });

    // Open the uploader dialog
    mediaUploader.open();
  });

  /** 2. Add click event listener for remove button */
  $('#remove-logo-button-id').click(function () {
    $('#plugin-company-logo-id').val('');
    $('#plugin-company-logo-preview-id').hide();
    $(this).hide();
  });
});

},{}]},{},[1]);
