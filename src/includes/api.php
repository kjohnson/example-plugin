<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class KBJ_Example_API
{
    public function __construct()
    {
    }

    public function __call( $name, $arguments )
    {
        throw new Exception( __( 'API Method ' . $name . ' is undefined.', 'kbj-example' ) );
    }

    public function foo()
    {
        return 'FOO';
    }

    /** Plugin Instance */
    private static $instance;

    public static function instance()
    {
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof KBJ_Example_API ) ) {
            self::$instance = new KBJ_Example_API();
        }
        return self::$instance;
    }
}