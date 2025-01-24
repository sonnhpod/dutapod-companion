document.addEventListener('DOMContentLoaded', function(){
    const productDesToggleBtn = document.getElementById( 'custom-product-description-toggle' );
    const productDesContentContainer =  document.getElementById( 'custom-description-content' );

    productDesToggleBtn.addEventListener( 'click', function(e){
        e.preventDefault();
        if( productDesContentContainer.classList.contains('open') ){
            // Close the accordion description
            productDesContentContainer.style.maxHeight = null;                   
        } else{
            // Open the accordion description
            productDesContentContainer.style.maxHeight = `${productDesContentContainer.scrollHeight}px`;      
        }

        productDesContentContainer.classList.toggle('open');        
        productDesToggleBtn.classList.toggle('open');
    });
});