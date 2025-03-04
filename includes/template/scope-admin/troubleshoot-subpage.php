<?php

use DutapodCompanion\Includes\Controller\ScopeAdmin\Page\SubpageTroubleshoot as SubpageTroubleshoot;
use DutapodCompanion\Includes\Base\Settings\Post\ImagesManager as ImagesManager;

$postID = 1080; // test page post ID

?>

<h1>Troubleshoot page</h1>
<p>This page is reserved to display some debug information during developing this plugin - at WP admin setting pages scope. </p>
<p> property of the SubpageTroubleshoot can be accessed via the $pageInstance PHP variable </p>
<p>-------------------------------------------------------------------------------------------------------------------------</p>

<p>-------------------------------------------------------------------------------------------------------------------------</p>

<?php $imgList = ImagesManager::get_Images_In_Post_Content( $postID ); ?>

<?php 

// global $post;

$postInstance = get_post( $postID );

$matchedResult = [];
// Valid matched status. Found 3 item
$matchedStatus = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $postInstance->post_content, $matchedResult);


// $attachedImgs = get_attached_media( 'image', $postID );

// var_dump( $matchedResult[1] ); 
var_dump( $imgList );

?>

