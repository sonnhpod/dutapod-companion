<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace DutapodCompanion\Includes\Base;

use DutapodCompanion\Includes\Base\BaseController as BaseController;

class SettingsLinks extends BaseController{

    /** 1. Variables definitions */
        
    /** 2. Constructor*/
    public function __construct(){
        parent::__construct();
    }//__construct PLUGIN_NAME

    /** 2.2. Helper method for constructor */
    public function register_Plugin_Link(){
        $this->localDebugger->write_log_general( self::$PLUGIN_BASENAME );
        // self::$PLUGIN_NAME
        add_filter( sprintf( 'plugin_action_links_%s', self::$PLUGIN_NAME ), [ $this, 'add_Plugin_Settings_Link' ] );
    }//register_Plugin_Link

    public function add_Plugin_Settings_Link( $links ){
        $settingsLink = '<a href="admin.php?page=dutapod_plugin">Settings</a>';

        array_push( $links, $settingsLink );

        return $links;
    }//add_Plugin_Settings_Link

    /** 3. Main operational function */
    public function register(){
        $this->register_Plugin_Link();
    }//register

}//SettingsLinks class definition