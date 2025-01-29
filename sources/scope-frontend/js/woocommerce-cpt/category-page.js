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

/**
 *     wcProductImages.forEach( (image) => {
        const scaleRatio = 1.5;

        image.addEventListener('mouseenter', function(){
            // this.style.transition = "transform 0.2s ease-out"; 
            this.style.transform = `scale(${scaleRatio})`;
        });

        image.addEventListener('mousemove', function(e){
            // Get the DOMRect object of the current element
            let rect = this.getBoundingClientRect();
            let offsetX = e.clientX - rect.left;
            let offsetY = e.clientY - rect.top;
            let offsetXRatio = offsetX / rect.width;// x ratio of the mouse pointer
            let offsetYRatio = offsetY / rect.height;// y ratio of the mouse pointer
            let centerX = rect.width / 2;
            let centerY = rect.height / 2;

            let scaleOffsetX = offsetX * scaleRatio;
            let scaleOffsetY = offsetY * scaleRatio;
            let scaleCenterX = rect.width * scaleRatio / 2;
            let scaleCenterY = rect.height * scaleRatio / 2;
            console.log(`offsetX : ${offsetX} ; offsetY : ${offsetY}`);        

            // let moveX = ( offsetXRatio - 0.5 ) * 20; // Adjust zoom direction
            // let moveY = ( offsetYRatio - 0.5 ) * 20;   
            // let moveX = ( offsetXRatio - 0.5 ) * rect.width; // reverse order
            // let moveY = ( offsetYRatio - 0.5 ) * rect.height;
            // Move basing on the percentage
            let moveX = ( offsetXRatio - 0.5 ) * 100;
            let moveY = ( offsetYRatio - 0.5 ) * 100;
            // const moveX = (offsetX - centerX) * 0.3; // Adjusts movement sensitivity
            // const moveY = (offsetY - centerY) * 0.3;

            // Transform the image
            this.style.transform = `scale(${scaleRatio}) translate(${moveX}px, ${moveY}px)`;
            //this.style.transform = `scale(1.5) translate(${moveX}px, ${moveY}px)`;// valid syntax
            //this.style.transform = `scale(1.5) translate(${moveX}%, ${moveY}%)`;
        });

        image.addEventListener('mouseleave', function(){
            this.style.transform = "scale(1) translate(0, 0)";
        });
    });
 * 
*/