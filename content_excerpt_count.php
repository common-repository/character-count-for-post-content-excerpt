<?php

/*
Plugin Name: Character Count for Post Content & Excerpt
Plugin URI: https://github.com/petermolnar/content_excerpt_count
Description: Simple jQuery Character Count for Post Content & Excerpt
Author: Peter Molnar
Version: 0.1
Author URI: https://petermolnar.eu
*/

class content_excerpt_count {

	public function __construct () {
		/* excerpt letter counter */
		add_action( 'admin_head-post.php', array( &$this, 'count_js'));
		add_action( 'admin_head-post-new.php', array( &$this, 'count_js'));
	}

	/**
	 * character counter for text content field & excerpt field
	*/
	public function count_js(){
		wp_enqueue_script( 'jquery' );

		echo '<script>jQuery(document).ready(function(){

			if( jQuery("#excerpt").length ) {
				jQuery("#postexcerpt .handlediv").after("<input type=\'text\' value=\'0\' maxlength=\'3\' size=\'3\' id=\'excerpt_counter\' readonly=\'\' style=\'background:#fff; position:absolute;top:0.2em;right:2em; color:#666;\'>");
				jQuery("#excerpt_counter").val(jQuery("#excerpt").val().length);
				jQuery("#excerpt").keyup( function() {
					jQuery("#excerpt_counter").val(jQuery("#excerpt").val().length);
				});
			}

			if( jQuery("#wp-word-count").length ) {
				jQuery("#wp-word-count").after("<td id=\'wp-character-count\'>'. __( 'Character count:' ) .'<span class=\'character-count\'>0</span></td>");
			}

			if ( jQuery("#content_ifr") ) {

				$update = function() {
					tinyMCE.triggerSave();
					jQuery("#wp-character-count .character-count").html(jQuery("#content").val().length);
				}

				setInterval(function() { $update(); }, 1000);

			}
			else {
				jQuery("#wp-character-count .character-count").html(jQuery("#wp-content-wrap .wp-editor-area").val().length);

				jQuery("#wp-content-wrap .wp-editor-area").keyup( function() {
					jQuery("#wp-character-count .character-count").html(jQuery("#wp-content-wrap .wp-editor-area").val().length);
				});
			}

		});</script>';
	}
}

if ( !isset( $content_excerpt_count ) || empty ( $content_excerpt_count ) ) {
	$content_excerpt_count = new content_excerpt_count();
}

?>
