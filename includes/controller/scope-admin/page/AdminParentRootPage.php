<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace  DutapodCompanion\Includes\Controller\ScopeAdmin\Page;

use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\SettingsManagerPage as SettingsManagerPage;
use DutapodCompanion\Includes\Api\Callbacks\Admin\DisplayWpAdminPages as DisplayWpAdminPages;
use DutapodCompanion\Includes\Base\BaseController as BaseController;

/** Support the display and operational function of the admin's parent root page 
 * 1. Enqueue custom CSS and JS.
 * 2. Display the content of this page at its corresponding WP admin setting pages - OK
 * 3. Handle AJAX request if it is exist.
 * 
*/

class AdminParentRootPage extends BaseController{

    /** 1. Variable decalration */
    public DisplayWpAdminPages $displayCallbacks;

    /** 2. Constructor */
    public function __construct(){
        parent::__construct();

        $this->displayCallbacks = DisplayWpAdminPages::getInstance();

    }//__construct

    /** 2.2. Helper method for constructor*/

    /** 3. Main operational function */ 
    /** 3.1. Render page content */
    public function renderPageContent(){
        $this->displayCallbacks = $this->displayCallbacks ?? DisplayWpAdminPages::getInstance();

        $this->displayCallbacks->renderAdminParentRootPage();
    }//renderTroubleshootSubpageContent

}//AdminParentRoot class definition
