<?php 
/** 
 * @package DUTAPOD-Companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Base;

use DutapodCompanion\Includes\Base\Activator as Activator;

class Deactivator{

    /** 1 . Variable declarations */

    /** 2 . Constructor */
    public function __construct(){

    }//__construct

    /** 3. Main operational functions */

    public function unsetPluginActivator(){
        if( isset( Activator::$PLUGIN_INITIATOR ) ){
            unset( Activator::$PLUGIN_INITIATOR );
        }
    }//unsetPluginActivator

    public static function deactivate(){
        // Remove rewrite rules & re-create new rewrite rules for plugin
        flush_rewrite_rules();

        if( isset( Activator::$PLUGIN_INITIATOR ) ){
            unset( Activator::$PLUGIN_INITIATOR );
        }
    }//deactivate

}// Deactivator class definition





