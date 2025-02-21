<?php 
/* Template Name : Order Management */

get_header();

?>

<div class="order-tracking-container">
    <h1 class="order-info-page-title">Order Information</h1>
    <h3 class="order-info-search-form-header">Search your Order </h3>
    <div class="order-search-inner-container">        
        <form id="order-search-form-id" class="order-search-form" method="GET">
            <label class="wc-order-id-label">Order ID :</label>
            <input class="order-id-input-area" type="text" name="order_id" placeholder="Enter your Order ID" required>
            <button class="order-id-search-button" type="submit">Search</button>
        </form>
        <figure class="order-tracking-explanation">Please visit your personal email registered when you placed your order. This include the information of your order ID</figure>
        <figure class="order-tracking-illustration">(For example, you will see email notification title: <b>"New Order #1029"</b>, then "1029" is your order ID)</figure>
    </div><!--.order-tracking-inner-container-->  

    <h3 class="order-info-detail-header">Order Details</h3>
    <div class="loading-spinner-result" id="loading-spinner-result-id"></div><!--.loading-spinner-->
    <div class="order-tracking-result-container" id="order-search-result-container-id">
        <?php 
        
        if( isset( $_GET['order_id'] ) ):
            $order_id = sanitize_text_field( $_GET['order_id'] );
            $order = wc_get_order( $order_id );

            // var_dump( $order );
            
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

                $htmlOutput = <<<HTML
                    
                    <p><strong>Order ID :</strong> $orderID </p>
                    <p><strong>Status :</strong> $orderStatus </p>
                    <p><strong>Total :</strong> $orderPrice </p>
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
    </div><!--.order-tracking-result-container-->
    

</div><!--.order-management-container-->

<?php  get_footer(); ?>


