<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace DutapodCompanion\Includes\Base;

use DutapodCompanion\Includes\Base\BaseController as BaseController;

use DutapodCompanion\Includes\Base\Settings\SettingsLink as SettingsLink ;

/** 1. Manage all plugin settings. 
 * - Settings link at WP plugin admin setting page
*/
class SettingsController extends BaseController{
    /** 1. Variables declarations */

    /** 2. Constructor */
    public function __construct(){
        parent::__construct();
    }//__construct


    /** 3. Main operational function */
    /** 3.1. Register method at Init class */
    public function register(){
        // 1. Initialize the settings link object:
        $settingsLink = new SettingsLink();
        $settingsLink->register();

    }//register

}//SettingsController class definition