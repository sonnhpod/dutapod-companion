/** Package dutapod-companion */
import * as _variables from '../../../bases/js/_variables.js';

window.addEventListener('load', function(){
    const orderSearchForm = document.getElementById('order-search-form-id');
    orderSearchForm.addEventListener('submit', function(e){
        e.preventDefault();

        let spinner = document.getElementById('loading-spinner-result-id');
        let orderResults = document.getElementById('order-search-result-container-id');

        spinner.style.display = "block"; // Show spinner
        orderResults.style.display = "none"; // Hide results

        setTimeout(() => {
            spinner.style.display = "none"; // Hide spinner after loading
            orderResults.style.display = "block"; // Show order details
        }, 2000); // Simulating API delay
    });

});