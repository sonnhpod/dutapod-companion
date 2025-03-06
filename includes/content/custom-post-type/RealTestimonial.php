<?php 
/**
 * @package dutapod-companion
 * @version 1.0.1
 */

namespace DutapodCompanion\Includes\Content\CustomPostType;

// 1. Debug information
use DutapodCompanion\Includes\Init as Init;
use DutapodCompanion\Helper\PluginProperties as PluginProperties;
use DutapodCompanion\Helper\PluginDebugHelper as PluginDebugHelper;

// 2. Operational class
use DutapodCompanion\Includes\Base\BaseController as BaseController;
use \WP_Query;

class RealTestimonial extends BaseController{

    /** 1. Variables & constant for post properties */
    /**1.1. 
     * - CPT - Custom Post Type
    */
    const CPT_NAME = 'spt_testimonial';
    const CPT_FORM_NAME = 'spt_testimonial_form';
    const SC_NAME = 'spt_shortcodes';

    /** 1.2. Debug information */
    public Init $pluginInitiator;
    public PluginProperties $localProps;
    public PluginDebugHelper $localDebugger;

    /** 2. Constructor */
    /** 2.1. Main constructor */
    public function __construct(){
        /** 1. Troubleshooting information */
        // 1. Load the plugin initiator
        $this->pluginInitiator = Init::$INSTANCE ?? new Init();
        
        // 2. Setup local properties
        $this->set_Local_Properties();

        // 3. Setup local debuggger
        $this->set_Local_Debugger();       
    }//__construct

    
    /** 2.2. Helper methods for constructors */
    /** 2.2.1. Initialize the variable that point to general plugin properties */ 
    public function set_Local_Properties():void{
        $this->localProps =  $this->pluginInitiator::$PLUGIN_PROPERTIES;
    }//setLocalProperties

    /** 2.2.2. setup the custom debugger for plugin */ 
    public function set_Local_Debugger():void{
        $this->localDebugger = $this->pluginInitiator::$PLUGIN_DEBUGGER;

        # $this->localDebugger->write_log_general( self::$FRONT_PAGE_FOOTER_TEMPLATE_PATH  ); # OK
    }//setLocalDebugger

    /** 3. Main operational functions */
    /** 3.1. Register service method */
    public function register(){
        // Failed . Unable to use WQ_Query object here because cann't use function is_user_logged_in() inside the WP_Query
        // $rt = $this->get_All_Post_Item(); 
        // $this->localDebugger->write_log_general( $rt );
        // add_action( 'wp', [ $this, 'get_All_Post_Item' ] );// OK
    }//register

    /** 3.2. */
    /** 3.2.1. Get all CPT post types item */
    public function get_All_Post_Item(){

        // Cannot fully run the WP_Query class 
        $queryArgs = [
            'post_type'         => self::CPT_NAME,
            'posts_per_page'    => -1,
        ];

        /** WP_Query class is only executable at specific hook. */
        $query = new WP_Query( $queryArgs );

        $this->localDebugger->write_log_general( $query );

        return $query;
    }//get_All_Post_Item

}//BaseController