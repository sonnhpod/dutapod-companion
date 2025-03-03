<?php 
/**
 * @package dutapod-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Controller\ScopeFrontend\Page;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

use DutapodCompanion\Includes\Controller\ScopeFrontend\PageTemplate\OrderTrackingPageTemplate as OrderTrackingPageTemplate;

class OrderTrackingPage{
    /** 1. Variables & constant for post properties */
    /** 1.1.2. Front page information : */
    const ORDER_TRACKING_PAGE_STYLE_FILENAME = 'order-tracking-page.css';
    const ORDER_TRACKING_PAGE_STYLE_HANDLER = 'order-tracking-page-style';
    const ORDER_TRACKING_PAGE_SCRIPT_FILENAME = 'order-tracking-page.js';
    const ORDER_TRACKING_PAGE_SCRIPT_HANDLER = 'order-tracking-page-script';

    const URL_MATCHING_PATTERN = '#^(/index\.php)?/order-tracking/?#';

    /** Extra styles & scripts for the front page */
    public static $ORDER_TRACKING_PAGE_STYLE_PATH;
    public static $ORDER_TRACKING_PAGE_SCRIPT_PATH;

    /** 2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    public function __construct(){
        /** 1. Troubleshooting information */
        // 1. Load the plugin initiator
        $this->pluginInitiator = Init::$INSTANCE ?? new Init();
        
        // 2. Setup local properties
        $this->set_Local_Properties();

        // 3. Setup local debuggger
        $this->set_Local_Debugger();

        /** 2. Setup local properties */
        $this->setPageResourcesInfo();

        /** 3. Run the main functions */     
        // 3.2. Load extra resource for specific pages: 
        $this->load_Extra_Resources_Order_Tracking_Page();
    }//__construct

    /** 2.2. Helper methods for constructors */
    /** 2.2.1. Initialize the variable that point to general plugin properties */ 
    public function set_Local_Properties():void{
        $this->localProps =  $this->pluginInitiator::$PLUGIN_PROPERTIES;
    }//setLocalProperties

    /** 2.2.2. setup the custom debugger for plugin */ 
    public function set_Local_Debugger():void{
        $this->localDebugger = $this->pluginInitiator::$PLUGIN_DEBUGGER;
    }//setLocalDebugger

    public function setPageResourcesInfo(){
        /** 1. Set the resources information for WordPress front page */
        self::$ORDER_TRACKING_PAGE_STYLE_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::CSS_ROOT_DIR.'page/', 
            self::ORDER_TRACKING_PAGE_STYLE_FILENAME
        );

        self::$ORDER_TRACKING_PAGE_SCRIPT_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::JS_ROOT_DIR.'page/', 
            self::ORDER_TRACKING_PAGE_SCRIPT_FILENAME
        );

    }//setPageResourcesInfo

    /** 3.2. Helper functions */
    /** 3.2.1. Enqueue extra resources for Front Page */
    public function load_Extra_Resources_Order_Tracking_Page(){       
       
        add_action('wp_enqueue_scripts', function(){            
            // const URL_MATCHING_PATTERN = '#^(/index\.php)?/order-tracking/?#';
            if( preg_match( self::URL_MATCHING_PATTERN, $_SERVER['REQUEST_URI'] ) && !is_admin() ){
                $this->enqueue_Extra_Resources_To_Order_Tracking_Page();
            }
           
        }, 1000);       

    }//load_Extra_Resources_If_Front_Page

    public function register_Extra_Resources_To_Order_Tracking_Page(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$ORDER_TRACKING_PAGE_STYLE_PATH ) ? filemtime( self::$ORDER_TRACKING_PAGE_STYLE_PATH ) : false;
        wp_register_style( self::ORDER_TRACKING_PAGE_STYLE_HANDLER, self::$ORDER_TRACKING_PAGE_STYLE_PATH, [], $css_version, 'all' );

        /** 2.2. Enqueue the custom scripts */
        $js_version = file_exists( self::$ORDER_TRACKING_PAGE_SCRIPT_PATH ) ? filemtime( self::$ORDER_TRACKING_PAGE_SCRIPT_PATH ) : false;
        wp_register_script( self::ORDER_TRACKING_PAGE_SCRIPT_HANDLER, self::$ORDER_TRACKING_PAGE_SCRIPT_PATH, [], $js_version, true );

    }//enqueue_Extra_Resources_To_Front_Page

    public function enqueue_Extra_Resources_To_Order_Tracking_Page(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$ORDER_TRACKING_PAGE_STYLE_PATH ) ? filemtime( self::$ORDER_TRACKING_PAGE_STYLE_PATH ) : false;
        wp_enqueue_style( self::ORDER_TRACKING_PAGE_STYLE_HANDLER, self::$ORDER_TRACKING_PAGE_STYLE_PATH, [], $css_version, 'all' );

        /** 2.2. Enqueue the custom scripts */
        $js_version = file_exists( self::$ORDER_TRACKING_PAGE_SCRIPT_PATH ) ? filemtime( self::$ORDER_TRACKING_PAGE_SCRIPT_PATH ) : false;
        wp_enqueue_script( self::ORDER_TRACKING_PAGE_SCRIPT_HANDLER, self::$ORDER_TRACKING_PAGE_SCRIPT_PATH, [], $js_version, true );

        /**  2.2.2. Localize this additional front page script */
        // Add the AJAX URL information to the frontend script
        wp_localize_script( self::ORDER_TRACKING_PAGE_SCRIPT_HANDLER, 'woocommerce_params', [ 'ajax_url' => admin_url('admin-ajax.php') ] );
    }//enqueue_Extra_Resources_To_Front_Page

    /* 4. Main operational function */
    /** Main operational functions -  */
    public function register(){
        // 1. Insert the custom template DUTAPOD order tracking template here
        // --> Initialize in the DutapodCompanion\Includes\Controller\ScopeFrontend\PagesController class
        // $orderTrackingPageTemplate = new OrderTrackingPageTemplate();
        // $orderTrackingPageTemplate->register();

        // 2. Callback function to handle AJAX wc_order_search
        add_action( 'wp_ajax_wc_order_search_info', [ $this, 'handle_WC_Order_Search_Info' ] );
        add_action( 'wp_ajax_nopriv_wc_order_search_info', [ $this, 'handle_WC_Order_Search_Info' ] );
    }//register

    /** Other main operational functions */
    /** 4.1. AJAX handler for the order search feature - at order tracking page */
    public function handle_WC_Order_Search_Info(){
        
        // 1. Validate the oprations
        // 1.1. Verify nonce for security     
        if( !isset( $_POST['wc_order_search_nonce'] ) || !wp_verify_nonce( $_POST['wc_order_search_nonce'] , 'wc_order_search_action') ){
            wp_send_json_error(['html' => 'Security check failed. The process of verify nonce failed!']);
        }

        // 1.2. Sanitize user inputs
        $orderID = isset( $_POST['order_id'] ) ? sanitize_text_field( $_POST['order_id'] ) : '';
        $customerEmail = isset( $_POST['order_email'] ) ? sanitize_text_field( $_POST['order_email'] ) : '';

        // 1.3. Guarding the operation - validate the input
        if ( empty( $orderID ) || empty( $customerEmail ) ) {
            wp_send_json_error(['html' => 'Order ID and Email are required.']);
        }

        // 1.4. Load WooCommerce
        if ( !class_exists( 'WooCommerce' ) ) {
            wp_send_json_error(['html' => 'WooCommerce is not installed.']);
        }

        // 2. Start processing order information 
        // Get order by order ID: WC-Order :
        /** Class WC_Order documentation: https://woocommerce.github.io/code-reference/classes/WC-Order.html */
        $order = wc_get_order( $orderID );

        // Guarding the operation if $order is invalid or not exist
        if ( !$order ) {
            $htmlErrorMessage = '<p style="color:red;">Order not found. Please check the Order ID & customer email.</p>';

            wp_send_json_error( [ 'html' => $htmlErrorMessage ] );
        }

        // Check if email matches the order
        if ( $order->get_billing_email() !== $customerEmail ) {
            $htmlErrorMessage = '<p style="color:red;">Email does not match the order.</p>';

            wp_send_json_error( [ 'html' => $htmlErrorMessage ] );
        }

        // Proceed order information:
        
        // 3. Render HTML output
        // 3.1. Order information summary 
        
        $shippingMethod = $order->get_shipping_method();
        // $shippingMethod = '';
        // $paymentMethod = $order->get_payment_method();
        $paymentMethodTitle = $order->get_payment_method_title();
        $customerNote = $order->get_customer_note();
        // $shippingOption = 

        $htmlOutput = <<<HTML
        <div class="order-information-container">
            <h3 class="order-info-summary-header">1. Order Information Summary</h3>
            <table class="order-info-summary-table">
                <tr class="header-row">
                    <th class="header-no">Property</th>
                    <th class="header-no">Detail information</th>
                </tr><!--.header-row-->
                <tr class="data-row order-id">
                    <td>Order ID:</td>
                    <td>{$orderID}</td>
                </tr>
                <tr class="data-row shipping">
                    <td>Shipping:</td>
                    <td>{$shippingMethod}</td>
                </tr>
                <tr class="data-row payment-method">
                    <td>Payment Method:</td>
                    <td>{$paymentMethodTitle}</td>
                </tr>                
                <tr class="data-row notes">
                    <td>Notes:</td>
                    <td>{$customerNote}</td>
                </tr>
            </table><!--.product-list-table-->  
        </div><!--.order-information-container-->                   
        HTML;

        // 3.2. Render the progress bar for order information
        $orderStatus = esc_html( wc_get_order_status_name( $order->get_status() ) );       
        $orderStatusLowercaseName = strtolower( $orderStatus );
        // Replace all whitespace with minus letter
        $orderStatusLowercaseName = str_replace( ' ', '-', $orderStatusLowercaseName );
        
        // $this->localDebugger->write_log_general( $orderStatus );
        

        $htmlOrderProgress = <<<HTML
        <div class="order-progress-container">
            <h3 class="order-status-label">2. Order status :</h3>
            <span class="order-status-detail {$orderStatusLowercaseName}-status">{$orderStatusLowercaseName}</span>
        </div><!--.order-progress-->
        HTML;

        // Append the order progress to HTML output
        $htmlOutput .= <<<HTML
            <br>    
            {$htmlOrderProgress}
            <br>
        HTML;

        // 3.3. Detail product items list in the order
        $htmlOrders = '<table class="product-list-table">'; // Start of product list table

        // a. header row
        $htmlOrders .= <<<HTML
            <tr class="header-row">
                <th class="header-no">NO</th>
                <th class="header-product-name">Product Name</th>
                <th class="header-quantity">Quantity</th>
                <th class="header-quantity">Unit Price</th>
                <th class="header-total-price">Total price</th>
            </tr><!--.header-row-->
        HTML;

        // b. header note row
        $htmlOrders .= <<<HTML
            <tr class="header-notes-row">
                <th class="header-no"><small>Note</small></th>
                <th class="header-product-name"><small>Single product item name & its embedded product link. Click to visit each single product.</small></th>
                <th class="header-quantity"><small>the amount of products purchased</small></th>
                <th class="header-quantity"><small>Price per single product</small></th>
                <th class="header-total-price"><small>Unit price * quantity</small></th>
            </tr><!--.header-notes-row-->
        HTML;        
        
        /** Class WC_Order_Item documentation: https://woocommerce.github.io/code-reference/classes/WC-Order-Item.html  */
        $orderItems = $order->get_items();// Obtain an array of WC_Order_Item

        $productCount = 0;

        // Render the product detail data
        foreach( $orderItems as $orderItemID => $orderItem ):
            /** $orderItem class documentation: https://woocommerce.github.io/code-reference/classes/WC-Order-Item.html 
             * Need to work with 2 WC product object:
             * - Order item - class WC_Order_Item (currently using method of WC_Order_Item_Product still work ?)
             * - WooCommerce product - class WC_Product
             * */    
             
            $productCount++;
            // Still working even though VS error notification here. It seems because of the WooCommerce product extensions
            // @php-ignore  
             
            $orderItemData = $orderItem->get_data();//OK. Contain helpful information about product item

            $productID = isset( $orderItemData['product_id'] ) ? $orderItemData['product_id'] : false;
            if( ! $productID ) { continue; }

            // 2. Get WC_Product object by ID 
            /** class WC_Product documentation: https://woocommerce.github.io/code-reference/classes/WC-Product.html */   
            $product = wc_get_product( $productID  );

            if( is_null( $product) || ! $product ) { continue; }

            // $product = $orderItem->get_product();
            // $productID = $product->get_id();
            $productPrice = $product->get_price();
            $productUrl = get_permalink( $productID );          
            
            // $orderItemName = esc_html( $orderItem->get_name() );
            $orderItemName = isset( $orderItemData['name'] ) ? $orderItemData['name'] : 'unknown order product item';
            // $orderItemQuantity = esc_html( $orderItem->get_quantity() );
            $orderItemQuantity = isset( $orderItemData['quantity'] ) ? $orderItemData['quantity'] : 0;
            $orderItemTotalPrice = isset( $orderItemData['total'] ) ? $orderItemData['total'] : 0;
       
            // $this->localDebugger->write_log_general('-->  $orderITemData : ');
            // $this->localDebugger->write_log_general( $orderItemData );            

            // 3. Append HTML content of order product item 
            $htmlOrders .= <<<HTML
            <tr class="data-row">
                <td class="data-value product-count">{$productCount}</td>
                <td class="data-value product-name"><a href="{$productUrl}" rel="noopener noreferrer">{$orderItemName}</a></td>
                <td class="data-value product-quantity">{$orderItemQuantity}</td>
                <td class="data-value product-price">{$productPrice} $</td>
                <td class="data-value product-total-price">{$orderItemTotalPrice} $</td>
            </tr><!--.data-row-->
            HTML;
        endforeach;

        // render order information summary
        $orderPrice = wc_price( $order->get_total() );

        $htmlOrders .= '<tr class="data-row">';// Start of data row
        $htmlOrders .= sprintf( '<td style="text-align:left;font-weight:bold;" colspan="4">Total order\'s price : </td>' );
        $htmlOrders .= sprintf( '<td style="text-align:center;" colspan="1">%s</td>', $orderPrice );
        $htmlOrders .= '</tr><!--.data-row-->'; // End of data row

        // Closing the product items list table
        $htmlOrders .= '</table><!--.product-list-table-->';// End of product list table

        //$orderID = esc_html( $order->get_id() );
        //$orderStatus = esc_html(wc_get_order_status_name( $order->get_status() ) );       

        // 3.3. Start rendering the HTML output for the wc_order_search_info action.      
        $htmlOutput .= <<<HTML
            <br>           
            <h3 style="font-weight:bold;">3. Order's products item detail</h3>
            {$htmlOrders}
        HTML;

        // 4. Send HTML data to frontend display in responseData.data.html 
        wp_send_json_success( [ 'html' => $htmlOutput ] );

        // Final - terminate AJAX requests
        die();
    }//handle_WC_Order_Search_Info

}//OrderTrackingPage