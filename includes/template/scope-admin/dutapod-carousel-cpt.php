<?php 
/** 
 * @Package DevSunsetNew Theme
 * 
 * **/

use Sunsetpro\Helper\PluginDebugHelper as PluginDebugHelper;
use Sunsetpro\Helper\WpFrontend\Carousel\BsSunsetCarouselStandard as BsSunsetCarouselStandard;

global $pluginProperties;

// Target option name in DB: "sunsetpro-default-post-id"
// $targetOptionName = $pluginProperties->dbInfo->content->sunsetCarousel->defaultPostIDOption;
// $targetOptionName = $targetOptionName ?? "sunsetpro-default-post-id";
$targetOptionName = "sunsetpro-default-post-id";
$displayPostID = get_option( $targetOptionName );
 // $displayPostID = 365; // Tieu Vy Miss
const DEFAULT_DEMO_POST_GALLERY_ID = 365; // Top beautiful face -default
$displayPostID = $displayPostID ?? DEFAULT_DEMO_POST_GALLERY_ID;

// $displayPostID = 216; // wine
// $displayPostID = 187; // top beautiful girls 
// $displayPostID = 161; // a lot of photos, especially from external hosts

?>

<h3 class="devsunsetnew-page-title">Sunsetpro Carousel Management page</h3>

<?php settings_errors(); ?>

<p>Use the <strong>shortcode</strong> below to activate the Stcarousel inside a page/post editor</p>
<p>1. Using responsive format (desktop: standard format; mobile: classic format)) :</p>
<code>[sunset_carousel_<?php _e( "< post_ID >" ); ?>]</code>
<p>2. Using standard format only (with thumbnail preview) :</p>
<code>[sunset_carousel_standard_<?php _e( "< post_ID >" ); ?>]</code>
<p>3. Using classic format only (with thumbnail preview) :</p>
<code>[sunset_carousel_classic_<?php _e( "< post_ID >" ); ?>]</code>

<div class="devsunsetnew-outer-container">
     <h4 class="stcarousel-header-container">
          Sunset carousel demo with "Top contemporary Vietnamese angels in my eyes" article
     </h4>
     <!-- 2.1. Alex's Sunset Carousel preview will be displayed here. -->
     <div class="devsunsetnew-stcarousel-preview-container">
          <?php           
               $sunsetCarousel = new BsSunsetCarouselStandard( $displayPostID );

               $sunsetCarousel->outputContentBsCarousel(); // Successfuly got the carousel               
          ?>
           
           <!-- 2.2. Alex's Sunset Carousel preview will be displayed here. -->
          <div class="devsunsetnew-stcarousel-shortcode-info">    
               <div class="shortcode-list-container">
                    <label class="shortcodes-label" for="shortcodes">Select the post gallery to preview with Sunset carousel format</label>
                    <select name="shortcodes" class="shortcode-selector form-select" id="shortcode-selector" 
                            size="1"  arial-label="Select your gallery post format to preview">
                                             
                         <?php  
                              // value - shortcode : "sunset_carousel_standard_<postID>"
                              $shortcodeHTMLFormat = '<option value="%s" data-post-id="%s">%s</option>';

                              $postList = BsSunsetCarouselStandard::getPostList();
                              $shortcodeNameStandardList = BsSunsetCarouselStandard::getShortcodeNameList();    

                              // Mapping standard shortcode to general responsive shortcode 
                              $shortcodeNameStandardList = array_map( 
                                   function($shortcodeName){ 
                                        return str_replace( 'sunset_carousel_standard_', 'sunset_carousel_', $shortcodeName );
                                   }, $shortcodeNameStandardList
                              );                              

                              $maxIndex = sizeof( $postList ) - 1; 

                              $frontendData = array();

                              // Iterate through both relevant post & shortcode List
                              for( $i = 0; $i <= $maxIndex; $i++ ){  
                                   $currentPost = $postList[$i];
                                   $currentScName = $shortcodeNameStandardList[$i];
                                   
                                   $outputItem = sprintf(
                                        $shortcodeHTMLFormat,
                                        $currentScName, $currentPost->ID, $currentPost->post_title
                                   );

                                   // Create frontend data
                                   $frontendData[$i] = array(
                                        'selectedIndex'          => $i,
                                        'selectedPostTitle'      => $currentPost->post_title
                                   );
                                   echo $outputItem;
                                   
                              }// Iterate through both relevant post & shortcode List           
                         ?>
                    </select>               
               </div><!--.shortcode-list-container -->
               <div class="devsunsetnew-stcarousel-meta-info">
                    <h6>Sunset carousel standard preview - meta information </h6>
                    <div class="selected-post-id-container">
                         <label class="stcarousel-id info-label">
                              <b style="white-space:nowrap">Post gallery format's ID : </b>
                         </label>
                         <span class="stcarousel-id info-value"></span>
                    </div><!--.selected-post-id -->
                    <div class="selected-title-container">
                         <label class="stcarousel-title info-label">
                              <b style="white-space:nowrap">Post  title : </b>
                         </label>
                         <span class="stcarousel-title info-value"></span>
                    </div><!--.selected-shortcode-container -->
                    <div class="selected-shortcode-container">
                         <label class="stcarousel-shortcode info-label">
                              <b style="white-space:nowrap">Shortcode </b>(responsive format)<b>:</b>
                         </label>
                         <span class="stcarousel-shortcode info-value"></span>                         
                    </div><!--.selected-shortcode-container -->
                    <?php 
                         $shortcodeDescription = <<<HEREDOCSTR
                         To display the prviewed content in the frontend UI, insert the corresponding shortcode to the frontend editor
                         (i.e : WP classic editor, Gutenberg editor ... or any editor supports shortcode content block)
                         HEREDOCSTR;
                    ?>
                    <small><?php echo $shortcodeDescription; ?></small>
                    <div class="stcarousel-preview-button-container">
                         <button class="btn btn-primary preview-button" 
                                   data-post-id="<?php echo $displayPostID; ?>">
                              Preview Sunset Carousel Standard
                         </button>
                    </div><!--.stcarousel-preview-button-container -->
               </div><!-- .devsunsetnew-stcarousel-meta-info-->
          </div><!-- .devsunsetnew-stcarousel-shortcode-info-->               
     </div><!--devsunsetnew-stcarousel-preview-container -->
     


</div><!--div.devsunsetnew-outer-container -->

<pre>----------- Sunset Carousel custom post type management page ----------- </pre>
<pre style="text-align:center;"> Developed by Leon Nguyen (sonnh2109@gmail.com) </pre>

