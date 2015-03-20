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


add_action('__after_footer' , 'set_fp_item_order');
function set_fp_item_order() {
  $my_item_order = array(
    'title',
    'image',
    'text',
    'button',
  );
  ?>
  <script type="text/javascript">
    jQuery(document).ready(function () {
      ! function ($) {
        //prevents js conflicts
        "use strict";
        var my_item_order 	= [<?php echo '"'.implode('","', $my_item_order).'"' ?>],
          $Wrapper 		= '';

        if ( 0 != $('.widget-front' , '#main-wrapper .marketing' ).length ) {
          $Wrapper = $('.widget-front' , '#main-wrapper .marketing' );
        } else if ( 0 != $('.fpc-widget-front' , '#main-wrapper .fpc-marketing' ).length ) {
          //for FPU users
          $Wrapper = $('.fpc-widget-front' , '#main-wrapper .fpc-marketing' );
        } else {
          return;
        }

        $Wrapper.each( function() {
          var o            = [];
          o['title']   = $(this).find('h2');
          o['image']   = $(this).find('.thumb-wrapper');
          o['text']    = $(this).find('p');
          o['button']  = $(this).find('a.btn');
          for (var i = 0; i < my_item_order.length - 1; i++) {
            o[my_item_order[i]].after(o[my_item_order[i+1]]);
          };
        });
      }(window.jQuery)
    });
  </script>
<?php
}