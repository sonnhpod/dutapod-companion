<?php
/** 
 * @package DUTAPOD-Companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes;

use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

# Frontend Controller
use DutapodCompanion\Includes\Controller\ScopeFrontend\DebugTemplateController as DebugTemplateController;
use DutapodCompanion\Includes\Controller\ScopeFrontend\CustomTemplateController as CustomTemplateController;
use DutapodCompanion\Includes\Controller\ScopeFrontend\ThemeCustomizer as ThemeCustomizer;
# use DutapodCompanion\Includes\Controller\ScopeFrontend\WpPostDisplayController as WpPostDisplayController;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WpPageDisplayController as WpPageDisplayController;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\WooCommerceCustomizer as WooCommerceCustomizer;
use DutapodCompanion\Includes\Controller\ScopeFrontend\ShortcodeController as ShortcodeController;

use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\ProductPage as WcProductPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\CategoryPage as WcCategoryPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\ShopPage as WcShopPage;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\Shortcode as WcShortcode;

use DutapodCompanion\Helper\WpFrontend\ShortcodeManager as ShortcodeManager;

/** This class is dedicated to initialize all services (instances) 
 * which may be need for the plugin operation
 * 
 */

final class WcHelperInit{

    /** 1. Variable declaration */
    public static array $PLUGIN_INSTANCE_LIST;
    public static array $ADMIN_INSTANCES_LIST;
    public static array $EDITOR_INSTANCES_LIST;
    public static array $FRONTEND_INSTANCES_LIST;

    public static PluginProperties $PLUGIN_PROPERTIES;
    public static PluginDebugHelper $PLUGIN_DEBUGGER;

    /** 2. Constructor */
    public function __construct(){
        // 1. Initialize the plugin properties
        self::$PLUGIN_PROPERTIES = self::$PLUGIN_PROPERTIES ?? new PluginProperties();
        // 2. Initialize the plugin debugger
        self::$PLUGIN_DEBUGGER = self::$PLUGIN_DEBUGGER ?? new PluginDebugHelper();
    }//__construct

    /** 3. Operation functions */
    /** Initialize an instance - all services from all scopes
     * 1. Admin scope
     * 2. Editor scope
     * 3. Frontend scope
     */

    public static function register_plugin_services(){
        self::register_admin_services();
        self::register_editor_services();
        self::register_frontend_services();
    }//register_plugin_services

    public static function register_admin_services(){
        return false;
    }//register_admin_services

    public static function register_editor_services(){
        return false;
    }//register_editor_services

    public static function register_frontend_services(){
        $servicesList = self::get_frontend_services();

        foreach( $servicesList as $serviceItem ){
            // 1. Initialize an instance of the dedicated service
            $instance = self::instantiate( $serviceItem );

            // 2. Run all actions defined in the corresponding services in "register" method
            if( method_exists( $instance , 'register' ) ){
                $instance->register();
            }//method_exists( $instance , 'register' )

            self::$FRONTEND_INSTANCES_LIST[ $serviceItem ] = $instance;

        }// Endforeach $servicesList as $serviceItem
    }//register_frontend_services

    // Define a list of instance that will be initialized to run plugin
    /****
     * Make sure the order of the instance initialized
     * 1. Plugin properties
     * 2. Plugin Debug helper
     * 3. Plugin functions
     * - Inject debug template for WP default post type: page, post
     * 
     * II. The PluginClassLoader class's instance is initialized separately,
     */

     public static function get_admin_services(){
        return array(
            PluginProperties::class,            
            PluginDebugHelper::class,
        );
    }//get_admin_services

    public static function get_editor_services(){
        return array(
            PluginProperties::class,            
            PluginDebugHelper::class,
        );
    }//get_editor_services


    /** Change log
     * 1. 2024-08-01: Temporary remove WooCommerce Customizers
     *  Stop initializing the WooCommerceCustomizer instance - WooCommerceCustomizer::class
     * 2. 2024-08-16: Load extra resources for WP Post if match requirement
     * Adding an instance WpPostDisplayController::class - temporary remove
     * - The plugin property and plugin debug helper is initialize before
     * - PluginProperties::class,            
     * - PluginDebugHelper::class,        
     */
    public static function get_frontend_services(){
        return array(               
            WcProductPage::class,
            WcCategoryPage::class,
            WcShopPage::class,
            WcShortcode::class,
        );
    }//get_frontend_services

    /* Initialize an object of each registered service.
    * @param class $class : class names from the services array
    * @return return an instance of the parsing class
    * ***/
    private static function instantiate( $serviceName ){

        return new $serviceName();

    }//instantiate()

}//Init class definition