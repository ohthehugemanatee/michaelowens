<?php
/**
 * Plugin Name: WordPress Font Customizer
 * Plugin URI: http://www.themesandco.com/extension/wordpress-font-customizer
 * Description: Make beautiful Google font combinations and apply awesome CSS3 effects to any text of your website. Preview everything right from the WordPress customizer before publishing live. Cross browser compatible, fast and easy, the WordPress Font Customizer is the ultimate tool for typography lovers.
 * Version: 2.0.10
 * Author: ThemesandCo
 * Author URI: http://themesandco.com
 * License: GPL2+
 */

/**
* Fires the plugin
* @author Nicolas GUILLAUME
* @since 1.0
*/
if ( ! class_exists( 'TC_wfc' ) ) :
class TC_wfc {
      //Access any method or var of the class with classname::$instance -> var or method():
      static $instance;
      public $version;
      public $plug_name;
      public $plug_file;
      public $plug_version;
      public $plug_prefix;
      public $plug_lang;
      public $tc_default_selector_list;
      public static $theme_name;
      public $tc_property_list;
      //public $tc_selector_list;
      public $tc_skin_colors;
      public $setting_prefix = 'tc_font_customizer_plug';
      public $is_customizing;

      function __construct () {
            self::$instance =& $this;

            /* LICENSE AND UPDATES */
            // the name of your product. This should match the download name in EDD exactly
            $this -> plug_name    = 'WordPress Font Customizer';
            $this -> plug_file    = __FILE__; //main plugin root file.
            $this -> plug_prefix  = 'font_customizer';
            $this -> plug_version = '2.0.10';
            $this -> plug_lang    = did_action('plugins_loaded') ? 'customizr' : 'tc_font_customizer';

            //define the plug option key
            $this -> plug_option_prefix     = did_action('plugins_loaded') ? 'tc_pro_wfc' : 'tc_wfc';

            //Customizr Skin Colors
            $this -> tc_skin_colors = array(//color , color-hover
                  'blue.css'        =>  array('#08c', '#005580'),//blue
                  'green.css'       =>  array('#9db668', '#768D44'),//green
                  'yellow.css'      =>  array('#e9a825','#B07B12'),//yellow
                  'orange.css'      =>  array('#F78C40', '#E16309'),//orange
                  'purple.css'      =>  array('#e67fb9', '#DA3F96'),//purple
                  'red.css'         =>  array('#e10707','#970505'),//red
                  'grey.css'        =>  array('#5A5A5A','#343434'),//gray
                  'black.css'       =>  array('#000','#000'),//black
            );

            //gets the theme name (or parent if child)
            $tc_theme                     = wp_get_theme();
            self::$theme_name             = $tc_theme -> parent() ? $tc_theme -> parent() -> Name : $tc_theme-> Name;
            self::$theme_name             = sanitize_file_name( strtolower(self::$theme_name) );

            //check if theme is customizr pro and plugin mode (did_action not triggered yet)
            if ( 'customizr-pro' == self::$theme_name && ! did_action('plugins_loaded') ) {
              add_action( 'admin_notices', array( $this , 'customizr_pro_admin_notice' ) );
              return;
            }

            //USEFUL CONSTANTS
            if ( ! defined( 'TC_WFC_DIR_NAME' ) )      { define( 'TC_WFC_DIR_NAME' , basename( dirname( __FILE__ ) ) ); }
            if ( ! defined( 'TC_BASE_URL' ) ) {
              //plugin context
              if ( ! defined( 'TC_WFC_BASE_URL' ) ) { define( 'TC_WFC_BASE_URL' , plugins_url( TC_WFC_DIR_NAME ) ); }
            } else {
              //addon context
              if ( ! defined( 'TC_WFC_BASE_URL' ) ) { define( 'TC_WFC_BASE_URL' , sprintf('%s/%s' , TC_BASE_URL . 'addons' , basename( dirname( __FILE__ ) ) ) ); }
            }


            $_activation_classes = array(
                  'TC_activation_key'             => array('/back/classes/activation/class_activation_key.php', array(  $this -> plug_name , $this -> plug_prefix , $this -> plug_version )),
                  'TC_plug_updater'               => array('/back/classes/updates/class_plug_updater.php'),
                  'TC_check_updates'              => array('/back/classes/updates/class_check_updates.php', array(  $this -> plug_name , $this -> plug_prefix , $this -> plug_version, $this -> plug_file ))
            );

            $_plug_core_classes = array(
                  //the admin notices
                  //'TC_wfc_admin_notices'   => array('/back/classes/class_font_customizer_admin_notices.php', array( $this -> plug_name , $this -> plug_prefix )),
                  'TC_utils_wfc'                  => array('/utils/classes/class_utils_wfc.php'),
                  'TC_admin_font_customizer'      => array('/back/classes/class_admin_font_customizer.php'),
                  'TC_back_system_info'           => array('/back/classes/class_back_system_info.php'),
                  'TC_front_font_customizer'      => array('/front/classes/class_front_font_customizer.php'),
                  'TC_dyn_style'                  => array('/front/classes/class_dyn_style.php'),
            );//end of plug_classes array

            $plug_classes       =  did_action('plugins_loaded') ? $_plug_core_classes : array_merge($_activation_classes , $_plug_core_classes);

            //checks if is customizing : two context, admin and front (preview frame)
            $this -> is_customizing = $this -> tc_is_customizing();



            //loads and instanciates the plugin classes
            foreach ($plug_classes as $name => $params) {
                  //don't load admin classes if not admin && not customizing
                  if ( is_admin() && ! $this -> is_customizing ) {
                        if ( false != strpos($params[0], 'front') )
                              continue;
                  }
                  if ( ! is_admin() && ! $this -> is_customizing ) {
                        if ( false != strpos($params[0], 'back') )
                              continue;
                  }

                  if( !class_exists( $name ) )
                      require_once ( dirname( __FILE__ ) . $params[0] );

                  $args = isset( $params[1] ) ? $params[1] : null;
                  if ( $name !=  'TC_plug_updater' )
                      new $name( $args );
            }

            //adds plugin text domain
            add_action( 'plugins_loaded'                    , array( $this , 'tc_plugin_lang' ) );
            $theme_name = self::$theme_name;

            //adds custom selectors to theme defaults
            add_filter( "tc_default_selectors_{$theme_name}", array( $this , 'tc_add_customs_to_selector_list' ) );

            //add / register the following actions only in plugin context
            if ( ! did_action('plugins_loaded') ) {
              //on theme switch
              add_action( 'after_switch_theme'                , array( $this , 'tc_update_saved_options' ) );

              //activation : delete the setting option
              register_activation_hook( __FILE__              , array( __CLASS__ , 'tc_wfc_clean_settings' ) );
              //writes versions
              register_activation_hook( __FILE__              , array( __CLASS__ , 'tc_write_versions' ) );
              register_deactivation_hook( __FILE__            , array( __CLASS__ , 'tc_wfc_clean_settings' ) );

              //uninstall : clean database options
              register_uninstall_hook( __FILE__               , array( __CLASS__ , 'tc_wfc_clean_db' ) );

              //check if Font Customizer WP.org is already install and enabled
              register_activation_hook( __FILE__              , array( __CLASS__   , 'tc_wfc_abort_if_font_customizer_enabled' ) );
            }
      }//end of construct



      /**
      * Returns a boolean on the customizer's state
      *
      */
      function tc_is_customizing() {
            //checks if is customizing : two contexts, admin and front (preview frame)
            global $pagenow;
            $is_customizing = false;
            if ( is_admin() && isset( $pagenow ) && 'customize.php' == $pagenow ) {
            $is_customizing = true;
            } else if ( ! is_admin() && isset($_REQUEST['wp_customize']) ) {
            $is_customizing = true;
            }
            return $is_customizing;
      }



      //declares the plugin translation domain
      function tc_plugin_lang() {
            load_plugin_textdomain( $this -> plug_lang , false, basename( dirname( __FILE__ ) ) . '/lang' );
      }



      function tc_get_property_list() {
            //Default property list
            $tc_selector_properties     = array(
                        'zone'            => null,
                        'selector'        => null,
                        'not'             => null,
                        'subset'          => null,
                        'font-family'     => 'Helvetica Neue, Helvetica, Arial, sans-serif',
                        'font-weight'     => 'normal',
                        'font-style'      => null,
                        'color'           => 'main',
                        'color-hover'     => 'main',
                        'font-size'       => "14px",
                        'line-height'     => "20px",
                        'text-align'      => 'inherit',
                        'text-decoration' => 'none',
                        'text-transform'  => 'none',
                        'letter-spacing'  => 0,
                        'static-effect'   => 'none',
                        'icon'            => false,
                        'important'       => false,
                        'title'           => false //used for custom selectors
            );
            return apply_filters('tc_selector_properties' , $tc_selector_properties);
      }



      function tc_add_customs_to_selector_list( $selectors ) {
            $theme_name   = self::$theme_name;
            $_opt_prefix  = TC_wfc::$instance -> plug_option_prefix;
            //@todo performance ?
            //first check if option exists and get it, else create/update option
            if ( ! get_option("{$_opt_prefix}_customs_{$theme_name}" ) )
                  return $selectors;

            $customs = get_option("{$_opt_prefix}_customs_{$theme_name}");
            return ( is_array($customs) && !empty($customs) ) ? apply_filters( "tc_all_selectors_{$theme_name}" , array_merge( $selectors , $customs ) ) : $selectors;
      }




      function _clean_selector_css( $_to_return ) {
            if ( ! is_array($_to_return) ) {
                  $_to_return = html_entity_decode($_to_return);
            }
            else {
                  foreach ( $_to_return as $selector => $data ) {
                        $_to_return[$selector]['selector'] = html_entity_decode($_to_return[$selector]['selector']);
                  }
            }
            return $_to_return;
      }



      function tc_get_custom_selector_list() {
            $theme_name       = self::$theme_name;
            $_opt_prefix      = TC_wfc::$instance -> plug_option_prefix;
            $_to_return       = get_option("{$_opt_prefix}_customs_{$theme_name}");
            $_to_return       = $this -> _clean_selector_css($_to_return);
            return $_to_return;
      }



      function tc_get_selector_list() {
            $theme_name       = self::$theme_name;
            $path             = dirname( __FILE__).'/sets/';
            //first check if option exists and get it, else create/update option
            if ( get_option("tc_font_customizer_selectors_{$theme_name}" ) && ! isset( $_GET['wfc-refresh-selector'] ) &&  1 == get_transient('wfc_refresh_selectors') ) {
                  //html_entity_decode for selector => fixes characters (unrecognized expression) issue in javascript
                  $_to_return  = apply_filters( "tc_default_selectors_{$theme_name}" , get_option("tc_font_customizer_selectors_{$theme_name}" ) );
                  $_to_return  = $this -> _clean_selector_css($_to_return);
                  return $_to_return;
            }

            $default_selector_settings       = file_exists("{$path}{$theme_name}.json") ? @file_get_contents( "{$path}{$theme_name}.json" ) : @file_get_contents( "{$path}default.json" );
            if ( $default_selector_settings === false ) {
                  $default_selector_settings = ! wp_remote_fopen( sprintf( "%s/sets/{$theme_name}.json" , TC_WFC_BASE_URL ) ) ? wp_remote_fopen( sprintf( "%s/sets/default.json" , TC_WFC_BASE_URL ) ) : wp_remote_fopen( sprintf( "%s/sets/{$theme_name}.json" , TC_WFC_BASE_URL ) );
            }

            $default_selector_settings    = json_decode( $default_selector_settings , true );
            $default_selector_settings    = isset($default_selector_settings['default']) ? $default_selector_settings['default'] : $default_selector_settings;

            $property_list                = $this -> tc_get_property_list();
            $property_list_keys           = array_keys($property_list);

            $selector_list = array();
            foreach ($default_selector_settings as $sel => $sets) {
                  foreach ($sets as $key => $value) {
                        $prop                           = $property_list_keys[$key];
                        switch ($prop) {
                              case 'color-hover':
                                    if ( 0 === $value )
                                          continue;
                                    //if color-hover set to 1 then it is the main color, else there's a custom value
                                    $selector_list[$sel][$prop]    = ( 1 === $value ) ? $property_list[$prop] : $value;
                              break;

                              default:
                                    $selector_list[$sel][$prop]    = ( 0 === $value ) ? $property_list[$prop] : $value;
                              break;
                        }

                 }
            }
            update_option( "tc_font_customizer_selectors_{$theme_name}", $selector_list );
             //html_entity_decode for selector => fixes characters (unrecognized expression) issue in javascript
            $_to_return  = apply_filters("tc_default_selectors_{$theme_name}" , $selector_list);
            $_to_return  = $this -> _clean_selector_css($_to_return);

            //update refresh transient for 24 hours
            set_transient('wfc_refresh_selectors' , 1 , 60*60*24 );

            return $_to_return;
      }


      //merges the default settings with the saved options
      function tc_update_saved_options( $return = false ) {
        $default_options    = $this -> tc_get_selector_list();
        $saved_options      = array( 'settings' => array() , 'bools' => array() );
        $_opt_prefix        = TC_wfc::$instance -> plug_option_prefix;
        foreach( $default_options as $selector => $settings ) {
              //settings
              $set_raw                                    = (array)json_decode(apply_filters( '__get_wfc_option'  , $selector , 'tc_font_customizer_plug' ));
              $saved_options['settings'][$selector]       = array_merge( $set_raw , array_diff_key( $default_options[$selector] , $set_raw ) );
              //html_entity_decode for selector => fixes characters (unrecognized expression) issue in javascript
              $saved_options['settings'][$selector]['selector'] = $this -> _clean_selector_css($saved_options['settings'][$selector]['selector']);

              //bools
              $saved_options['bools'][$selector]          = $set_raw ? true : false;
              $saved_options['bools']['hassavedsets']     = isset($saved_options['bools']['hassavedsets']) ? $saved_options['bools']['hassavedsets'] : false;
              $saved_options['bools']['hassavedsets']     = $saved_options['bools'][$selector] ? true : $saved_options['bools']['hassavedsets'];
        }//end foreach

        update_option("{$_opt_prefix}_saved_options" , $saved_options );

        if ( true == $return )
              return $saved_options;
      }



      function tc_get_saved_option( $selector_in_key = null , $bool = false ) {
            $_opt_prefix  = TC_wfc::$instance -> plug_option_prefix;
            $saved        = array();
            if ( $this -> is_customizing || is_admin() )
                  $saved = $this -> tc_update_saved_options( $return = true );
            else
                  $saved = get_option( "{$_opt_prefix}_saved_options" ) ? get_option("{$_opt_prefix}_saved_options" ) : $this -> tc_update_saved_options( $return = true );

            if ( 'selector_in_key' == $selector_in_key ) {
                  foreach ( $saved['settings'] as $selector => $settings ) {
                        $new_val                            = $saved['settings'][$selector];
                        unset($saved['settings'][$selector]);
                        $new_key                            = $selector.'|'.$settings['selector'];
                        $saved['settings'][$new_key]        = $new_val;
                  }
                  return $saved['settings'];
            }
            if ( true == $bool ) {
                  return $saved['bools'];
            }

            return $saved['settings'];
      }




      function tc_get_raw_option() {
            $saved_options = get_option( 'tc_font_customizer_plug' );
            if ( empty($saved_options) )
                  return;
            foreach( $saved_options as $selector => $settings ) {
                  $saved_options[$selector] = (array)json_decode($saved_options[$selector]);
            }
            return $saved_options;
      }





      //@todo : include custom selector options ?
      public static function tc_wfc_clean_db() {
            $theme_name = self::$theme_name;

            //OPTIONS
            $options = array(
                  "tc_font_customizer_last_modified",
                  "tc_font_customizer_plug",
                  "tc_font_customizer_selectors_{$theme_name}"
            );
            foreach ($options as $value) {
                  delete_option($value);
            }

            //TRANSIENT
            delete_transient('tc_gfonts');
      }


      public static function tc_wfc_clean_settings() {
            $theme_name = self::$theme_name;
            delete_option("tc_font_customizer_selectors_{$theme_name}");
      }

      //write current and previous version => used for system infos
      public static function tc_write_versions(){
            //Gets options
            $plug_options = get_option(TC_wfc::$instance -> plug_option_prefix) ? get_option(TC_wfc::$instance -> plug_option_prefix) : array();
            //Adds Upgraded From Option
            if ( isset($plug_options['tc_plugin_version']) ) {
                  $plug_options['tc_upgraded_from'] = $plug_options['tc_plugin_version'];
            }
            //Sets new version
            $plug_options['tc_plugin_version'] = TC_wfc::$instance -> plug_version;
            //Updates
            update_option( TC_wfc::$instance -> plug_option_prefix , $plug_options );
      }



      public static function tc_wfc_abort_if_font_customizer_enabled() {
            if ( class_exists('TC_font_customizer') )
                  //add_action( 'admin_notices', array(TC_wfc::$instance , 'my_admin_notice' ));
                  wp_die( sprintf('The <strong>Font Customizer</strong> plugin has to be disabled before enabling the WordPress Font Customizer.</br><a href="%1$s">&laquo; Back to plugin\'s page</a>' , admin_url() . 'plugins.php' ) );

      }


      function my_admin_notice() {
          ?>
          <div class="updated">
              <p><?php _e( 'Updated!', 'my-text-domain' ); ?></p>
          </div>
         <?php
      }

      function customizr_pro_admin_notice() {
          ?>
          <div class="error">
              <p>
                <?php
                printf( __( 'The <strong>%s</strong> plugin must be disabled since it is included in this theme. Open the <a href="%s">plugins page</a> to desactivate it.' , $this -> plug_lang ),
                  $this -> plug_name,
                  admin_url('plugins.php')
                  );
                ?>
              </p>
          </div>
          <?php
      }

}//end of class

//Creates a new instance of front and admin
new TC_wfc;

endif;

/**
* The tc__f() function is an extension of WP built-in apply_filters() where the $value param becomes optional.
* It is shorter than the original apply_filters() and only used on already defined filters.
* Can pass up to five variables to the filter callback.
*
* @since TCF 1.0
*/

if( ! function_exists( 'tc__f' )) :
    function tc__f ( $tag , $value = null , $arg_one = null , $arg_two = null , $arg_three = null , $arg_four = null , $arg_five = null) {
       return apply_filters( $tag , $value , $arg_one , $arg_two , $arg_three , $arg_four , $arg_five );
    }
endif;