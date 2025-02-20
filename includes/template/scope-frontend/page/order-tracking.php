<?php 
/* Template Name : Order Management */

get_header();

?>

<div class="order-tracking-container">
    <h3>Search your Order </h3>
    <label class="wc-order-id-label">Order ID :</label>
    <form method="GET">
        <input class="order-id-input-area" type="text" name="order_id" placeholder="Enter your Order ID" required>
        <button class="order-id-search-button" type="submit">Search</button>
    </form>

    <?php 
    
    if( isset( $_GET['order_id'] ) ):
        $order_id = sanitize_text_field( $_GET['order_id'] );
        $order = wc_get_order( $order_id );
        
        if($order):
            $htmlOrders = '<ul class="order-items-list">';

            foreach( $order->get_items() as $item ):
                $htmlOrders .= sprintf( '<li>%s x %s </li>', esc_html( $item->get_name() ), esc_html( $item->get_quantity() ) );
            endforeach;

            $htmlOrders .= '</ul>';

            $htmlOutput = <<<HTML
                <h3>Order Details</h3>
                <p><strong>Order ID:</strong> {{ esc_html($order->get_id()) }} </p>
                <p><strong>Status:</strong> { esc_html(wc_get_order_status_name($order->get_status())) } </p>
                <p><strong>Total:</strong> { wc_price($order->get_total()) } </p>

                <h4>Order Items</h4>
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

</div><!--.order-management-container-->

<?php  get_footer(); ?>


