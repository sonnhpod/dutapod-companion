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
    const WC_PRODUCT_PAGE_STYLE_HANDLER = 'wc-product-page-style';

    const WC_PRODUCT_PAGE_SCRIPT_FILENAME = 'product-page.js';
    const WC_PRODUCT_PAGE_SCRIPT_HANDLER = 'wc-product-page-script';

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
        /** 1. Check if the incoming request is single WooCommerce Product page */ 

        /** 1. Add customizing activities after all plugins are loaded */
        add_action( 'after_setup_theme', [ $this, 'register_Extra_Resources_to_WC_Product_Pages'], 100 );

        /** 1.2. Enqueue extra styles & scripts after WooCommerce & all plugins are loaded*/
        /** Need to use further hooks than "woocommerce_loaded":
         * wp, template_redirect, woocommerce_before_main_content
         */

        // add_action( 'woocommerce_loaded', [ $this,'enqueue_Extra_Resources_to_WC_Product_Pages' ] );//OK at 20250129
        add_action( 'woocommerce_before_main_content', [ $this,'enqueue_Extra_Resources_to_WC_Product_Pages' ] );
    
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
        if( is_product() ){
            /** 2.1. Register the custom styles */
            $css_version =  file_exists( self::$WC_PRODUCT_PAGE_STYLE_PATH ) ? filemtime( self::$WC_PRODUCT_PAGE_STYLE_PATH ) : false;
            wp_enqueue_style( self::WC_PRODUCT_PAGE_STYLE_HANDLER, self::$WC_PRODUCT_PAGE_STYLE_PATH, array(), $css_version, 'all' );

            /** 2.2. Register the custom scripts */
            $js_version = file_exists( self::$WC_PRODUCT_PAGE_SCRIPT_PATH ) ? filemtime( self::$WC_PRODUCT_PAGE_SCRIPT_PATH ) : false;
            wp_enqueue_script( self::WC_PRODUCT_PAGE_SCRIPT_HANDLER, self::$WC_PRODUCT_PAGE_SCRIPT_PATH, array(), $js_version, true );
        }

    }//enqueue_Extra_Resources_to_WC_Product_pages

    /** 3. Operational functions for WooCommerce product page customizer */
    /** Key functions */
    public function register(){      
        // 1. Enqueue extra resources for product page
        $this->add_Extra_Resources_to_WC_Product_Pages();

        // 2. Customize HTML content for specific elements
        // --- Many codes to customize the HTML content for specific elements goes here
        // 2.1. Add product description to the "add to cart" button:
        $this->add_Product_Description_before_Add_To_Cart_Button();

        // 2.2. Customize the structured data product:
        $this->restructure_Product_Tabs_Section();

        // 2.3. Display the "product review" before the "related product" section:
        $this->display_Product_Review();
    }//register


    /***************************** Helper functions ***********************/

    /** 3.1. Add the "Product description" to the "Product Summary" section - right side of the product gallery */
    public function add_Product_Description_before_Add_To_Cart_Button(){
        // 1. Add product description to the "product summary" column, before "add to cart" button:
        add_action(
            'woocommerce_before_add_to_cart_quantity',
            [ $this, 'add_Product_Description_Detail_To_Product_Summary_Section' ]
        );         
        
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

    /** 3.2. Restructure the "product tabs" */
    public function restructure_Product_Tabs_Section(){
        /** Hooks probe notes : 
         * 1. "woocommerce_product_description_tab_title"
         * - Display the tille of the description tag : "description"
         * 2. "woocommerce_product_description_heading"
         * - Display the tille of the description tag : "description"
         * 
         * 3. "woocommerce_product_tabs" show empty array.
         * 
         * 4. "woocommerce_after_single_product_summary"
        */
        /**
         * 1. Remove the "product description" tab and the ""Review" tab 
         * - The "product description" tab is moved to the "product summary" section - in the right side of the product gallery.
         * - The "review" tab is moved behind the "Product Attributes" (Additional Information) 
         * */ 
        add_filter( 'woocommerce_product_tabs' , [ $this, 'restructure_Product_Tabs_Info'], 11 );//OK

    }//customize_Structured_Data_Product

    public function restructure_Product_Tabs_Info( $productTabsData ){
        // Guarding the operation of this callback function.
        if( !is_array( $productTabsData ) ) return $productTabsData;

        // 1. Remove the "product description" tab.
        if( array_key_exists( 'description', $productTabsData ) ){
            unset( $productTabsData['description'] );
        }

        // 2. Remove the "review" tab
        if( array_key_exists( 'reviews', $productTabsData ) ){
            unset( $productTabsData['reviews'] );
        }

        // 3. Rename the product data detail values
        if( array_key_exists( 'additional_information', $productTabsData ) ){
            $productTabsData['additional_information']["title"] = 'Product Attributes';
        }       

        // $this->localDebugger->write_log_general( $productTabsData );

        return $productTabsData;

    }//reformat_Structured_Data_Product

    /** 3.3. Display the "product Reviews" after the "product tabs" section. */
    public function display_Product_Review(){
        /** Hook probes 
         * - "woocommerce_before_related_products" - does not work
         * - "woocommerce_product_after_tabs" - OK
        */
        add_action('woocommerce_product_after_tabs', [$this, 'output_Product_Review_HTML']);

    }//display_Product_Review

    public function output_Product_Review_HTML(){
        global $product;

        // $this->localDebugger->write_log_general( $product );

        // Ensure of review is enabled
        if( ! comments_open( $product->get_id() ) ){
            return ;
        } 

        echo '<div class="woocommerce-custom-reviews-section">';
        echo '<h3>Product Review</h3>';
        comments_template();
        echo '</div><!--."woocommerce-custom-reviews-section -->';

    }//output_Product_Review_HTML

}//ProductPage