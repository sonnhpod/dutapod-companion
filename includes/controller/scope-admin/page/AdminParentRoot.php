<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\SettingsManagerPage as SettingsManagerPage;
use DutapodCompanion\Includes\Base\BaseController as BaseController;

class AdminParentRoot extends BaseController{

    // 
    // public SettingsAdminPages $settings;
    // public AdminParentCallbacks $callbacks;

    public array $pages;
    public array $subpages;

    public function __construct(){
        parent::__construct();
    }//__construct

    

}//AdminParentRoot class definition
