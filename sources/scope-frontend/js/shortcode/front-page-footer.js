const footerContainer = document.querySelector('div#dutapod-footer-container');
const customerSupportColumn = footerContainer.querySelector('div.customer-support-container');

const csColumnComputedStyle = window.getComputedStyle( customerSupportColumn );

const csColumnMarginLeft = csColumnComputedStyle.marginLeft;
const csColumnPaddingLeft = csColumnComputedStyle.paddingLeft;

console.log(`Customer Support Column 's margin left value is : ${csColumnMarginLeft}`);
console.log(`Customer Support Column 's padding left value is : ${csColumnPaddingLeft}`);