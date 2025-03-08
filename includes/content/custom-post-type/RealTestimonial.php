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

/** 1. This is a controller class to handle the custom post type testimonial - created by the plugin Real Testimonial
 * - Source information: https://wordpress.org/plugins/testimonial-free/
 * 
 * 2. Perform customization on the custom post type of this plugin
 * - Add custom fields. 
 */

class RealTestimonial extends BaseController{

    /** 1. Variables & constant for post properties */
    /**1.1. Real testimonial custom post type
     * - CPT - Custom Post Type
    */
    const CPT_NAME = 'spt_testimonial';
    const CPT_FORM_NAME = 'spt_testimonial_form';
    const SC_NAME = 'spt_shortcodes';

    const REQUIRED_PLUGIN_BASENAME = "testimonial-free/testimonial-free.php";

    /** 1.1.3. Custom post type list */
    public static array $CUSTOM_LIST_ITEMS;

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
        // 1. Initialize the local properties object
        $this->localProps =  $this->pluginInitiator::$PLUGIN_PROPERTIES;

        // 2. Initialize the default static properties. This is to prevent error
        self::$CUSTOM_LIST_ITEMS = [];
    }//setLocalProperties

    /** 2.2.2. setup the custom debugger for plugin */ 
    public function set_Local_Debugger():void{
        $this->localDebugger = $this->pluginInitiator::$PLUGIN_DEBUGGER;

        # $this->localDebugger->write_log_general( self::$FRONT_PAGE_FOOTER_TEMPLATE_PATH  ); # OK
    }//setLocalDebugger

    /** 3. Main operational functions */
    /** 3.1. Register service method */
    public function register(){
        // 1. Check if the Real Testimonial free plugin is installed
        if( $this->is_Required_Plugin_Activated() ){
            add_action( 'wp', [ $this, 'get_All_Post_Item' ] );// OK  
        }

        // $this->localDebugger->write_log_general( self::$CUSTOM_LIST_ITEMS );
              
    }//register

    /** 3.2. Validation method */
    /** 3.2.1. Check if the real testimonial free plugin is installed and activated */
    public function is_Required_Plugin_Activated(){
        // $activePlugin = get_option( 'active_plugins' );// OK - obtain an array of plugin basename

        $installedPlugins = apply_filters( 'active_plugins' , get_option( 'active_plugins' ) );
        // $this->localDebugger->write_log_general( in_array( self::REQUIRED_PLUGIN_BASENAME, $installedPlugins ) );

        return in_array( self::REQUIRED_PLUGIN_BASENAME, $installedPlugins ) ;
    }//is_Real_Testimonial_Free_Plugin_Installed

    /** 3.3. Manipulate custom post type created by the plugin Real Testimonial free */
    /** 3.3.1. Get all CPT post types item. Run at 'wp' hook */
    public function get_All_Post_Item(){

        // Cannot fully run the WP_Query class 
        $queryArgs = [
            'post_type'         => self::CPT_NAME,
            'posts_per_page'    => -1,
        ];

        /** WP_Query class is only executable at specific hook. */
        $query = new WP_Query( $queryArgs );

        $count = 0;

        global $post;
    
        // var_dump( $query );
        if( $query->have_posts() ){
            while( $query->have_posts() ){
                // Iterate through the $query object
                $query->the_post();
                /** Each custom post type can be accessed through the global $post variable here. */ 
                $count++;
                // echo '<p>------------------------------</p>';
                self::$CUSTOM_LIST_ITEMS[] = $post;// OK
                // $this->localDebugger->write_log_general( $post );
            }

            wp_reset_postdata();
        }// $query->have_posts()       
        

        return $query;
    }//get_All_Post_Item

}//BaseController