<?php



//require_once "components/header/wi_homepage_header.php";


function wi_render_hero_markup(){
	echo "<section class='hero-area'>";
	echo	"<article>";
	echo		"<h1>". get_theme_mod("wi_hero_title") ."</h1>";
	echo		"<p>". get_theme_mod("wi_hero_text") ."</p>";
	echo 		"<button class='hero-btn'>Get Started</button>";
	echo	"</article>";
	echo "</section>";
}
add_action( 'wi_content_area', 'wi_render_hero_markup' );


function wi_folklore_markup(){

	$display = '<section class="wi-folklore">';
	$display = '<h1>The Lore of New Orleans</h1>';
  // 1) get the home page post:
  $frontpage_id = (int)get_option( 'page_on_front' );
  $home_page = get_post($frontpage_id);

  // 2) filter the gallery out of home page:
  $blocks = parse_blocks($home_page->post_content);
	$image_ids = $blocks[0]['attrs']['ids'];

	//* 3) for each image in the gallery add extra html markup
  //* 4) create the template for the light box
	$display .= '<div class="wi-gallery">';
	$lightbox = "";
	$counter = 1;
	foreach($image_ids as $image){
		$display .= "<article class='wi-gallery-img' data-featherlight='#fl".(string) $counter ."'>";
		$display .=  wp_get_attachment_image($image);
		$display .= "</article>";

		$lightbox .= "<div id='fl".(string) $counter ."' class='lightbox'>";
		$lightbox .= wp_get_attachment_image($image);
		$lightbox .= "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>";
		$lightbox .= " <div class='lightbox-btn-container'> ";
		$lightbox .= " <button>View Lore</button> ";
		$lightbox .= " <button>View Product</button> ";
		$lightbox .= " </div> ";
		$lightbox .= " </div> ";
		$counter++;
	}
	 $display .= '</div></section>'; //closing div tags for class: wi-folklore and wi-gallery

   //* 5) render the gallery
	 echo $display;
	 echo $lightbox;
}
add_action('wi_content_area', 'wi_folklore_markup');









// Remove 'site-inner' from structural wrap
add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets', 'footer' ) );
/**
 * Add attributes for site-inner element, since we're removing 'content'.
 *
 * @param array $attributes Existing attributes.
 * @return array Amended attributes.
 */
function wi_site_inner_attr( $attributes ) {
	// Add a class of 'full' for styling this .site-inner differently
	$attributes['class'] .= ' full';

	// Add the attributes from .entry, since this replaces the main entry
	$attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );
	return $attributes;
}
add_filter( 'genesis_attr_site-inner', 'wi_site_inner_attr' );
// Build the page
get_header();
do_action( 'wi_content_area' );
get_footer();
