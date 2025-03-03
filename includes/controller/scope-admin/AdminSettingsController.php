<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace DutapodCompanion\Includes\Controller\ScopeAdmin;

use DutapodCompanion\Includes\Base\BaseController as BaseController;

use DutapodCompanion\Includes\Base\Settings\PluginLink as PluginLink ;

/** 1. Manage all plugin settings. 
 * - Settings link at WP plugin admin setting page
*/
class AdminSettingsController extends BaseController{
    /** 1. Variables declarations */
    public static array $GENERAL_SETTINGS;// Tracking variables to manage PAGE instance
    public static array $GENERAL_SETTINGS_LIST; // List of the page instances name

    /** 2. Constructor */
    public function __construct(){
        // 1. Initialize the BaseController properites
        parent::__construct();

        // 2. Initialize setting item instances
        self::$GENERAL_SETTINGS_LIST = [
            PluginLink::class,
        ];
    }//__construct


    /** 3. Main operational function */
    /** 3.1. Register method at Init class */
    public function register(){
        // Iterate through each page name in the page list
        foreach( self::$GENERAL_SETTINGS_LIST as $settingsItemName ){
            if( class_exists( $settingsItemName ) ){
                // 1. Initialize the corresponding page name
                $settingsItem = new $settingsItemName();

                // 2. Register each page name to the WP plugin's workflow
                $settingsItem->register();

                // 3. Add to the PAGES list for tracking purpose
                self::$GENERAL_SETTINGS[ $settingsItemName ] = $settingsItem;
            }            
        }//self::$PAGES_LIST as $page
    }//register

}//AdminSettingsController class definition