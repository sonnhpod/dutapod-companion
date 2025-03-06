<?php 
/** 
 * @package vncslab-companion
 * @version 1.0.1
 */


namespace DutapodCompanion\Includes\Content;

// 1. Debug class
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

// 2. Main operational class
// 2.1. Base class 
use DutapodCompanion\Includes\Base\BaseController as BaseController;
// 2.2. Detail WP content
use DutapodCompanion\Includes\Content\CustomPostType\RealTestimonial as RealTestimonial;

class CustomPostTypeController extends BaseController{

    /** 1. Variable declaration */
    // 1.1. Manage the page template list
    public static array $CUSTOM_POST_TYPES;// Tracking variables to manage PAGE instance
    public static array $CUSTOM_POST_TYPES_LIST; // List of the page instances name

    /** 2. Constructor */
    public function __construct(){
        // 1. Initialize parent constructor
        parent::__construct();        
        
        /** 2. Initialize page list instance. Class name must be placed at right order
        * - Class name is the name of each class with full namespace.  
        * For example: DutapodCompanion\Includes\Controller\ScopeFrontend\Page\FrontPage
        */
        self::$CUSTOM_POST_TYPES_LIST = [
            RealTestimonial::class,
        ];
    }//__construct

         /** 3. Main operational functions */
    /** 3.1. Register all page templates services to the plugin workflow */
    public function register(){       
        // $this->localDebugger->write_log_general( self::$CUSTOM_POST_TYPES_LIST );
        // Validate the variable self::$CUSTOM_POST_TYPES_LIST

        // Iterate through each page name in the page list
        foreach( self::$CUSTOM_POST_TYPES_LIST as $cptName ){
            // class name $custom_Post_Type is valid 
            // $this->localDebugger->write_log_general( class_exists( $cptName ) );
            // --> class_exists( $cptName ) return false even though the actual class exist
            if( class_exists( $cptName ) ){
                // 1. Initialize the corresponding page name
                
                $cpt = new $cptName();

                // 2. Register each page name to the WP plugin's workflow
                $cpt->register();

                // 3. Add to the PAGES list for tracking purpose
                self::$CUSTOM_POST_TYPES[ $cptName ] = $cpt;
            }
        }//self::$PAGES_LIST as $page
    }//register

}//CustomPostTypeController
