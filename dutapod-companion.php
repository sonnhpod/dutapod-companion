<?php 
/** 
 * @package DUTAPOD-Companion
 * @version 1.0.1
 */

/*
* Plugin Name: dutapod-companion
* Plugin URI: http://vncslab.local.info
* Description: This is my 4th WordPress plugin - to support the dutapod website. 
* Author: Leon Nguyen
* Version: 1.0.1
* License: GPLv2 or later
* Text Domain: dutapod-companion
*/


use DutapodCompanion\Includes\Base\Activator as Activator;
use DutapodCompanion\Includes\Base\Deactivator as Deactivator;
use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Includes\WcHelperInit as WcHelperInit;
use DutapodCompanion\Helper\PluginClassLoader as PluginClassLoader;

/** 1. Security check whether this plugin is initialized in a proper manner */
defined( 'ABSPATH' ) or die( 'You are not authenticated to use this plugin !' );

if( !function_exists('add_action') ){
    echo '<p>You are not authenticated to access this file !</p>';
    exit;
}//function_exists('add_action')

/* 2. Include PHP vendor library & custom classnames using composer autoload:
 * - PHP vendor library (mPdf, MobileDetect ...)
 * - Custom classnames (Plugin_Activator, Plugin_Deactivator ...)
 *  */
if( file_exists( dirname(__FILE__).'/vendor/autoload.php' ) ){
    /* Also include the file with autoload */
    require_once( dirname(__FILE__).'/vendor/autoload.php' );
}//file_exists( dirname(__FILE__).'vendor/autoload.php'

/* 3. Define several global variables use across the current plugin (Devsunshine plugin scope) */

/** Some common global variables used for the plugin 
 * - These variables can be put in PluginProperties
 * PLUGIN_PATH: C:\WebPlatform\apache24\htdocs\vnlabwin\wp-content\plugins\sunsetpro\ *
 * PLUGIN_URL: http://vnlabwin.local.info/wp-content/plugins/sunsetpro/
 * PLUGIN: sunsetpro/sunsetpro.php (plugin basename)
 * **/

define('PLUGIN_PATH', plugin_dir_path(__FILE__)); //OK
define('PLUGIN_URL', plugin_dir_url(__FILE__)); //OK
define('PLUGIN', plugin_basename(__FILE__)); //OK

 /** 4. Register activation hooks, deactivation hooks for the current plugin */
register_activation_hook( __FILE__, 'activate_dutapod_companion_plugin' );
function activate_dutapod_companion_plugin(){
	/**
	 * Initialize an Init object in the Activator Class. The Init instance includes
	 * - Plugin properties
	 * - Plugin debug properties
	 * */ 
    Activator::activate();
}

register_deactivation_hook( __FILE__, 'deactivate_dutapod_companion_plugin' );
function deactivate_dutapod_companion_plugin(){
    Deactivator::deactivate();
}

/** 4.2. Custom function to enable write information to debug.log */

/** 5. Start initialize all plugins services if exists the Init class files **/

/** 6. Start initialize all plugins services if exists the Init class files **/
if( class_exists( PluginClassLoader::class ) ){
    // 2. Initialize all instances of all necessary services 
    $pluginClassLoader = new PluginClassLoader();

	// 2. Custom autoload beside Composer autoload - temporary pending because of using composer already
	// PluginClassLoader::IncludePhpFilesFromPluginDirectories();
	
}// End of class_exists( PluginClassLoader::class )

if( class_exists( Init::class ) ){
    // 1. Optimize the workflow: 
    // - If requesting to WordPress admin setting page: register admin service.
    // - Otherwise, register frontend service.
    if( is_admin() ){
        Init::register_admin_services();
    } else {
        // 1. Initialize all instances of all necessary services    
        Init::register_frontend_services();   

        // 2. Manually add PluginClassLoader to the Init::$FRONTEND_INSTANCE_LIST
        Init::$FRONTEND_INSTANCES_LIST[ PluginClassLoader::class ] = $pluginClassLoader;
    }  
}

/** 7 . Start WooCommerce Helper init */

if( class_exists( WcHelperInit::class ) ){
    // 1. Optimize the workflow
    // - If acessing frontend page, then register WooCommerce Helper at frontend display.
    
    if( !is_admin() ){
        // 1. Register frontend services for WooCommerce class helper.
        WcHelperInit::register_frontend_services();
    }    

}//class_exists( WcHelperInit::class )



/** Add to action when WooCommerce is initialied: 
 * woocommerce_loaded
 * woocommerce_init
*/

/**
$pluginInitiator = Init::$INSTANCE ?? new Init();
$pluginDebugger = $pluginInitiator::$PLUGIN_DEBUGGER;
add_action('plugins_loaded' , 'initialize_WooCommerce_Helper_Display', 20);
function initialize_WooCommerce_Helper_Display(){
    if( class_exists('WooCommcerce') ){
        if( class_exists( WcHelperInit::class ) ){
            // 1. Initialize all instances of all necessary services 
            // Init::register_services();//Used to work
            WcHelperInit::register_frontend_services();
        
            // 2. Manually add PluginClassLoader to the Init::$FRONTEND_INSTANCE_LIST
            // WcHelperInit::$FRONTEND_INSTANCES_LIST[ PluginClassLoader::class ] = $pluginClassLoader;            
        }//class_exists( WcHelperInit::class )
    } else {
        add_action( 'admin_notices', function(){
            $errorMessage = <<< HTML
            <div class="dutapod-companion-error">
                <p>
                    <strong>This plugin </strong> requires WooCommerce to be installed and activated.
                </p>
            </div><!--.dutapod-companion-error-->
            HTML;

            echo $errorMessage;
        });
    }
}//initialize_WooCommerce_Helper_Display
*/