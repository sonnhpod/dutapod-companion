document.addEventListener('DOMContentLoaded', function(){
    const productDesToggleBtn = document.getElementById( 'custom-product-description-toggle' );
    const productDesContentContainer =  document.getElementById( 'custom-description-content' );

    productDesToggleBtn.addEventListener( 'click', function(e){
        e.preventDefault();
        if( productDesContentContainer.classList.contains('open') ){
            // Close the accordion description
            // productDesContentContainer.style.maxHeight = null;      
            productDesContentContainer.style.maxHeight = '0';                
        } else{
            // Open the accordion description
            // let height = getFullHeightDOMElement( productDesContentContainer );
            let productDesContentContainerHeight = parseFloat(productDesContentContainer.scrollHeight) + 30;// Add 20 pixel more
            // productDesContentContainer.style.height = `${height}px`;
            productDesContentContainer.style.maxHeight = `${productDesContentContainerHeight}px`;    
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
    let fullHeight = element.scrollHeight;

    // Revert styles back
    element.style.removeProperty("visibility");
    element.style.removeProperty("position");
    element.style.display = "none";

    return fullHeight;
}


