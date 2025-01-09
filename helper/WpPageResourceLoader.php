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
    /** 1.1. Constant */
    /** 1.1.1. Resources information */
    const WP_PAGE_EXTRA_STYLES_FILENAME = 'wp-page-extra-styles.css';
    const WP_PAGE_EXTRA_STYLES_HANDLER = 'dutapod-wp-post-extra-styles';
    const WP_PAGE_EXTRA_SCRIPTS_FILENAME = 'wp-page-extra-scripts.js';
    const WP_PAGE_EXTRA_SCRIPTS_HANDLER = 'dutapod-wp-post-extra-scripts';

    /** 1.1.2. Front page information : */
    const WP_FRONTPAGE_STYLE_FILENAME = 'dutapod-front-page.css';
    const WP_FRONTPAGE_STYLE_HANDLER = 'dutapod-front-page-style';
    const WP_FRONTPAGE_SCRIPT_FILENAME = 'dutapod-front-page.js';
    const WP_FRONTPAGE_SCRIPT_HANDLER = 'dutapod-front-page-script';

    /** 1.1.2. Special pages to be used as condition */
    /** a. Post ID */
    const WP_PAGE_EXAMINED_LIST = [ 4079 ];

    /** 1.2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    /** 1.3. Resource path */
    public static $WP_PAGE_EXTRA_STYLES_PATH;
    public static $WP_PAGE_EXTRA_SCRIPTS_PATH;

    public static $WP_FRONTPAGE_STYLE_PATH;
    public static $WP_FRONTPAGE_SCRIPT_PATH;

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
        //add_action( 'the_post' , [$this,'load_Extra_Resources_If_Post_4079'] );//OK but not optimized    
        // Load extra resource if Front Page: 
        $this->load_Extra_Resources_If_Front_Page();
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

        /** Set the resources information for WordPress front page */
        self::$WP_FRONTPAGE_STYLE_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::CSS_ROOT_DIR, 
            self::WP_FRONTPAGE_STYLE_FILENAME
        );
        
        self::$WP_FRONTPAGE_SCRIPT_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_FRONTEND_ROOT_DIR,
            PluginProperties::JS_ROOT_DIR, 
            self::WP_FRONTPAGE_SCRIPT_FILENAME
        );

    }//setThemeResourcesInfo

    /** 3. Operational functions */
    /** 3.1. Enqueue extra resources for Front Page */
    public function load_Extra_Resources_If_Front_Page(){

        /** Enqueue the extra styles and scripts if requesting the home page/frontpage. */
        /** The conditional checking should be conducted at the hook "wp_enqueue_scripts" */
        // $this->localDebugger->write_log_general( is_front_page() );// false


        add_action('wp_enqueue_scripts', function(){
            if( ( is_front_page() || is_home() ) && !is_admin() ){
                $this->enqueue_Extra_Resources_To_Front_Page();
            }
        });

        /** - another OK method to check if the current requesting page is the home page
        if( '/' == $_SERVER['REQUEST_URI'] && !is_admin() ){
            add_action('wp_enqueue_scripts',[$this,'register_Extra_Resources_To_Front_Page']);
            add_action('wp_enqueue_scripts',[$this,'enqueue_Extra_Resources_To_Front_Page']);
        }
        */      

    }//load_Extra_Resources_If_Front_Page

    public function register_Extra_Resources_To_Front_Page(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        wp_register_style( 
            self::WP_FRONTPAGE_STYLE_HANDLER, 
            self::$WP_FRONTPAGE_STYLE_PATH, 
            [], '1.0.1', 'all'
        );

        /** 2.2. Enqueue the custom scripts */
        wp_register_script( 
            self::WP_FRONTPAGE_SCRIPT_HANDLER, 
            self::$WP_FRONTPAGE_SCRIPT_PATH,
            [], '1.0.1', true
        );

    }//enqueue_Extra_Resources_To_Front_Page

    public function enqueue_Extra_Resources_To_Front_Page(){
        /** 2. Enqueue extra styles & scripts  */
        /** 2.1. Enqueue the custom styles */
        wp_enqueue_style( 
            self::WP_FRONTPAGE_STYLE_HANDLER, 
            self::$WP_FRONTPAGE_STYLE_PATH, 
            [], '1.0.1', 'all'
        );

        /** 2.2. Enqueue the custom scripts */
        wp_enqueue_script( 
            self::WP_FRONTPAGE_SCRIPT_HANDLER, 
            self::$WP_FRONTPAGE_SCRIPT_PATH,
            [], '1.0.1', true
        );

    }//enqueue_Extra_Resources_To_Front_Page

    /** 3.x (final) - load extra resources if general page */


}//WpPageResourceLoader class definition
