<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace  DutapodCompanion\Includes\Controller\ScopeAdmin\Page;

use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\SettingsManagerPage as SettingsManagerPage;
use DutapodCompanion\Includes\Base\BaseController as BaseController;

/** Support the display and operational function of the admin's parent root page 
 * 1. Enqueue custom CSS and JS.
 * 2. Handle AJAX request if it is exist.
 * 
*/

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
