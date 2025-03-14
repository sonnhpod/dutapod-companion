<?php 
/**
 * @package dutapod-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Controller\ScopeFrontend\Page;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

class FrontPage{

    /** 1. Variables & constant for post properties */
    /** 1.1.2. Front page information : */
    const WP_FRONTPAGE_STYLE_FILENAME = 'dutapod-front-page.css';
    const WP_FRONTPAGE_STYLE_HANDLER = 'dutapod-front-page-style';
    const WP_FRONTPAGE_SCRIPT_FILENAME = 'dutapod-front-page.js';
    const WP_FRONTPAGE_SCRIPT_HANDLER = 'dutapod-front-page-script';

    /** Extra styles & scripts for the front page */
    public static $WP_FRONTPAGE_STYLE_PATH;
    public static $WP_FRONTPAGE_SCRIPT_PATH;

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
        $this->load_Extra_Resources_If_Front_Page();
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
        self::$WP_FRONTPAGE_STYLE_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::CSS_ROOT_DIR.'page/', 
            self::WP_FRONTPAGE_STYLE_FILENAME
        );

        self::$WP_FRONTPAGE_SCRIPT_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::JS_ROOT_DIR.'page/', 
            self::WP_FRONTPAGE_SCRIPT_FILENAME
        );


    }//setPageResourcesInfo

    /** 3. Operational function */
    /** 3.1. Main operational functions */
    /** - Decide the operation of WpPostDisplayController.
     * - The constructor of any ResourceLoader or DisplayHelper will do the jobs
     */
    public function register(){
        /** 1. AJAX handler Lazy load the best selling product shortcode to 
         * container "div#best-selling-products-lazy-load-container-id.best-selling-products-lazy-load-container" */
        add_action('wp_ajax_load_lazy_best_selling_products', [$this,'lazy_Load_WC_Best_Selling_Products_Section']);
        add_action('wp_ajax_nopriv_load_lazy_best_selling_products', [$this,'lazy_Load_WC_Best_Selling_Products_Section']);
    }//register


    /** 3.2. Helper functions */
    /** 3.2.1. Enqueue extra resources for Front Page */
    public function load_Extra_Resources_If_Front_Page(){
        add_action('wp_enqueue_scripts', function(){
            if( ( is_front_page() || is_home() ) && !is_admin() ){
                // Enqueue Tailwind library - loaded in PrelibResourceLoader class
                // $this->enqueue_Tailwindcss_Resources();

                // Enqueue custom CSS
                $this->enqueue_Extra_Resources_To_Front_Page();
            }
        }, PHP_INT_MAX);       
    }//load_Extra_Resources_If_Front_Page

    public function register_Extra_Resources_To_Front_Page(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$WP_FRONTPAGE_STYLE_PATH ) ? filemtime( self::$WP_FRONTPAGE_STYLE_PATH ) : false;
        wp_register_style( self::WP_FRONTPAGE_STYLE_HANDLER, self::$WP_FRONTPAGE_STYLE_PATH, [], $css_version, 'all' );

        /** 2.2. Enqueue the custom scripts */
        $js_version = file_exists( self::$WP_FRONTPAGE_SCRIPT_PATH ) ? filemtime( self::$WP_FRONTPAGE_SCRIPT_PATH ) : false;
        wp_register_script( self::WP_FRONTPAGE_SCRIPT_HANDLER, self::$WP_FRONTPAGE_SCRIPT_PATH, [], $js_version, true );

    }//enqueue_Extra_Resources_To_Front_Page

    public function enqueue_Extra_Resources_To_Front_Page(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$WP_FRONTPAGE_STYLE_PATH ) ? filemtime( self::$WP_FRONTPAGE_STYLE_PATH ) : false;
        wp_enqueue_style( self::WP_FRONTPAGE_STYLE_HANDLER, self::$WP_FRONTPAGE_STYLE_PATH, [], $css_version, 'all' );

        /** 2.2. Enqueue the custom scripts */
        $js_version = file_exists( self::$WP_FRONTPAGE_SCRIPT_PATH ) ? filemtime( self::$WP_FRONTPAGE_SCRIPT_PATH ) : false;
        wp_enqueue_script( self::WP_FRONTPAGE_SCRIPT_HANDLER, self::$WP_FRONTPAGE_SCRIPT_PATH, [], $js_version, true );

        /**  2.2.2. Localize this additional front page script */
        wp_localize_script( self::WP_FRONTPAGE_SCRIPT_HANDLER, 'woocommerce_params', [ 'ajax_url' => admin_url('admin-ajax.php') ] );
    }//enqueue_Extra_Resources_To_Front_Page

    /** 3.2.2. Enqueue extra resources for Front Page */

    function lazy_Load_WC_Best_Selling_Products_Section(){
        // Ensure WooCommerce is active
        if( ! class_exists( 'WooCommerce' ) ){
            wp_send_json_error(['message' => 'WooCommerce not active']);
        }

        // $shortcodeDisplay = '[best_selling_products columns="4" limit="4" paginate="true"]';// Error: display all pages
        // $shortcodeDisplay = '[products tag="best-selling" columns="4" limit="4" paginate="true"]';// Error with pagination
        $shortcodeDisplay = '[products tag="featured-product" columns="4" limit="4" paginate="false"]';

        $productsHTML = do_shortcode( $shortcodeDisplay );
        
        /* $responseHTML = <<<HTML
        <div class="wc-products-sc-container">
            {$productsHTML}
        </div><!--.wc-products-sc-container-->
        HTML; */

        wp_send_json_success( ['html' => $productsHTML] );
    }//lazy_Load_WC_Best_Selling_Products_Section


}//FrontPage class definition