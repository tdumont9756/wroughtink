<?php
/**
 * Wrought Ink Custom Theme
 *
 * @author  Travis Dumont
 * @license GPL-2.0-or-later
 *
 * Enable Customizer edits for the hero section
*/
//echo print_r(wi_list_pages());
add_action("customize_register", "wi_hero_customizer_controles");
function wi_hero_customizer_controles($wp_customize){

  //@param1: tag for the section,
  //@param2:  settings
  $wp_customize->add_section('wi_hero_section', array(
    'title' => esc_html__("Hero Section", 'wroughtink' ),
    'priority' => 150
  ));

  // Hero Title Section
  //@param1:  tag that is entered into the database.  This is what we reference to edit
  //@param2:  settins array
  $wp_customize->add_setting('wi_hero_title', array(
    'default' => "Dredging up Nola's Darkside",
    'sanitize_callback' => 'wp_filter_nohtml_kses'
  ));

  $wp_customize->add_control(new WP_Customize_Control(
    $wp_customize,
    'wi_hero_title',
    array(
      'label' => esc_html__("Headline", "wroughtink"),
      'section' => "wi_hero_section",
      'settings' => "wi_hero_title",
      'type' => "text"
    )
  ));

  // Hero Smaller Print
  $wp_customize->add_setting('wi_hero_text', array(
    'default' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
    'sanitize_callback' => 'wp_filter_nohtml_kses'
  ));

  $wp_customize->add_control(new WP_Customize_Control(
    $wp_customize,
    'wi_hero_text',
    array(
      'label' => esc_html__("Small Text", "wroughtink"),
      'section' => "wi_hero_section",
      'settings' => "wi_hero_text",
      'type' => "text"
    )
  ));


  // Hero CTA ButtonText
  $wp_customize->add_setting('wi_hero_text', array(
    'default' => "Shop Now",
    'sanitize_callback' => 'wp_filter_nohtml_kses'
  ));

  $wp_customize->add_control(new WP_Customize_Control(
    $wp_customize,
    'wi_hero_text',
    array(
      'label' => esc_html__("Small Text", "wroughtink"),
      'section' => "wi_hero_section",
      'settings' => "wi_hero_text",
      'type' => "text"
    )
  ));
}






function wi_list_pages( $args = '' ) {
    $defaults = array(
        'depth'        => 0,
        'show_date'    => '',
        'date_format'  => get_option( 'date_format' ),
        'child_of'     => 0,
        'exclude'      => '',
        'title_li'     => __( 'Pages' ),
        'echo'         => 1,
        'authors'      => '',
        'sort_column'  => 'menu_order, post_title',
        'link_before'  => '',
        'link_after'   => '',
        'item_spacing' => 'preserve',
        'walker'       => '',
    );

    $r = wp_parse_args( $args, $defaults );

    if ( ! in_array( $r['item_spacing'], array( 'preserve', 'discard' ), true ) ) {
        // invalid value, fall back to default.
        $r['item_spacing'] = $defaults['item_spacing'];
    }

    $output       = '';
    $current_page = 0;

    // sanitize, mostly to keep spaces out
    $r['exclude'] = preg_replace( '/[^0-9,]/', '', $r['exclude'] );

    // Allow plugins to filter an array of excluded pages (but don't put a nullstring into the array)
    $exclude_array = ( $r['exclude'] ) ? explode( ',', $r['exclude'] ) : array();

    /**
     * Filters the array of pages to exclude from the pages list.
     *
     * @since 2.1.0
     *
     * @param array $exclude_array An array of page IDs to exclude.
     */
    $r['exclude'] = implode( ',', apply_filters( 'wp_list_pages_excludes', $exclude_array ) );

    // Query pages.
    $r['hierarchical'] = 0;
    $pages             = get_pages( $r );

    return $pages;
  }
