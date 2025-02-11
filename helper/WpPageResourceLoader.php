<?php 
/**
 * @package dutalab-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Helper;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

class WpPageResourceLoader{

    /** 1. Variable declarations */
    /** Constant */
    
    /** 1.1. Pages, posts data */
    /** 1.1.1. Resources information */
    const WP_PAGE_EXTRA_STYLES_FILENAME = 'wp-page-extra-styles.css';
    const WP_PAGE_EXTRA_STYLES_HANDLER = 'dutapod-wp-post-extra-styles';
    const WP_PAGE_EXTRA_SCRIPTS_FILENAME = 'wp-page-extra-scripts.js';
    const WP_PAGE_EXTRA_SCRIPTS_HANDLER = 'dutapod-wp-post-extra-scripts';

    /** 1.1.2. Front page information : */

    /** 1.1.3. Test page information */
    const WP_TEST_PAGE_STYLE_FILENAME = 'wp-test-page.css';
    const WP_TEST_PAGE_STYLE_HANDLER = 'wp-test-page-style';
    const WP_TEST_PAGE_SCRIPT_FILENAME = 'wp-test-page.js';
    const WP_TEST_PAGE_SCRIPT_HANDLER = 'wp-test-page-script';

    /** 1.2. Libraries */

    /** 1.1.2. Special pages to be used as condition */
    /** a. Post ID */
    const WP_PAGE_EXAMINED_LIST = [ 4079 ];

    /** 1.2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    /** 1.3. Resource path */
    /** 1.3. Resources path - Pages, posts data */
    /** 1.3.1. Extra styles & scripts for all pages */
    public static $WP_PAGE_EXTRA_STYLES_PATH;
    public static $WP_PAGE_EXTRA_SCRIPTS_PATH;

    /** 1.3.2. Extra styles & scripts for the front page */

    /** 1.3.3. Extra styles & scripts for the test shortcode page */
    public static $WP_TEST_PAGE_STYLE_PATH;
    public static $WP_TEST_PAGE_SCRIPT_PATH;

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

        /** 3. Run the main functions */        
        /** Hook to the_post - right after the WP Query is executed */ 
        // 3.1. Load libraries:
        // $this->load_CDN_Bootstrap_Resources(); // OK = temporary disable
    
        // 3.2. Load extra resource for specific pages:        
        $this->load_Extra_Resources_If_Test_Page(); // OK - temporary disable
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

        /** Set the resources information - extra styles & scripts files for WP pages */
        self::$WP_PAGE_EXTRA_STYLES_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::CSS_ROOT_DIR, 
            self::WP_PAGE_EXTRA_STYLES_FILENAME
        );
        
        self::$WP_PAGE_EXTRA_SCRIPTS_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::JS_ROOT_DIR, 
            self::WP_PAGE_EXTRA_SCRIPTS_FILENAME
        );

        

    }//setThemeResourcesInfo

    /** 3. Operational functions - load extra internal resources for pages */
    /** 3.1. Enqueue extra resources for Front Page */

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

    /** 4. Operational functions - load external resources for pages */
    /** 4.1. Load Bootstrap framework from CND front page, test page, and all other page 
     * https://getbootstrap.com/docs/5.3/getting-started/download/
     * 
     * - Applicable pages:
     * + Front page
     * + Test page
    */
     
    public function load_CDN_Bootstrap_Resources(){
        add_action('wp_enqueue_scripts', function(){
            // Enqueue Bootstrap for test page
            if( ( '/test-page/' == $_SERVER['REQUEST_URI'] || '/index.php/test-page/' == $_SERVER['REQUEST_URI'] ) && !is_admin() ){
                $this->enqueue_CDN_Bootstrap_Resources();
            }

            // Enqueue Bootstrap for home page
            if( ( is_front_page() || is_home() ) && !is_admin() ){
                $this->enqueue_CDN_Bootstrap_Resources();
            }
        }, 1);
    }//load_CDN_Bootstrap_Resources

    public function enqueue_CDN_Bootstrap_Resources(){
        wp_enqueue_style( 
            'bootstrap-cdn-min-css', 
            "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css", 
            [], '5.3.3', 'all'
        );

        /** 2.2. Enqueue the custom scripts */
        wp_enqueue_script( 
            'bootstrap-cdn-min-js', 
            "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js",
            [], '5.3.3', true
        );
    }//enqueue_CDN_Bootstrap_Resources

    /** 4.2. Load Tailwind CSS framework for test page */


    /** .................... */
    /** 3.x (final) - load extra resources if general page */


}//WpPageResourceLoader class definition
