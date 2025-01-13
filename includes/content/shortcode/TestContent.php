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

class TestContent{

/** 1. Variables & constant for post properties */

    /** 2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    const TEST_CONTENT_STYLE_NAME = 'test-content.scss';
    const TEST_CONTENT_SCRIPT_NAME = 'test-content.js';

    public static $TEST_CONTENT_TEMPLATE_PATH;
    public static $TEST_CONTENT_STYLE_PATH;
    public static $TEST_CONTENT_SCRIPT_PATH;

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
        self::$TEST_CONTENT_TEMPLATE_PATH = $this->pluginInitiator::$PLUGIN_PROPERTIES::$PLUGIN_PATH.'includes/template/scope-frontend/shortcode/test-content.php';
        
        /** Example of $PLUGIN_URL: http://vncslab.local.info/wp-content/plugins/vncslab-companion/ */
        self::$TEST_CONTENT_STYLE_PATH = $this->pluginInitiator::$PLUGIN_PROPERTIES::$PLUGIN_URL.'assets/scope-frontend/css/shortcode/test-content.css';
        self::$TEST_CONTENT_SCRIPT_PATH = $this->pluginInitiator::$PLUGIN_PROPERTIES::$PLUGIN_URL.'assets/scope-frontend/js/shortcode/test-content.js';
    }//setLocalProperties

    /** 2.2.2. setup the custom debugger for plugin */ 
    public function set_Local_Debugger():void{
        $this->localDebugger = $this->pluginInitiator::$PLUGIN_DEBUGGER;

        # $this->localDebugger->write_log_general( self::$FRONT_PAGE_FOOTER_TEMPLATE_PATH  ); # OK
    }//setLocalDebugger


    /** 3. Main operational functions */
    public function renderTestContentShortcode(){
        ob_start();

        # Enqueue the corresponding separate CSS files for this shortcode
        echo sprintf( '<link rel=\'stylesheet\' id=\'dutapod-test_content-css\' href="%s"></link>', self::$TEST_CONTENT_STYLE_PATH );

        # Output the content of the shortcode
        require_once( self::$TEST_CONTENT_TEMPLATE_PATH );

        echo sprintf('<script src="%s" id="dutapod-test_content-js"></script>', self::$TEST_CONTENT_SCRIPT_PATH);

        return ob_get_clean();
    }//renderFrontPageFooter


}//TestContent
