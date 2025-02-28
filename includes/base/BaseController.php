<?php 
/** 
 * @package DUTAPOD-Companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Base;

// Init class object
use DutapodCompanion\Includes\Init as Init;
// Plugin system variables
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
// Debug helper class
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;


use DutapodCompanion\Includes\Api\SettingsManagerPage as SettingsManagerPage;

class BaseController{
    /** 1. Define variables: */
    // 1.1. Store the instance of this class. This is to create a singleton class
    // private static $INSTANCE = null;

    /** 1.2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    // 1.3. Plugin system variables
    public static string $PLUGIN_PATH; // value: C:/WebPlatforms/Apache24-62/htdocs/dutapodlab/wp-content/plugins/dutapod-companion/
    public static string $PLUGIN_URL; // value: https://dutapodlab.local.info/wp-content/plugins/dutapod-companion/ 
    public static string $PLUGIN_BASENAME; // value: dutapod-companion/dutapod-companion.php
    public static string $PLUGIN_NAME; // value: dutapod-companion

    // 1.3. General plugin properties
    // public static PluginProperties $PLUGIN_PROPERTIES;
    // public static PluginDebugHelper $PLUGIN_DEBUGGER;

    // 1.4. A list of WP admin setting pages
    public static array $ADMIN_PAGES;    

    public array $settingPageManagers;

    /** 2. Constructor */
    public function __construct(){
        /** 1. Troubleshooting information */
        // 1. Load the plugin initiator
        $this->pluginInitiator = Init::$INSTANCE ?? new Init();
        
        // 2. Setup local properties
        $this->set_Local_Properties();

        // 3. Setup local debuggger
        $this->set_Local_Debugger();

        $this->set_Additional_Local_Plugin_Properties();
        // global $PluginProperties;

        // Setup the local plugin debug information:
        //self::$PLUGIN_PROPERTIES = self::$PLUGIN_PROPERTIES ?? new PluginProperties();
        //self::$PLUGIN_DEBUGGER = self::$PLUGIN_DEBUGGER ?? new PluginDebugHelper();
        
        /** 2. Additional plugin properties */
        /** Create 3 setting page manager to manage CPT, taxonomies, widgets */
        $this->settingPageManagers = array(
            SettingsManagerPage::createInstance(
                'cpt_manager', 'Custom Post Type (CPT) Manager', 'dutapod-cpt-manager'
            ),
            SettingsManagerPage::createInstance(
                'taxonomies_manager', 'Custom Taxonomies Manager', 'dutapod-taxonomies-manager'
            ),
            SettingsManagerPage::createInstance(
                'widgets_manager', 'Widgets Manager', 'dutapod-widgets-manager'
            ),
        );         

    }//__construct

    /** 2.2. Helper method for constructor */
    /** 2.2.1. Initialize the variable that point to general plugin properties */ 
    public function set_Local_Properties():void{
        $this->localProps =  $this->pluginInitiator::$PLUGIN_PROPERTIES;
    }//setLocalProperties

    /** 2.2.2. setup the custom debugger for plugin */ 
    public function set_Local_Debugger():void{
        $this->localDebugger = $this->pluginInitiator::$PLUGIN_DEBUGGER;
    }//setLocalDebugger

    // 2.2.3. Get instance
    /* public static function getInstance(){
        if( null == self::$INSTANCE ){
            self::$INSTANCE = new BaseController();
        }

        return self::$INSTANCE;
    }//getInstance */

    /* 2.4. Define several global variables use across the current plugin (Devsunshine plugin scope)
    * PLUGIN_PATH: C:\WebPlatform\apache24\htdocs\vnlabwin\wp-content\plugins\sunsetpro *
    * PLUGIN_URL: http://vnlabwin.local.info/wp-content/plugins/sunsetpro/
    * PLUGIN: sunsetpro/sunsetpro.php (plugin basename)
    * **/

    function set_Additional_Local_Plugin_Properties(){        
        // Initialize equivalent variables in static format
        // 1. Plugin variables
        // Plugin path: E:\\WebPlatforms\\Apache24\\htdocs\\vnlabwin\\wp-content\\plugins\\sunsetpro/
        self::$PLUGIN_PATH = self::$PLUGIN_PATH ?? plugin_dir_path( dirname(__FILE__ , 2) );  
        // Convert DIRECTORY_SEPARATOR - for Windows OS:
        if( in_array( PHP_OS, array('WINNT', 'Windows') ) ){
            self::$PLUGIN_PATH = str_replace("\\", "/", self::$PLUGIN_PATH);
        }        
        
        // Plugin URL: http://vnlabwin.local.info/wp-content/plugins/sunsetpro/   
        self::$PLUGIN_URL = self::$PLUGIN_URL ?? plugin_dir_url( dirname(__FILE__ , 2) );
        // Plugin_basename: sunsetpro/sunsetpro.php , dutapod-companion/dutapod-companion.php
        self::$PLUGIN_BASENAME = self::$PLUGIN_BASENAME ?? plugin_basename( dirname(__FILE__ , 3).'/dutapod-companion.php' );
        // Plugin name : sunsetpro / dutapod-companion
        self::$PLUGIN_NAME = self::$PLUGIN_NAME ?? plugin_basename( dirname(__FILE__ , 3) );

        // 2. A list of admin setting page - not usable in this plugin scope
        self::$ADMIN_PAGES = self::$ADMIN_PAGES ?? array(
            self::$PLUGIN_NAME,   
            self::$PLUGIN_NAME.'_cpt', 
            self::$PLUGIN_NAME.'_taxonomies',
            self::$PLUGIN_NAME.'_widgets',
            self::$PLUGIN_NAME.'_plugin', 
            self::$PLUGIN_NAME.'_plugin_carousel',
            self::$PLUGIN_NAME.'_plugin_taxonomies',
            self::$PLUGIN_NAME.'_plugin_widgets',
            self::$PLUGIN_NAME.'_plugin_menu',  
            self::$PLUGIN_NAME.'_plugin_troubleshoot',
        );
    }//setLocalPluginProperties

    /** 3. Main operational functions for the local plugin properties */
    

}//BaseController class definitions