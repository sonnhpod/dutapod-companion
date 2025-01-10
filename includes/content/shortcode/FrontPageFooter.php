<?php 
/**
 * @package vncslab-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Content\Shortcode;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Includes\Base\Activator as Activator;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

class FrontPageFooter {

    /** 1. Variables & constant for post properties */

    /** 2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    public static $FRONT_PAGE_FOOTER_TEMPLATE_PATH;

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

        /** 2. Define the front page footer template directory */
        self::$FRONT_PAGE_FOOTER_TEMPLATE_PATH = $this->pluginInitiator::$PLUGIN_PROPERTIES::$PLUGIN_PATH.'includes/template/scope-frontend/page/front-page-footer.php';
    }//setLocalProperties

    /** 2.2.2. setup the custom debugger for plugin */ 
    public function set_Local_Debugger():void{
        $this->localDebugger = $this->pluginInitiator::$PLUGIN_DEBUGGER;

        # $this->localDebugger->write_log_general( self::$FRONT_PAGE_FOOTER_TEMPLATE_PATH  ); # OK
    }//setLocalDebugger


    /** 3. Main operational functions */
    public function renderFrontPageFooter(){
        ob_start();

        require_once( self::$FRONT_PAGE_FOOTER_TEMPLATE_PATH );

        return ob_get_clean();
    }//renderFrontPageFooter

}//FrontPageFooter class definition