<?php //Header
/*
Plugin Name: WP roundabout
Plugin URI: 
Description: This plugin creates a round about slider based on jQuery Roundabout plugin
Author: Abbas Suterwala
Version: 1.0
Author URI: http://www.abbassuterwala.com 
*/

// This is the function which displays the round about slider for a category
// ----------------------------------------------------------------------------------
 function wproundabout($cat, $noOfpost)
 {
	query_posts('post_type=post&order=desc&cat=' . $cat . '&posts_per_page= ' . $noOfpost . '');
	if ( have_posts() ) : ?>
	
	<ul id="wproundabout" >

	<?php while ( have_posts() ) : the_post(); ?>
		<li> <?php the_content(); ?></li>
	<?php endwhile; ?>
	</ul>
	<script type="text/javascript">
		// <[CDATA[
		jQuery(document).ready(function() {
			jQuery('#wproundabout').roundabout();
		});
		// ]]>
	</script>
	 <?php  else:   endif; 
	 wp_reset_query();
 }

// ----------------------------------------------------------------------------------
//Add the hook to load the required scripts
// ----------------------------------------------------------------------------------
add_action ('init', 'wproundabout_scripts');

// ----------------------------------------------------------------------------------
//The function which loads the scripts . This function in hooked in the wordpress init hook
// ----------------------------------------------------------------------------------
function wproundabout_scripts() 
{

	wp_enqueue_script('wproundabout', WP_PLUGIN_URL . '/wp-roundabout/js/jquery.roundabout.min.js', array('jquery'));
	wp_enqueue_style('wproundabout', WP_PLUGIN_URL . '/wp-roundabout/css/roundabout.css');

}

// ----------------------------------------------------------------------------------
//The function is used to add shortcode in our WordPress plugin
// ----------------------------------------------------------------------------------
function wproundabout_shortcode($atts) {
	extract(shortcode_atts(array(
		'category' => '1',
		'number' => '5',
	), $atts));

	ob_start();
	wproundabout($category , $number );
	$out1 = ob_get_contents();
	ob_end_clean();

	return $out1;
}
add_shortcode('wproundabout', 'wproundabout_shortcode');

 
?>
