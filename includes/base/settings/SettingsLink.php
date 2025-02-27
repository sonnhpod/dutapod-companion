<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace DutapodCompanion\Includes\Base\Settings;

use DutapodCompanion\Includes\Base\BaseController as BaseController;

class SettingsLink extends BaseController{

    /** 1. Variables definitions */
        
    /** 2. Constructor*/
    public function __construct(){
        // 1. Initialize BaseController properties and method
        parent::__construct();

        
    }//__construct PLUGIN_NAME

    /** 2.2. Helper method for constructor */
    public function register_Plugin_Link(){
        /** 1. Using hook "plugin_action_links_{$plugin_file}" - not work
         * - Documentation: https://developer.wordpress.org/reference/hooks/plugin_action_links_plugin_file/  */   
        // add_filter( sprintf( 'plugin_action_links_%s', self::$PLUGIN_NAME ), [ $this, 'add_Plugin_Settings_Link' ] ); // Used to work. Temporary disabled

        /** 2. Using hook "plugin_action_links"
         * - Documentation: https://developer.wordpress.org/reference/hooks/plugin_action_links/ 
        */
        add_filter( 'plugin_action_links', [ $this, 'add_Plugin_Settings_Link'], 10 , 2 );
    }//register_Plugin_Link

    public function add_Plugin_Settings_Link_2( $links ){
        // $this->localDebugger->write_log_general( $links );

        $settingsLink = '<a href="admin.php?page=dutapod_plugin">Settings</a>';

        array_push( $links, $settingsLink );

        return $links;
    }//add_Plugin_Settings_Link

    /** 1. Follow tutorial at https://developer.wordpress.org/reference/hooks/plugin_action_links/  */
    public function add_Plugin_Settings_Link( $plugin_Actions, $plugin_File ){       
        /**1. $pluginActions is an array of setting links for each plugin item in the wP admin setting plugin pages */ 
        /**2. $pluginFile is the plugin basename. An example include
         * - contact-form-7/wp-contact-form-7.php
         * - sunsetpro/sunsetpro.php
         * - dutapod-companion/dutapod-companion.php
         */
        if( self::$PLUGIN_BASENAME == $plugin_File ){
            // New action key is never duplicated because the plugin name is unique.
            $newActionKey = sprintf( '%s_settings', self::$PLUGIN_NAME );
            $settingsLink = '<a href="admin.php?page=dutapod_plugin">Settings</a>';
            
            $plugin_Actions[ $newActionKey ] =  $settingsLink;
        }
        // $this->localDebugger->write_log_general( $plugin_File ); 

        return $plugin_Actions;
    }//add_Plugin_Link

    /** 3. Main operational function */
    public function register(){
        $this->register_Plugin_Link();
        
    }//register

}//SettingsLink class definition