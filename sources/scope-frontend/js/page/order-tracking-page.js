/** Package dutapod-companion */
import * as _variables from '../../../bases/js/_variables.js';
// import { forceRedraw } from '../../../bases/js/_variables.js';

window.addEventListener('load', function(){
    const orderSearchForm = document.getElementById('order-search-form-id');
    const orderSearchButton = orderSearchForm.querySelector('button.order-search-button');

    const orderSearchResultContainer = this.document.getElementById('order-search-result-container-id');

    // 1. Handle the submit action in the Search Form
    /* orderSearchForm.addEventListener('submit', function(e){
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
    }); */

    orderSearchForm.addEventListener('submit', function(e){
        e.preventDefault();

        // Empty the orderSearchResultContainer before fetching new data:
        orderSearchResultContainer.innerHTML = '';
        if( orderSearchResultContainer.classList.contains('show') ){
            orderSearchResultContainer.classList.remove('show');
        }

        _variables.forceRedraw( orderSearchResultContainer );

        let formData = new FormData(this);

        const requestUrl = woocommerce_params.ajax_url + "?action=wc_order_search_info";

        let updateOrderSearchResultDelay = _variables.redrawDelay + 20;//OK

        // Fetch the order search result container with the 
        setTimeout( () => {
            fetch( requestUrl, { method: 'POST', body: formData } )
            .then( response => response.json() )
            .then( responseData => {
                // console.log('responseData is : ');
                // console.log( responseData );
                
                if( responseData.success ){
                    // Obtain the HTML response
                    let htmlResponse = responseData.data.html;
                    orderSearchResultContainer.innerHTML = htmlResponse;

                    // Apply animation effect for the search result
                    const spinner = document.getElementById( 'loading-spinner-result-id' );
                    spinner.style.display = "block"; // Show spinner

                    setTimeout(() => {
                        spinner.style.display = "none"; // Hide spinner after loading
            
                        // orderResultsContainer.style.display = "block"; // Show order details
                        if( ! orderSearchResultContainer.classList.contains('show') ){
                            orderSearchResultContainer.classList.add('show');
                        }
            
                    }, 1200); // Simulating API delay
                }
                else {
                    orderSearchResultContainer.innerHTML = `<p>Error loading products. There is no data even though the fetch API got success status. </p>`;
                }
            })
            .catch( error => {
                orderSearchResultContainer.innerHTML = `<p>Error loading products at Fetch API Catch statement ! ... </p>`;
                console.error('Detail error message is :');
                console.error( error );
            });
        }, updateOrderSearchResultDelay );

       
    });

});

window.addEvent