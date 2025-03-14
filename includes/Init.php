<?php
/** 
 * @package DUTAPOD-Companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes;

use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

# 1. WP admin setting page scope
// 1. General WordPress admin setting page's controller
// use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\AdminGeneral as AdminGeneral;
use DutapodCompanion\Includes\Controller\ScopeAdmin\MenuAdminPages as MenuAdminPages;
use DutapodCompanion\Includes\Controller\ScopeAdmin\AdminSettingsController as AdminSettingsController;

# 2. WP frontend scope 
// 2.1. Frontend setting controller
use DutapodCompanion\Includes\Controller\ScopeFrontend\FrontendSettingsController as FrontendSettingsController;
use DutapodCompanion\Includes\Controller\ScopeFrontend\ThemeCustomizer as ThemeCustomizer;

# 3. Global scope - at both admin scope & frontend scope
use DutapodCompanion\Includes\Database\PluginDbSettings as PluginDbSettings;

// 2.2. WordPress page (WP default post type)
// 2.2.1. Page template controller
// Move all Page template to the PageTemplatesController class
use DutapodCompanion\Includes\Controller\ScopeFrontend\PageTemplatesController as PageTemplatesController;


// 2.2.2. Page controller
// Move all Page instance to the PagesController class
use DutapodCompanion\Includes\Controller\ScopeFrontend\PagesController as PagesController;
use DutapodCompanion\Includes\Controller\ScopeFrontend\Shortcode\GeneralShortcode as GeneralShortcode;
use DutapodCompanion\Includes\Content\CustomPostTypeController as CustomPostTypeController;

// 2.3. WordPress WooCommerce custom post type
use DutapodCompanion\Includes\Controller\ScopeFrontend\WcPagesController as WcPagesController;
use DutapodCompanion\Includes\Controller\ScopeFrontend\WooCommerce\Shortcode as WcShortcode;

// use DutapodCompanion\Helper\WpFrontend\ShortcodeManager as ShortcodeManager;

/** Class descriptions
 * 1.  This class is dedicated to initialize all services (instances) 
 * which may be need for the plugin operation
 * 
 * 2. Plugin services are categorized as the following criteria:
 * - WP admin setting page scope.
 * - WP frontend display scope.
 * 
 * Sometimes the services at WP admin scope & frontend scope have mutual interaction relationship. 
 * It is necessary to initialize services from both scope with proper plugins workflows.
 */

final class Init{

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
    
    /* public static function register_plugin_services(){
        self::register_admin_services();
        self::register_editor_services();
        self::register_frontend_services();
    }//register_plugin_services */

    /**3. Main operational functions of the plugin */
    /** 3.1. Register all services belong to WP admin setting page scope */
    public static function register_admin_services(){
        $servicesList = self::get_admin_services();

        foreach( $servicesList as $serviceItem ){
            // 1. Initialize an instance of the dedicated service
            $instance = self::instantiate( $serviceItem );

            // 2. Run all actions defined in the corresponding services in "register" method
            if( method_exists( $instance , 'register' ) ){
                $instance->register();
            }//method_exists( $instance , 'register' )

            self::$FRONTEND_INSTANCES_LIST[ $serviceItem ] = $instance;

        }// Endforeach $servicesList as $serviceItem
    }//register_admin_services

    /** 3.2. Register all services belong to WP editor (post, page) scope */
    public static function register_editor_services(){
        return false;
    }//register_editor_services

    /** 3.3. Register all services belong to WP frontend display scope */
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

    /** 3.1. Register all services belong to specific needs */
    public static function regiser_custom_services( array $servicesList ){

        foreach( $servicesList as $serviceItem ){
            // 1. Initialize an instance of the dedicated service
            $instance = self::instantiate( $serviceItem );

            // 2. Run all actions defined in the corresponding services in "register" method
            if( method_exists( $instance , 'register' ) ){
                $instance->register();
            }//method_exists( $instance , 'register' )

            self::$FRONTEND_INSTANCES_LIST[ $serviceItem ] = $instance;

        }// Endforeach $servicesList as $serviceItem

    }//regiser_custom_services

    // Define a list of instance that will be initialized to run plugin
    /****
     * Make sure the order of the instance initialized
     * 1. Plugin properties
     * 2. Plugin Debug helper
     * 3. Plugin DB settings
     * 4. Plugin functions
     * - Inject debug template for WP default post type: page, post
     * 
     * II. The PluginClassLoader class's instance is initialized separately,
     */

    public static function get_admin_services(){

        return array(
            PluginProperties::class,            
            PluginDebugHelper::class,
            PluginDbSettings::class,
            MenuAdminPages::class,
            AdminSettingsController::class,
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
     * 3. 2025-01-29: Temporary move WooCommerce Customize Class to WcHelperInit
     * - WcProductPage::class,
     * - WcCategoryPage::class,
     *  PageTemplatesController::class,
     * ---
     *  DebugPageTemplate::class,
     *  CustomPageTemplate::class,  
     *  OrderTrackingPageTemplate::class - register in the OrderTrackingPage
     */
    public static function get_frontend_services(){
        return array(
            PluginProperties::class,            
            PluginDebugHelper::class,
            FrontendSettingsController::class,
            ThemeCustomizer::class,
            PageTemplatesController::class,
            GeneralShortcode::class,
            CustomPostTypeController::class,
            PagesController::class,
            WcPagesController::class,
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