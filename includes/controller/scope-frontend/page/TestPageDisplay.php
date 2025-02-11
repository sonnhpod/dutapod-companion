<?php 
/**
 * @package dutalab-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Controller\ScopeFrontend\Page;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

class TestPageDisplay{

    /** 1. Variables & constant for post properties */
    /** 1.1.3. Test page information */
    const WP_TEST_PAGE_STYLE_FILENAME = 'wp-test-page.css';
    const WP_TEST_PAGE_STYLE_HANDLER = 'wp-test-page-style';
    const WP_TEST_PAGE_SCRIPT_FILENAME = 'wp-test-page.js';
    const WP_TEST_PAGE_SCRIPT_HANDLER = 'wp-test-page-script';

    /** 1.3.3. Extra styles & scripts for the test shortcode page */
    public static $WP_TEST_PAGE_STYLE_PATH;
    public static $WP_TEST_PAGE_SCRIPT_PATH;


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

        /** 4. Setup local properties */
        $this->setPageResourcesInfo();

        /** 5. Run the main functions */        
        /** Hook to the_post - right after the WP Query is executed */ 
        // 3.1. Load libraries:
        // $this->load_CDN_Bootstrap_Resources(); // OK = temporary disable
    
        // 3.2. Load extra resource for specific pages:        
        $this->load_Extra_Resources_If_Test_Page(); // OK - temporary disable
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
        /** 20240816 Load extra resources for a specific posts */
        /** 1. Set resources information for the library */

        /** 2. Set the resources information for WordPress test page */
        self::$WP_TEST_PAGE_STYLE_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::CSS_ROOT_DIR, 
            self::WP_TEST_PAGE_STYLE_FILENAME
        );
        
        self::$WP_TEST_PAGE_SCRIPT_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::JS_ROOT_DIR, 
            self::WP_TEST_PAGE_SCRIPT_FILENAME
        );        
    }//setPageResourcesInfo

     /** 3. Operational function */
    /** 3.1. Main operational functions */
    /** - Decide the operation of WpPostDisplayController.
     * - The constructor of any ResourceLoader or DisplayHelper will do the jobs
     */
    public function register(){
        
    }//register

    /** 3.2. Helper functions */
    /** 3.2. Load extra resources for the test shortcode page - slug "test-page" */
    public function load_Extra_Resources_If_Test_Page(){

        /** Enqueue the extra styles and scripts if requesting the home page/frontpage. */
        /** The conditional checking should be conducted at the hook "wp_enqueue_scripts" */
        //$this->localDebugger->write_log_general( $_SERVER['REQUEST_URI'] );// false


        add_action('wp_enqueue_scripts', function(){
            if( ( '/test-page/' == $_SERVER['REQUEST_URI'] || '/index.php/test-page/' == $_SERVER['REQUEST_URI'] ) && !is_admin() ){
                // Enqueue CDN tailwind library - loaded in PrelibResourceLoader class
                // $this->enqueue_Tailwindcss_Resources();

                // Enqueue extra resources
                $this->enqueue_Extra_Resources_To_Test_Page();                
            }            
        });
        

    }//load_Extra_Resources_If_Front_Page

    public function register_Extra_Resources_To_Test_Page(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$WP_TEST_PAGE_STYLE_PATH ) ? filemtime( self::$WP_TEST_PAGE_STYLE_PATH ) : false;
        wp_register_style( self::WP_TEST_PAGE_STYLE_HANDLER, self::$WP_TEST_PAGE_STYLE_PATH, [], $css_version, 'all' );

        /** 2.2. Enqueue the custom scripts */
        $js_version = file_exists( self::$WP_TEST_PAGE_SCRIPT_PATH ) ? filemtime( self::$WP_TEST_PAGE_SCRIPT_PATH ) : false;
        wp_register_script( self::WP_TEST_PAGE_SCRIPT_HANDLER, self::$WP_TEST_PAGE_SCRIPT_PATH, [], $js_version, true );

    }//enqueue_Extra_Resources_To_Front_Page

    public function enqueue_Extra_Resources_To_Test_Page(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        $css_version =  file_exists( self::$WP_TEST_PAGE_STYLE_PATH ) ? filemtime( self::$WP_TEST_PAGE_STYLE_PATH ) : false;
        wp_enqueue_style( self::WP_TEST_PAGE_STYLE_HANDLER, self::$WP_TEST_PAGE_STYLE_PATH, [], $css_version, 'all' );

        /** 2.2. Enqueue the custom scripts */
        $js_version = file_exists( self::$WP_TEST_PAGE_SCRIPT_PATH ) ? filemtime( self::$WP_TEST_PAGE_SCRIPT_PATH ) : false;
        wp_enqueue_script( self::WP_TEST_PAGE_SCRIPT_HANDLER, self::$WP_TEST_PAGE_SCRIPT_PATH, [], $js_version, true );

    }//enqueue_Extra_Resources_To_Front_Page

}//TestPageDisplay class definition