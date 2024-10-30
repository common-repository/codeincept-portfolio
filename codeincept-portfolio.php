<?php
/**
 * Plugin Name:       Codeincept Portfolio
 * Plugin URI:        https://www.codeincept.com/demo/portfolio
 * Description:       Awesome Portfolio plugin ever
 * Version:           1.0.2
 * Author:            CodeIncept
 * Author URI:        https://www.codeincept.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advanced-portfolio
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
define( 'CODEINCEPT_PORTFOLIO_VERSION', '1.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-advanced-portfolio-activator.php
 */
function ci_activate_advanced_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-portfolio-activator.php';
	Advanced_Portfolio_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-advanced-portfolio-deactivator.php
 */
function ci_deactivate_advanced_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-portfolio-deactivator.php';
	Advanced_Portfolio_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'ci_activate_advanced_portfolio' );
register_deactivation_hook( __FILE__, 'ci_deactivate_advanced_portfolio' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-portfolio.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function codeincept_run_advanced_portfolio() {

	$plugin = new CI_Advanced_Portfolio();
	$plugin->run();

}
codeincept_run_advanced_portfolio();
