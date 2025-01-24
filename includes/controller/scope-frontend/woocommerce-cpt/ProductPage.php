<?php 
/**
 * @package dutalab-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;
use DutapodCompanion\Includes\Controller\ScopeFrontend\ThemeCustomizer as ThemeCustomizer;

class ProductPage{
    /** 1. Define variables & constant */
    const WC_PRODUCT_PAGE_STYLE_FILENAME = 'product-page.css';
    const WC_PRODUCT_PAGE_STYLE_HANDLER = 'wc-custom-product-page-style';

    const WC_PRODUCT_PAGE_SCRIPT_FILENAME = 'product-page.js';
    const WC_PRODUCT_PAGE_SCRIPT_HANDLER = 'wc-custom-product-page-script';

    public static $WC_PRODUCT_PAGE_STYLE_PATH;
    public static $WC_PRODUCT_PAGE_SCRIPT_PATH;

    public static string $WC_CURRENT_THEME;

    /** 1.2. Debugging variables */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    /** 2. Constructors & constructor's helper methods  */
    /** 2.1. Constructors */
    public function __construct(){
        /** 1. Declare system information */
        // 1. Plugin Initiator instance
        $this->pluginInitiator = Init::$INSTANCE ?? new Init();
        
        // 2. Setup local properties
        $this->set_Local_Properties();

        // 3. Setup local debuggger
        $this->set_Local_Debugger();

        /** 2. Setup extra WooCommerce parameters */
        $this->set_WooCommerce_Extra_Params();
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

    /** 2.2.3. Setup extra WooCommerce parameters */
    public function set_WooCommerce_Extra_Params(){
        /** 1.2. Extra styles & scripts */
        self::$WC_PRODUCT_PAGE_STYLE_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::CSS_ROOT_DIR.'woocommerce-cpt/', 
            self::WC_PRODUCT_PAGE_STYLE_FILENAME
        );
        
        self::$WC_PRODUCT_PAGE_SCRIPT_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::JS_ROOT_DIR.'woocommerce-cpt/',  
            self::WC_PRODUCT_PAGE_SCRIPT_FILENAME
        );       

    }//set_WooCommerce_Extra_Params
    public function add_Extra_Resources_to_WC_Product_Pages(){
        /** 1. Add customizing activities after all plugins are loaded */
        add_action( 'after_setup_theme', array( $this, 'register_Extra_Resources_to_WC_Product_Pages'), 100 );

        /** 1.2. Enqueue extra styles & scripts after WooCommerce & all plugins are loaded*/
        add_action( 'woocommerce_loaded', array( $this,'enqueue_Extra_Resources_to_WC_Product_Pages' ) );
    }//add_Extra_Resources_to_WC_Product_Pages

    public function register_Extra_Resources_to_WC_Product_Pages(){
        /** 2.1. Register the custom styles */
        $css_version =  file_exists( self::$WC_PRODUCT_PAGE_STYLE_PATH ) ? filemtime( self::$WC_PRODUCT_PAGE_STYLE_PATH ) : false;
        wp_register_style( self::WC_PRODUCT_PAGE_STYLE_HANDLER, self::$WC_PRODUCT_PAGE_STYLE_PATH, array(), $css_version, 'all' );

        /** 2.2. Register the custom scripts */
        $js_version = file_exists( self::$WC_PRODUCT_PAGE_SCRIPT_PATH ) ? filemtime( self::$WC_PRODUCT_PAGE_SCRIPT_PATH ) : false;
        wp_register_script( self::WC_PRODUCT_PAGE_SCRIPT_HANDLER, self::$WC_PRODUCT_PAGE_SCRIPT_PATH, array(), $js_version, true );
    }//register_Extra_Resources_to_WC_Product_pages

    public function enqueue_Extra_Resources_to_WC_Product_Pages(){
        /** 2.1. Register the custom styles */
        $css_version =  file_exists( self::$WC_PRODUCT_PAGE_STYLE_PATH ) ? filemtime( self::$WC_PRODUCT_PAGE_STYLE_PATH ) : false;
        wp_enqueue_style( self::WC_PRODUCT_PAGE_STYLE_HANDLER, self::$WC_PRODUCT_PAGE_STYLE_PATH, array(), $css_version, 'all' );

        /** 2.2. Register the custom scripts */
        $js_version = file_exists( self::$WC_PRODUCT_PAGE_SCRIPT_PATH ) ? filemtime( self::$WC_PRODUCT_PAGE_SCRIPT_PATH ) : false;
        wp_enqueue_script( self::WC_PRODUCT_PAGE_SCRIPT_HANDLER, self::$WC_PRODUCT_PAGE_SCRIPT_PATH, array(), $js_version, true );
    }//enqueue_Extra_Resources_to_WC_Product_pages

    /** 3. Operational functions for WooCommerce product page customizer */
    /** Key functions */
    public function register(){
        // 1. Enqueue extra resources for product page
        $this->add_Extra_Resources_to_WC_Product_Pages();

        // 2. Customize HTML content for specific elements
        // --- Many codes to customize the HTML content for specific elements goes here
        $this->adjust_Product_Description_Position();

    }//register


    /***************************** Helper functions ***********************/

    /** 3.1. Product description */
    public function adjust_Product_Description_Position(){
        add_action(
            'woocommerce_before_add_to_cart_quantity',
            [ $this, 'add_Product_Description_Detail_To_Product_Summary_Section' ]
        ); 

        /* add_action(
            'woocommerce_single_product_summary',
            [ $this, 'add_Product_Description_Detail_To_Product_Summary_Section' ]
        ); */
    }//adjust_Product_Description_Position

    public function add_Product_Description_Detail_To_Product_Summary_Section(){
        // return '<p>This is the content dispaly before the "add to cart" button </p>';
        global $post;

        $detailProductDescription = apply_filters( 'the_content', $post->post_content );

        if( !empty( $detailProductDescription ) ){
            $detailProductDescriptionHTML = <<< HTML
            <div class="woocommerce-product-detail-description product-description-accordion-container custom-product-description">
                <button class="custom-accordion-button" id="custom-product-description-toggle" aria-expanded="false" aria-controls="custom-description-content">
                  Detail Product description
                </button>
                <div class="custom-accordion-content" id="custom-description-content">
                    {$detailProductDescription}
                </div><!--#custom-description-content.custom-accordion-content  -->         
            </div><!--.woocommerce-product-detail-description.product-description-accordion-container.custom-product-description-->
            HTML;

            echo $detailProductDescriptionHTML;
        }
    }//add_Product_Description_Detail_To_Product_Summary_Section

}//ProductPage