<?php 
/** 
 * @package DUTAPOD-Companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Base;

use DutapodCompanion\Includes\Init as Init;

class Activator{

    public static Init $PLUGIN_INITIATOR;
    public static Activator $PUBLIC_INSTANCE;

    public function __construct(){
        $this->setupPluginActivator();
    }//__construct

    public function setupPluginActivator(){
        self::$PLUGIN_INITIATOR = new Init();

        // Update Init instance list
        self::$PLUGIN_INITIATOR::$PLUGIN_INSTANCE_LIST[ self::class ] = self::$PLUGIN_INITIATOR;
    }//setupPluginActivator

    public static function activate(){
        // Remove rewrite rules & re-create new rewrite rules for plugin
        flush_rewrite_rules();

        // Initialize an Activator object - calling things fron constructor
        self::$PUBLIC_INSTANCE = new self();
    }//activate

}// Activator class definition
