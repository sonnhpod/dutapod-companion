document.addEventListener("DOMContentLoaded", function(){
    const wcProductsOuterContainerSelector = 'div.ast-woocommerce-container > ul.products';//OK
    const wcProductsContainerSelector = `${wcProductsOuterContainerSelector} > li`;//OK
    const wcProductImagesContainersSelector = `${wcProductsContainerSelector} > div.astra-shop-thumbnail-wrap > a.woocommerce-loop-product__link`;
    const wcProductImagesSelector = `${wcProductImagesContainersSelector} > img`;
    
    // const wooProductsContainers = document.querySelectorAll( wooProductsContainerSelector );
    // const wooProductsOuterContainer = document.querySelector( wooProductsOuterContainerSelector );
    const wcProductImagesContainers = document.querySelectorAll( wcProductImagesContainersSelector );
    const wcProductImages = document.querySelectorAll( wcProductImagesSelector );
    
});
