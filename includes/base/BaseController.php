<?php 
/** 
 * @package DUTAPOD-Companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Base;

use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\SettingsManagerPage as SettingsManagerPage;

class BaseController{
    /** 1. Define variables: */
    private static $INSTANCE = null;

    public static string $PLUGIN_PATH;
    public static string $PLUGIN_URL;
    public static string $PLUGIN_BASENAME;
    public static string $PLUGIN_NAME;

    public static PluginProperties $PLUGIN_PROPERTIES;

    public static array $ADMIN_PAGES;    

    public array $settingPageManagers;

    /* 3. Define several global variables use across the current plugin (Devsunshine plugin scope)
    * PLUGIN_PATH: C:\WebPlatform\apache24\htdocs\vnlabwin\wp-content\plugins\sunsetpro *
    * PLUGIN_URL: http://vnlabwin.local.info/wp-content/plugins/sunsetpro/
    * PLUGIN: sunsetpro/sunsetpro.php (plugin basename)
    * **/
    public function __construct(){
        // $this->pluginPath = plugin_dir_path( dirname(__FILE__ , 2) );
        // $this->pluginUrl = plugin_dir_url( dirname(__FILE__ , 2) );
        // $this->pluginName = plugin_basename( dirname(__FILE__ , 3).'/sunsetpro.php' );

        $this->setLocalPluginProperties();
        // global $PluginProperties;
        self::$PLUGIN_PROPERTIES = self::$PLUGIN_PROPERTIES ?? new PluginProperties();

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

    public function getInstance(){
        if( null == self::$INSTANCE ){
            self::$INSTANCE = new BaseController();
        }

        return self::$INSTANCE;
    }//getInstance

    function setLocalPluginProperties(){        
        // Initialize equivalent variables in static format
        // Plugin variables
        // Plugin path: E:\\WebPlatforms\\Apache24\\htdocs\\vnlabwin\\wp-content\\plugins\\sunsetpro/
        self::$PLUGIN_PATH = self::$PLUGIN_PATH ?? plugin_dir_path( dirname(__FILE__ , 2) );  
        // Convert DIRECTORY_SEPARATOR - for Windows OS:
        if( in_array( PHP_OS, array('WINNT', 'Windows') ) ){
            self::$PLUGIN_PATH = str_replace("\\", "/", self::$PLUGIN_PATH);
        }        
        
        // Plugin URL: http://vnlabwin.local.info/wp-content/plugins/sunsetpro/   
        self::$PLUGIN_URL = self::$PLUGIN_URL ?? plugin_dir_url( dirname(__FILE__ , 2) );
        // Plugin_basename: sunsetpro/sunsetpro.php
        self::$PLUGIN_BASENAME = self::$PLUGIN_BASENAME ?? plugin_basename( dirname(__FILE__ , 3).'/dutapod-companion.php' );
        // Plugin name : sunsetpro
        self::$PLUGIN_NAME = self::$PLUGIN_NAME ?? plugin_basename( dirname(__FILE__ , 3) );

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
        );
    }//setLocalPluginProperties


}//BaseController class definitions