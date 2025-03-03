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
        self::$POST_FORMATS = [ 'standard', 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ];

        self::$ACTIVE_POST_FORMATS = [ 'aside', 'gallery',  'image', 'status', 'video', 'audio' ];
    }//set_Additional_Local_Properties

    /** 3. Main operational function */
    /** 3.1. register method */
    public function register(){
        // 1. Add active post format
        // add_theme_support( 'post-formats', self::$POST_FORMATS );
    }//register

}//PostSettings class controller