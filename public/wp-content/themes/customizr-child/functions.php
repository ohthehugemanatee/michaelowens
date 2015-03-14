<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
      wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

      wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
      );

}

add_filter('tc_slider_display', 'do_my_shortcode');
function do_my_shortcode($html){
      return do_shortcode(html_entity_decode($html));
}

/**
 * Add a shortcode for sneaking HTML past the content filters, per
 * https://wordpress.org/support/topic/adding-shortcode-to-a-sliders-text?replies=9
 */
add_shortcode('htmlify', 'do_html');
function do_html($attr, $content){
      return str_replace(array('{','}'), array('<','>'), $content);
}
