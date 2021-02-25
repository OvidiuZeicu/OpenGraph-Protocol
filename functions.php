<?php //This won't be needed in your child theme

 function doctype_opengraph($output) {
	return $output . '
	xmlns:og="http://opengraphprotocol.org/schema/"
	xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'doctype_opengraph');

function fb_opengraph() {
	global $post;
	
	if(is_single()) {
		if(has_post_thumbnail($post->ID)) {
			$img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'medium');
				// 'thumbnail' - default 150px x 150px max
				// 'medium' - default 300px x 300px max
				// 'medium_large' - default 768px x 0(which no height limit) max (since WP version 4.4)
				// 'large' - default 640px x 640px max
				// 'full' - original image resolution (unmodified)
			$img_src = $img_src[0];
		} else {
			$img_src = get_stylesheet_directory_uri() . '/site-image.jpg'; // a fallback image if the page doesn't contain images
		}
		if($excerpt = $post->post_excerpt) {
			$excerpt = strip_tags($post->post_excerpt);
			$excerpt = str_replace("", "'", $excerpt);
		} else {
			$excerpt = get_bloginfo('description');
		}
?>
	<meta property="og:title" content="<?php echo the_title(); ?>"/>
	<meta property="og:description" content="<?php echo $excerpt; ?>"/>
	<meta property="og:type" content="article"/>
	<meta property="og:url" content="<?php echo the_permalink(); ?>"/>
	<meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
	<meta property="og:image" content="<?php echo $img_src; ?>"/>
<?php
	} else {
		return;
	}
}
add_action('wp_head', 'fb_opengraph', 5);
