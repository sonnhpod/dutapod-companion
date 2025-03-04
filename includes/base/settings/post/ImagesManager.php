<?php
/*
 * @package dutapod-companion
 * @version 1.0.1
 * This is unused class because Composer autoloader did all things
 */

namespace DutapodCompanion\Includes\Base\Settings\Post;

use DutapodCompanion\Includes\Base\BaseController as BaseController;


class ImagesManager extends BaseController{
    /** 1. Variable declaration */
    const IMAGE_TAG_PATTERN = '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i';

    /** 2. Constructor*/
    /** 2.1. Main constructor */
    public function __construct(){
        // 1. Initialize BaseController properties and method
        parent::__construct();

        // 2. setup local variables
        // $this->set_Additional_Local_Properties();
    }//__construct PLUGIN_NAME

    public static function get_Attached_Images( int $postID ){
        $attachedImgs = get_attached_media( 'image', $postID );

        // Use debug variable in static method
        // $this->localDebugger->write_log_general( $attachedImgs );

        $attachedImgsList = [];

        // If attachedImgs is not empty / valid images attachment object
        if( ! empty( $attachedImgs ) ){
            foreach( $attachedImgs as $item ){
                $attachedImgsList[] = $item->guid;
            }
        }

        return $attachedImgsList; 
    }//get_Images

    public static function get_Images_In_Post_Content( int $postID ){
        $postInstance = get_post( $postID );

        if( is_null( $postInstance ) ) return [];

        $matchedResult = [];
        // Valid matched status. Found 3 item
        $matchedStatus = preg_match_all( self::IMAGE_TAG_PATTERN, $postInstance->post_content, $matchedResult );
       
        if( ! $matchedStatus ) return [];

         /**
         * 1. $matchedResult[0]: a list of HTML image tags
         * 2. $matchedResult[1]: a list of image URL embedded in the $postInstance->post_content
        */
        if( $matchedStatus > 0 ) {
            return $matchedResult[1];
        }

        return [];
    }//get_Images_In_Post_Content

    /** 3. Main operational function */
    /** 3.1. register method */
    public function register(){
        // 1. Add active post format
        // add_action( 'after_setup_theme', [ $this, 'activate_Plugin_Post_Formats' ] );
    }//register

}//ImagesManager