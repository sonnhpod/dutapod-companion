<?php 
/* Template Name : Order Management */

use Masterminds\HTML5;

get_header();

?>

<div class="order-tracking-container">
    <h1 class="order-info-page-title">Order Information</h1>
    <h3 class="order-info-search-form-header">Search your Order </h3>
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

    <h3 class="order-info-detail-header">Order Details</h3>
    <div class="loading-spinner-result" id="loading-spinner-result-id"></div><!--.loading-spinner-->
    <div class="order-search-result-container" id="order-search-result-container-id">
        <?php 

        //var_dump( esc_url( home_url('/index.php/order-tracking/') ) );
        var_dump( $_POST['order_id'] );
        var_dump( $_POST['order_email'] );        
        
        // This condition is never valid because no $POST parameter were set
        if( isset( $_POST['order_id'] ) && isset( $_POST['order_email'] ) ):
            $orderId = sanitize_text_field( $_POST['order_id'] );
            $orderEmail = sanitize_text_field( $_POST['order_email'] );            

            $order = wc_get_order( $orderId );            
            
            //
            if($order):
                /* $htmlOrders = '<ul class="order-items-list">';

                foreach( $order->get_items() as $item ):
                    $htmlOrders .= sprintf( '<li>%s x %s </li>', esc_html( $item->get_name() ), esc_html( $item->get_quantity() ) );
                endforeach;

                $htmlOrders .= '</ul>'; */

                $htmlOrders = '<table class="product-list-table">'; // Start of product list table

                $htmlOrders .= '<tr class="header-row">';// Start of header row
                $htmlOrders .= '<th>NO</th>';
                $htmlOrders .= '<th>Product Name</th>';
                $htmlOrders .= '<th>Quantity</th>';
                $htmlOrders .= '</tr>'; // End of header row

                $orderProducts = $order->get_items();                

                $productCount = 0;
                foreach( $orderProducts as $key => $item ):
                    $productCount++;

                    $htmlOrders .= '<tr class="data-row">';// Start of data row
                    $htmlOrders .= sprintf('<td>%s</td>', $productCount);
                    $htmlOrders .= sprintf('<td>%s</td>', esc_html( $item->get_name() ) );
                    $htmlOrders .= sprintf('<td>%s</td>', esc_html( $item->get_quantity() ) );
                    $htmlOrders .= '</tr><!--.data-row-->'; // End of data row
                endforeach;

                $htmlOrders .= '</table><!--.product-list-table-->';// End of product list table

                // var_dump( $orderProducts );// For debugging

                $orderID = esc_html( $order->get_id() );
                $orderStatus = esc_html(wc_get_order_status_name( $order->get_status() ) );
                $orderPrice = wc_price( $order->get_total() );

                ?>
                                  
                <div class="order-information-container">
                    <div class="order-id">
                        <label>Order ID :</label><span><?php echo $orderID ?></span>                            
                    </div>
                    <div class="order-status">
                        <label>Status :</label><span><?php echo $orderStatus ?></span>     
                    </div>
                    <div class="order-total-price">
                        <label>Total price :</label><span><?php echo $orderPrice ?></span>                            
                    </div>
                </div><!--.order-information-container-->                   
                
                <?php
                $htmlOutput = <<<HTML
                    <br>    
                    <h3 style="font-weight:bold;">Order Items</h3>
                    {$htmlOrders}
                HTML;
                
            else:
                $htmlOutput = <<<HTML
                    <p style="color:red;">Order not found. Please check the Order ID.</p>
                HTML;
            endif;

            echo $htmlOutput;
        endif;

        ?>
    </div><!--.order-search-result-container-->
    

</div><!--.order-management-container-->

<?php  get_footer(); ?>


