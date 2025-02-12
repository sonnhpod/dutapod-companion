<?php 
/**
 * @package dutalab-companion
 * @version 1.0.1
 */


namespace DutapodCompanion\Includes\Controller\ScopeFrontend\Shortcode;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

class WcShortcode{

    /** 1. Define variables & constant */

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
        //$this->set_WooCommerce_Extra_Params();
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

    /** 3. Operational functions for WooCommerce product page customizer */
    /** Key functions */
    public function register(){
        // 1. Enqueue extra resources for product page
        $this->customize_Products_Shortcode();
        // $this->customize_Best_Selling_Products_Shortcode();

        // 2. Customize HTML content for specific elements
        // --- Many codes to customize the HTML content for specific elements goes here
       
    }//register

    /** 4. Customize products shortcode */
    /** 4.1. Single product  */

    /** 4.2. Product collection */
    /** 4.2.1. "products" shortcode */
    public function customize_Products_Shortcode(){
        add_shortcode( 'custom_wc_products', [$this, 'wrap_wc_products_shortcode'] );

    }//customize_Products_Shortcode
   
    public function wrap_wc_products_shortcode( $scAttrs ){
        // Get shortcode attributes // $attrs as array        

        $scAttrsContent = '';

        foreach( $scAttrs as $key => $value ){
            // $scProductsAttrsContent .= sprintf(" %s=\"%s\"", $key, $value);
            $scAttrsContent .= " $key=\"$value\"";
        }
       
        // Get the original output of the `[products]` shortcode
        $output = do_shortcode('[products' . $scAttrsContent . ']');

        // Wrap the output in a custom div
        return '<div class="wc-products-sc-container">' . $output . '</div>';
    }//wrap_wc_products_shortcode

    /** 4.2.1. "best_selling_products" shortcode */
    /*
    public function customize_Best_Selling_Products_Shortcode(){
        add_shortcode( 'custom_wc_best_selling_products', [$this, 'wrap_best_selling_products_shortcode'] );

    }//customize_Products_Shortcode

    public function wrap_best_selling_products_shortcode( $scAttrs ){
        $scAttrsContent = '';

        foreach( $scAttrs as $key => $value ){
            // $scProductsAttrsContent .= sprintf(" %s=\"%s\"", $key, $value);
            $scAttrsContent .= " $key=\"$value\"";
        }

        // Get the original output of the `[products]` shortcode
        $output = do_shortcode('[best_selling_products' . $scAttrsContent . ']');

        // Wrap the output in a custom div
        return '<div class="wc-best-selling-products-sc-container">' . $output . '</div>';
    }//wrap_best_selling_products_shortcode
    */

}//Shortcode