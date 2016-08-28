<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class KBJ_Example_Plugin
{
    private function __construct()
    {
        add_action( 'admin_notices', array( $this, 'admin_notice' ) );
    }

    public function admin_notice()
    {
        $class = 'notice notice-success is-dismissible';
        $message = __( 'The Example Plugin is active!', 'kbj-example' );
        self::template( 'admin-notice.html.php', compact( 'class', 'message' ) );
    }

    /*
    |--------------------------------------------------------------------------
    | Internal API
    |--------------------------------------------------------------------------
    */

    public function __call( $name, $arguments )
    {
        return self::$api->$name( $arguments );
    }

    /*
    |--------------------------------------------------------------------------
    | Plugin Instance
    |--------------------------------------------------------------------------
    */

    /** Plugin Instance */
    private static $instance;

    /** Plugin Directory */
    private static $dir = '';

    /** Plugin URL */
    private static $url = '';

    /** Plugin API */
    public static $api;

    public static function instance( $dir = __FILE__, $url = __FILE__ )
    {
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof KBJ_Example_Plugin ) ) {
            spl_autoload_register( array( 'KBJ_Example_Plugin', 'autoloader' ) );
            self::$instance = new KBJ_Example_Plugin();
            self::$dir = plugin_dir_path( $dir );
            self::$url = plugin_dir_url( $url );
            self::$api = new KBJ_Example_API();
        }
        return self::$instance;
    }

    public static function dir( $path = '' )
    {
        return trailingslashit( self::$dir ) . $path;
    }

    public static function url( $url = '' )
    {
        return trailingslashit( self::$url ) . $url;
    }

    public static function activation( $network_wide )
    {
        // Do activation stuff here.
    }

    public static function uninstall()
    {
        // Do uninstall stuff here.
    }

    public static function autoloader( $class_name )
    {
        if( class_exists( $class_name ) ) return;

        $prefix = 'KBJ_Example_';
        if (false !== strpos($class_name, $prefix)) {
            $class_name = str_replace( $prefix, '', $class_name );
            $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
            $class_file = strtolower( str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php' );
            if (file_exists($classes_dir . $class_file)) {
                require_once $classes_dir . $class_file;
            }
        }
    }

    public static function template( $file_name = '', array $data = array(), $return = FALSE )
    {
        if( ! $file_name ) return FALSE;

        extract( $data );

        $path = self::dir( 'src/includes/templates/' . $file_name );

        if( ! file_exists( $path ) ) return FALSE;

        if( $return ) return file_get_contents( $path );

        include $path;
    }
}