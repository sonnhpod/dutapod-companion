<?php 
/**
 * @package dutapod-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Controller\ScopeFrontend\Page;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

use DutapodCompanion\Includes\Controller\ScopeFrontend\Page\OrderTrackingPageTemplate as OrderTrackingPageTemplate;

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
        $orderTrackingPageTemplate = new OrderTrackingPageTemplate();
        $orderTrackingPageTemplate->register();

        // 2. Callback function to handle AJAX wc_order_search
        add_action( 'wp_ajax_wc_order_search_info', [ $this, 'handle_WC_Order_Search_Info' ] );
        add_action( 'wp_ajax_nopriv_wc_order_search_info', [ $this, 'handle_WC_Order_Search_Info' ] );
    }//register

    /** Other main operational functions */
    /** 4.1. AJAX handler for the order search feature - at order tracking page */
    public function handle_WC_Order_Search_Info(){
        // $this->localDebugger->write_log_general( $_POST['wc_order_search_nonce'] );
        // 1. Validate the oprations
        // 1.1. Verify nonce for security
        // isset( $_POST['wc_order_search_nonce'] is true
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
        // Get order by ID
        $order = wc_get_order($orderID);

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
        // 3.1. Render the progress bar for order information
        $orderStatus = esc_html( wc_get_order_status_name( $order->get_status() ) );       
        $orderStatusLowercaseName = strtolower( $orderStatus );
        
        // $this->localDebugger->write_log_general( $orderStatus );

        $htmlOrderProgress = '<div class="order-progress">';

        $htmlOrderProgress .= '<ul>';
        
        $processingStatus = $orderStatusLowercaseName == 'processing' || $orderStatusLowercaseName == 'completed' ? 'active' : '';
        $htmlOrderProgress .= sprintf(
            '<li class="processing-milestone %s">Order Received</li>',
            $processingStatus
        );

        $shippedStatus = $orderStatusLowercaseName == 'shipped' || $orderStatusLowercaseName == 'completed' ? 'active' : '';
        $htmlOrderProgress .= sprintf(
            '<li class="shipping-milestone %s">Shipped</li>',
            $shippedStatus
        );

        $completedStatus = $orderStatusLowercaseName == 'completed' ? 'active' : '';
        $htmlOrderProgress .= sprintf(
            '<li class="delivered-milestone %s">Delivered</li>',
            $completedStatus
        );

        $htmlOrderProgress .= '</ul>';

        $htmlOrderProgress .= '</div><!--.order-progress-->';

        // 3.2. Detail product list in the order
        $htmlOrders = '<table class="product-list-table">'; // Start of product list table

        // header row
        $htmlOrders .= '<tr class="header-row">';// Start of header row
        $htmlOrders .= '<th class="header-no">NO</th>';
        $htmlOrders .= '<th class="header-product-name">Product Name</th>';
        $htmlOrders .= '<th class="header-quantity">Quantity</th>';
        $htmlOrders .= '<th class="header-quantity">Price</th>';
        // $htmlOrders .= '<th class="header-subtotal-price">Subtotal Price</th>';
        $htmlOrders .= '<th class="header-total-price">Total price</th>';
        $htmlOrders .= '</tr>'; // End of header row

        // header note row
        $htmlOrders .= '<tr class="header-notes-row">';// Start of header row
        $htmlOrders .= '<th class="header-no"></th>';
        $htmlOrders .= '<th class="header-product-name"></th>';
        $htmlOrders .= '<th class="header-quantity"></th>';
        $htmlOrders .= '<th class="header-quantity"><small>Per unit</small></th>';
        //$htmlOrders .= '<th class="header-subtotal-price"><small>before applying promotional code</small></th>';
        $htmlOrders .= '<th class="header-total-price"><small>Final price for total quantity</small></th>';
        $htmlOrders .= '</tr>'; // End of header row

        $orderProducts = $order->get_items();                

        $productCount = 0;
        foreach( $orderProducts as $itemID => $itemProduct ):
            // $this->localDebugger->write_log_simple( $itemProduct );

            $productCount++;
            $product = $itemProduct->get_product();
            $productPrice = $product->get_price();

            $htmlOrders .= '<tr class="data-row">';// Start of data row
            $htmlOrders .= sprintf('<td>%s</td>', $productCount);
            $htmlOrders .= sprintf('<td>%s</td>', esc_html( $itemProduct->get_name() ) );
            $htmlOrders .= sprintf('<td>%s</td>', esc_html( $itemProduct->get_quantity() ) );
            $htmlOrders .= sprintf('<td>%s $</td>', esc_html( $productPrice ) );
            // Getter method exists but still showing error warning
            // $htmlOrders .= sprintf('<td>%s $</td>', esc_html( $itemProduct->get_subtotal() ) );
            $htmlOrders .= sprintf('<td>%s $</td>', esc_html( $itemProduct->get_total() ) );
            $htmlOrders .= '</tr><!--.data-row-->'; // End of data row
        endforeach;

        $htmlOrders .= '</table><!--.product-list-table-->';// End of product list table

        //$orderID = esc_html( $order->get_id() );
        //$orderStatus = esc_html(wc_get_order_status_name( $order->get_status() ) );
        $orderPrice = wc_price( $order->get_total() );

        // 3.3. Start rendering the HTML output for the wc_order_search_info action.
        $htmlOutput = <<<HTML
        <div class="order-information-container">
            <div class="order-id">
                <label>Order ID :</label><span>{$orderID}</span>                            
            </div>
            <div class="order-status">
                <label>Status :</label><span>{$orderStatus}</span>     
            </div>
            <div class="order-total-price">
                <label>Total price :</label><span>{$orderPrice}</span>                            
            </div>
        </div><!--.order-information-container-->                   
        HTML;

        $htmlOutput .= <<<HTML
            <br>
            {$htmlOrderProgress}
            <br>    
            <h3 style="font-weight:bold;">Order Items</h3>
            {$htmlOrders}
        HTML;

        wp_send_json_success( ['html' => $htmlOutput] );

    }//handle_WC_Order_Search_Info

}//OrderTrackingPage