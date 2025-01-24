<?php 
/**
 * @package dutalab-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Helper;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

class WpResourceLoader{

    /** 1. Variable declarations */
    /** Constant */
    const DUTAPOD_GLOBAL_STYLE_FILENAME = 'dutapod-all.css';
    const DUTAPOD_GLOBAL_STYLE_HANDLER = 'dutapod-global-style';
    const DUTAPOD_GLOBAL_SCRIPT_FILENAME = 'dutapod-all.js';
    const DUTAPOD_GLOBAL_SCRIPT_HANDLER = 'dutapod-global-script';

    /** 1.2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    /** 1.3. Resource path */
    /** 1.3. Resources path - Pages, posts data */
    public static $DUTAPOD_GLOBAL_STYLE_PATH;
    public static $DUTAPOD_GLOBAL_SCRIPT_PATH;

    /** 2. Constructor */
    public function __construct(){
        /** 1. Troubleshooting information */
        // 1.1. Load the plugin initiator
        $this->pluginInitiator = Init::$INSTANCE ?? new Init();
        
        // 1.2. Setup local properties
        $this->setLocalProperties();

        // 1.3. Setup local debuggger
        $this->setLocalDebugger();

        /** 2. Setup local properties */
        $this->setPageResourcesInfo();

        /** 3. Operational functions */
        /** 3.1. Load extra resource globally */
        $this->load_Extra_Resources_Global();
    }//__construct 

    /** 2.2. Helper methods for constructor */
    /** 2.2.1. Initialize the variable that point to general plugin properties */ 
    public function setLocalProperties():void{
        $this->localProps = $this->pluginInitiator::$PLUGIN_PROPERTIES;
    }//setLocalProperties

    /** 2.2.2. setup the custom debugger for plugin */ 
    public function setLocalDebugger():void{
        $this->localDebugger = $this->pluginInitiator::$PLUGIN_DEBUGGER;
    }//setLocalDebugger

    public function setPageResourcesInfo(){
        /** 1. Define global style path, script path */
        self::$DUTAPOD_GLOBAL_STYLE_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::CSS_ROOT_DIR, 
            self::DUTAPOD_GLOBAL_STYLE_FILENAME
        );

        self::$DUTAPOD_GLOBAL_SCRIPT_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::JS_ROOT_DIR, 
            self::DUTAPOD_GLOBAL_SCRIPT_FILENAME
        );

    }//setPageResourcesInfo

    /** 3. Operational functions - load extra internal resources for pages */
    /** 3.1. Load global extra resources for all pages (page, post, product ...) */
    /** a. Load extra resources globally */
    public function load_Extra_Resources_Global(){

        add_action( 'wp_enqueue_scripts', [$this, 'register_Extra_Resources_Global'] );

        add_action( 'wp_enqueue_scripts', function(){
            if( ! is_admin() ){
                $this->enqueue_Extra_Resources_Global();
            }
        } );

    }//load_Extra_Resources_Global

    /** b. Helper functions for loading extra resources globally */
    public function register_Extra_Resources_Global(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$DUTAPOD_GLOBAL_STYLE_PATH ) ? filemtime( self::$DUTAPOD_GLOBAL_STYLE_PATH ) : false;
        wp_register_style( self::DUTAPOD_GLOBAL_STYLE_HANDLER, self::$DUTAPOD_GLOBAL_STYLE_PATH, [], $css_version, 'all' );

        $js_version = file_exists( self::$DUTAPOD_GLOBAL_SCRIPT_PATH ) ? filemtime( self::$DUTAPOD_GLOBAL_SCRIPT_PATH ) : false;
        /** 2.2. Enqueue the custom scripts */
        wp_register_script( self::DUTAPOD_GLOBAL_SCRIPT_HANDLER, self::$DUTAPOD_GLOBAL_SCRIPT_PATH, [], $js_version, true );

    }//register_Extra_Resources_Global

    public function enqueue_Extra_Resources_Global(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$DUTAPOD_GLOBAL_STYLE_PATH ) ? filemtime( self::$DUTAPOD_GLOBAL_STYLE_PATH ) : false;
        wp_enqueue_style( self::DUTAPOD_GLOBAL_STYLE_HANDLER, self::$DUTAPOD_GLOBAL_STYLE_PATH, [], $css_version, 'all' );

        /** 2.2. Enqueue the custom scripts */
        $js_version = file_exists( self::$DUTAPOD_GLOBAL_SCRIPT_PATH ) ? filemtime( self::$DUTAPOD_GLOBAL_SCRIPT_PATH ) : false;
        wp_enqueue_script( self::DUTAPOD_GLOBAL_SCRIPT_HANDLER, self::$DUTAPOD_GLOBAL_SCRIPT_PATH, [], $js_version, true );

    }//enqueue_Extra_Resources_Global

}//WpResourceLoader