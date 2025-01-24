<?php 
/**
 * @package dutalab-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Helper;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

class PrelibResourceLoader{

    /** 1. Variable declarations */
    /** 1.2. Libraries */
    /** 1.2. TailwindCSS - build locally at WordPress plugin */
    const TAILWINDCSS_STYLE_FILENAME = 'tailwindcss-full.css';
    const TAILWINDCSS_STYLE_HANDLER = 'prelib-tailwindcss-style';

    /** 1.2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    /** 1.4. Resources path - Libraries */
    public static $TAILWINDCSS_STYLE_PATH;

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
        $this->load_Tailwindcss_For_Specific_Pages();

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
        self::$TAILWINDCSS_STYLE_PATH = sprintf( 
            '%s%s%s%s', 
            PluginProperties::$PLUGIN_URL, 
            PluginProperties::RESOURCES_PRELIB_ROOT_DIR,
            PluginProperties::CSS_ROOT_DIR, 
            self::TAILWINDCSS_STYLE_FILENAME
        );
    }//setPageResourcesInfo

    
    /** 3. Operational functions */
    /** 3.1. Tailwind framework */
    /** a. Load Tailwind resources for specific page */
    public function load_Tailwindcss_For_Specific_Pages(){
        add_action('wp_enqueue_scripts', function(){
            
            // 1. Load TailwindCSS framework for the home page/front page:
            if( ( is_front_page() || is_home() ) && !is_admin() ){
                // Enqueue Tailwind library
                $this->enqueue_Tailwindcss_Resources();            
            }

            // 2. Load TailwindCSS framework for the test page:
            if( ( '/test-page/' == $_SERVER['REQUEST_URI'] || '/index.php/test-page/' == $_SERVER['REQUEST_URI'] ) && !is_admin() ){
                // Enqueue CDN tailwind library
                $this->enqueue_Tailwindcss_Resources();              
            }
        });

    }//load_Tailwindcss_For_Specific_Pages

    /** b. Helper function Enqueue TailwindCSS library built locally on the WordPress plugin */
    public function enqueue_Tailwindcss_Resources(){
        /** 2.1. Enqueue the custom styles */
        wp_enqueue_style( self::TAILWINDCSS_STYLE_HANDLER, self::$TAILWINDCSS_STYLE_PATH, [], '3.4.17', 'all' );
        
    }//enqueue_Tailwindcss_Resources

}//PrelibResourceLoader