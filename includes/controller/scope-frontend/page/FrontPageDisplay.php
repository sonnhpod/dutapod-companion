<?php 
/**
 * @package dutapod-companion
 * @version 1.0.1
 */

 namespace DutapodCompanion\Includes\Controller\ScopeFrontend\Page;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

class FrontPageDisplay{

    /** 1. Variables & constant for post properties */

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

    /** 3. Operational function */
    /** 3.1. Main operational functions */
    /** - Decide the operation of WpPostDisplayController.
     * - The constructor of any ResourceLoader or DisplayHelper will do the jobs
     */
    public function register(){
        /** 1. AJAX handler Lazy load the best selling product shortcode to 
         * container "div#best-selling-products-lazy-load-container-id.best-selling-products-lazy-load-container" */
       
    }//register


    /** 3.2. Helper functions */

    function lazy_Load_WC_Best_Selling_Products_Section(){
        // Ensure WooCommerce is active
        if( ! class_exists( 'WooCommerce' ) ){
            wp_send_json_error(['message' => 'WooCommerce not active']);
        }

        
    }//lazy_Load_WC_Best_Selling_Products_Section


}//FrontPageDisplay class definition