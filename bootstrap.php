<?php if ( ! defined( 'ABSPATH' ) ) exit;

/*
 * Plugin Name: Example Plugin
 * Version: 1.0.0
 * Description: An example plugin.
 * Author: Kyle B. Johnson
 * Author URI: http://kylebjohnson.me
 * Text Domain: kbj-example
 */

require_once 'src/plugin.php';

function KBJ_Example()
{
    return KBJ_Example_Plugin::instance( __FILE__, __FILE__ );
}

KBJ_Example();

register_uninstall_hook(  __FILE__, array( 'KBJ_Example_Plugin', 'uninstall'  ) );
register_activation_hook( __FILE__, array( 'KBJ_Example_Plugin', 'activation' ) );