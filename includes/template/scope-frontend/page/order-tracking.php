<?php 
/** Template Name : Order Management 
 *  Template Post Type: page, post
*/

/* Package dutapod-companion */
use Masterminds\HTML5;

get_header();

?>

<h1 class="order-info-page-title">Order Information</h1>
<div class="order-tracking-container">
    
    <!-- 1. Order search form -->
    <h2 class="order-info-search-form-header">Search your Order </h2>
    <p class="order-info-search-instruction">Enter your order ID and email used to make your order request to find your order information detail. </p>
    <div class="order-search-inner-container">        
        <form id="order-search-form-id" class="order-search-form-container" method="POST">
            <label class="wc-order-id-label">Order ID :</label>
            <input class="order-id-input-area" type="text" name="order_id" placeholder="Enter your Order ID" required>
            <label class="wc-order-email-label">Email: </label>
            <input class="order-email-input-area" type="email" name="order_email" placeholder="Enter your Order Email" required>
            <input type="hidden" name="wc_order_search_nonce" value="<?php echo wp_create_nonce('wc_order_search_action'); ?>">
            <button id="order-search-button-id" class="order-search-button" type="submit">Search</button>
        </form>
        <div class="order-search-notes-container">
            <span><b>Note :</b></span>
            <figure class="order-tracking-explanation">1. Please visit your personal email registered when you placed your order. This include the information of your order ID. </figure>
            <figure class="order-tracking-illustration"><i>(For example, you will see email notification title: "New Order #1029", then "1029" is your order ID)</i></figure>
            <figure class="order-tracking-contact-info">2. Should you need any futher assistance or message, please contact us at <a href="mailto:supports@miraclespirit.net">supports@miraclespirit.net</a> . </figure>
        </div><!--.order-search-notes-container-->        
    </div><!--.order-tracking-inner-container-->  

    <!-- 2. Order search result - will be load via AJAX request at WP backend. -->
    <h2 class="order-info-detail-header">Order Details</h2>
    <div class="loading-spinner-result" id="loading-spinner-result-id"></div><!--.loading-spinner-->
    <!-- 2.2. Order search result container - will be fetched the detail order information here. -->
    <div class="order-search-result-container" id="order-search-result-container-id">
    </div><!--.order-search-result-container-->
    

</div><!--.order-management-container-->

<?php  get_footer(); ?>


