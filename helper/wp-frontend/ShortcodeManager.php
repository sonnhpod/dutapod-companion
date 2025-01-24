<?php 
/**
 * @package dutalab-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Helper\WpFrontend;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

class ShortcodeManager{

    /** 1. Variable declarations */
    /** 1.1. Pages, posts data */

    /** 1.2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    public function __construct(){
        /** 1. Troubleshooting information */
        // 1.1. Load the plugin initiator
        $this->pluginInitiator = Init::$INSTANCE ?? new Init();
        
        // 1.2. Setup local properties
        $this->setLocalProperties();

        // 1.3. Setup local debuggger
        $this->setLocalDebugger();

        /** 2. Setup local properties */

        /** 3. Run the main functions */        

    }//__construct 

    /** 2.2. Helper methods for constructor */
    /** 2.2.1. Initialize the variable that point to general plugin properties */ 
    public function setLocalProperties():void{
        $this->localProps =  $this->pluginInitiator::$PLUGIN_PROPERTIES;
    }//setLocalProperties

    /** 2.2.2. setup the custom debugger for plugin */ 
    public function setLocalDebugger():void{
        $this->localDebugger = $this->pluginInitiator::$PLUGIN_DEBUGGER;
    }//setLocalDebugger

    /** 3. Operational functions - load extra internal resources for pages */
    public static function getRegisteredShortcode(){
        global $shortcode_tags;

        $shortcodeList = [];
        foreach( $shortcode_tags as $shortcode => $callbackFunction ){
            $shortcodeList[] = $shortcode;
        }

        return $shortcodeList;
    }//showRegisteredShortcode   

}//ShortcodeManager