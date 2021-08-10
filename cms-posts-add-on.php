<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.cmsminds.com
 * @since             1.0.0
 * @package           Cms_Posts_Add_On
 *
 * @wordpress-plugin
 * Plugin Name:       Cms Posts Add-on
 * Plugin URI:        https://github.com/ankit-cms/cms-posts-add-on
 * Description:       The plugin provides the extra functionality to WordPress default post type post. Like Export all posts on single button click and store it in the csv file.
 * Version:           1.0.0
 * Author:            Ankit Jani
 * Author URI:        https://www.cmsminds.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cms-posts-add-on
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CMS_POSTS_ADD_ON_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cms-posts-add-on-activator.php
 */
function activate_cms_posts_add_on() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cms-posts-add-on-activator.php';
	Cms_Posts_Add_On_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cms-posts-add-on-deactivator.php
 */
function deactivate_cms_posts_add_on() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cms-posts-add-on-deactivator.php';
	Cms_Posts_Add_On_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cms_posts_add_on' );
register_deactivation_hook( __FILE__, 'deactivate_cms_posts_add_on' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cms-posts-add-on.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cms_posts_add_on() {

	$plugin = new Cms_Posts_Add_On();
	$plugin->run();

}
run_cms_posts_add_on();
