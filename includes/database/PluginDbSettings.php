<?php
/** 
 * @package DUTAPOD-Companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Database;

// Init class object
use DutapodCompanion\Includes\Init as Init;
// Plugin system variables
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
// Debug helper class
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

/**
 * 1. Class objectives
 * - Create a custom separate table to store general settings data for this plugin operation
 * - The data stored in the database is crucial for the interaction between WP admin setting scope and WP frontend display scope.
 * 
 * 2. Detail plugin options list
 * - Activated admin submenu pages at WP admin settings scope.
 * 
*/

class PluginDbSettings{
    /** 1. Variable declarations */
    /** 1.1. DB table information */
    const DB_PLUGIN_TABLE_PREFIX = 'dutapod_';
    const DB_PLUGIN_OPTIONS_TABLE_NAME = 'options';
    // const DB_OPTION_TABLE_NAME = self::DB_TABLE_PREFIX.'options';

    public static $DB_OPTIONS_TABLE_NAME;// i.e: wp_dutapod_options;

    /** 1.2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    /** 2. Constructor */
    public function __construct(){
        /** 1. Troubleshooting information */
        // 1.1. Load the plugin initiator
        $this->pluginInitiator = Init::$INSTANCE ?? new Init();
        
        // 1.2. Setup local properties
        $this->set_Local_Properties();

        // 1.3. Setup local debuggger
        $this->set_Local_Debugger();

        // 1.4. Set additional local plugin properties
        $this->set_Additional_Local_Plugin_Properties();
        // global $PluginProperties;
        
        /** 2. Additional plugin properties */

    }//__construct

     /** 2.2. Helper method for constructor */
    /** 2.2.1. Initialize the variable that point to general plugin properties */ 
    public function set_Local_Properties():void{
        // 1. General plugin properties
        $this->localProps =  $this->pluginInitiator::$PLUGIN_PROPERTIES;
    }//setLocalProperties

    /** 2.2.2. setup the custom debugger for plugin */ 
    public function set_Local_Debugger():void{
        $this->localDebugger = $this->pluginInitiator::$PLUGIN_DEBUGGER;
    }//setLocalDebugger

    /** 2.2.3. Set additional local plugin properties */
    function set_Additional_Local_Plugin_Properties(){   
        global $wpdb;

        // 1. Set the custom WP db option table name:
        $wp_Table_Prefix = $wpdb->prefix;       

        self::$DB_OPTIONS_TABLE_NAME = $wp_Table_Prefix.self::DB_PLUGIN_TABLE_PREFIX.self::DB_PLUGIN_OPTIONS_TABLE_NAME;
    }//set_Additional_Local_Plugin_Properties


    /** 3. Main operational functions */
    /** 3.1. Main register method to register this class to the plugin workflow */
    public function register(){
        $this->create_Plugin_Options_Table_If_Not_Exist();
    }//register

    /** 3.2. The plugin's option tables */ 
    /** 3.2.1. Create the plugin's options database table if it does not existed. */
    public function create_Plugin_Options_Table_If_Not_Exist(){
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        
        $optionsTableName = self::$DB_OPTIONS_TABLE_NAME;

        $sqlCheckTable = sprintf( 'SHOW TABLES LIKE \'%s\'', $optionsTableName );

        /** 2. Create the custom options table if it does not existed */
        if( is_null( $wpdb->get_var( $sqlCheckTable ) ) ){
            /* --> Equivalent SQL statement to validate database creation command
                USE `dutapodlab`;
                CREATE TABLE `wp_dutapod_options` (
                    option_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                    option_name varchar(191) NOT NULL,
                    option_value longtext,
                    autoload varchar(20) DEFAULT 'yes'
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci ;
            */
            $sqlCreateTable = <<<SQL
            CREATE TABLE `{$optionsTableName}` (
                option_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                option_name varchar(191) NOT NULL,
                option_value longtext,
                autoload varchar(20) DEFAULT 'yes',
                PRIMARY KEY  (option_id)
            ) {$charset_collate} ;
            SQL;
            
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            // Issue the SQL command
            dbDelta( $sqlCreateTable );
            
            $successStatus = empty($wpdb->last_error);

            return true;
        }         

        return false;
    }//create_Plugin_Options_Table_If_Not_Exist

    public function delete_Duplicated_Table_If_Exist(){
        global $wpdb;

        $optionsTableBasename = self::$DB_OPTIONS_TABLE_NAME;
    }//delete_Duplicated_Table_If_Exist

}//PluginDbSettings