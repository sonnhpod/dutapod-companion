/** Package dutapod-companion */
import * as _variables from '../../../bases/js/_variables.js';

window.addEventListener('load', function(){
    const orderSearchForm = document.getElementById('order-search-form-id');
    orderSearchForm.addEventListener('submit', function(e){
        e.preventDefault();

        const spinner = document.getElementById('loading-spinner-result-id');
        const orderResultsContainer = document.getElementById('order-search-result-container-id');

        spinner.style.display = "block"; // Show spinner
        // orderResultsContainer.style.display = "none"; // Hide results

        setTimeout(() => {
            spinner.style.display = "none"; // Hide spinner after loading

            // orderResultsContainer.style.display = "block"; // Show order details
            if( ! orderResultsContainer.classList.contains('show') ){
                orderResultsContainer.classList.add('show');
            }

        }, 1200); // Simulating API delay
    });

});