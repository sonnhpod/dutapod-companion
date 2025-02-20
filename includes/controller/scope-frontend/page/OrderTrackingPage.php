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
        // wp_localize_script( self::WP_FRONTPAGE_SCRIPT_HANDLER, 'woocommerce_params', [ 'ajax_url' => admin_url('admin-ajax.php') ] );
    }//enqueue_Extra_Resources_To_Front_Page

    /* 4. Main operational function */
    public function register(){
        //Inject the custom page template here 
        $orderTrackingPageTemplate = new OrderTrackingPageTemplate();
        $orderTrackingPageTemplate->register();

    }//register

}//OrderTrackingPage