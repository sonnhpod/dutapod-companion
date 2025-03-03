<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace DutapodCompanion\Includes\Base\Settings\Post;

use DutapodCompanion\Includes\Base\BaseController as BaseController;

class PostSettings extends BaseController{
    /** 1. Variables definitions */
    public static array $POST_FORMATS;
    public static array $ACTIVE_POST_FORMATS;
        
    /** 2. Constructor*/
    /** 2.1. Main constructor */
    public function __construct(){
        // 1. Initialize BaseController properties and method
        parent::__construct();

        // 2. setup local variables
        $this->set_Additional_Local_Properties();
    }//__construct PLUGIN_NAME

    /** 2.2. Helper functions for the constructor */  
    public function set_Additional_Local_Properties(): void {
        // 1. Post formast
        /** 1.1. Available supported post format
         * https://developer.wordpress.org/advanced-administration/wordpress/post-formats/ 
         *  */ 
        self::$POST_FORMATS = [ 'standard', 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ];

        // 1.2. Active post format
        self::$ACTIVE_POST_FORMATS = [ 'standard', 'aside', 'gallery', 'image', 'video', 'audio' ];
    }//set_Additional_Local_Properties

    /** 3. Main operational function */
    /** 3.1. register method */
    public function register(){
        // 1. Add active post format
        add_action( 'after_setup_theme', [ $this, 'activate_Plugin_Post_Formats' ] );
    }//register

    public function activate_Plugin_Post_Formats(){
        global $_wp_theme_features;// A lot of options

        // $this->localDebugger->write_log_general( $_wp_theme_features );

        add_theme_support( 'post-formats', self::$ACTIVE_POST_FORMATS );
    }//activate_Plugin_Post_Format

}//PostSettings class controller