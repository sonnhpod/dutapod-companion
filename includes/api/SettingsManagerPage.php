<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace DutapodCompanion\Includes\Api;

class SettingsManagerPage{

    public string $id; // $option_name, $field_id - calling at Admin.php
    // public string $option_group;
    //public string $option_name;
    // public string $field_id;
    public string $title; // $field_title - calling at Admin.php
    public string $classname; // $field_classname - calling at Admin.php

    public function __construct(string $title){
        $this->title = $title;
    }//__construct

    public static function createInstance(string $id, string $title, string $classname): SettingsManagerPage
    {
        $settingPage = new self( $title );
        $settingPage->id = $id;    
        $settingPage->classname = $classname;

        return $settingPage;
    }//createInstance
    
}//SettingsManagerPage class definition