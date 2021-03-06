<?php
/**
* Check for theme updates
* @author Nicolas GUILLAUME
* @since 1.0
*/
class TC_theme_check_updates {
    static $instance;
    public $theme_name;
    public $theme_version;
    public $theme_prefix;
    public $theme_lang;

    function __construct ( $args ) {

        self::$instance =& $this;

        //extract properties from args
        list( $this -> theme_name , $this -> theme_prefix , $this -> theme_version ) = $args;

        // this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
        if( ! defined( 'TC_THEME_URL' ) ) { define( 'TC_THEME_URL' , 'http://themesandco.com' ); }

        //loads the updater
        add_action( 'admin_init'                       , array( $this , 'tc_theme_update_check' ) );

    }//end of construct

    function tc_theme_update_check() {
        // retrieve our license key from the DB
        $_license_key = trim( get_option( 'tc_' . $this -> theme_prefix . '_license_key' ) );
        // setup the updater
        $edd_updater = new TC_theme_updater( array(
                'remote_api_url'  => TC_THEME_URL,  // Our store URL that is running EDD
                'version'   => $this -> theme_version,               // current version number
                'license'   => $_license_key,            // license key (used get_option above to retrieve from DB)
                'item_name' => $this -> theme_name,     // name of this plugin
                'author'    => 'Themes and Co'  // author of this plugin
            )
        );

    }

}//end of class