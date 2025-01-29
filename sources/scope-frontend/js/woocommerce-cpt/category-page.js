document.addEventListener("DOMContentLoaded", function(){
    const wooProductsOuterContainerSelector = 'div.ast-woocommerce-container > ul.products';
    const wooProductsContainerSelector = `${wooProductsOuterContainerSelector} > li`;
    const productImagesSelector = `${wooProductsContainerSelector} > a.woocommerce-loop-product__link > img`;
    
    const wooProductImages = document.querySelectorAll( productImagesSelector );
    console.log( wooProductImages );
});