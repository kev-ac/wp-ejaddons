<?php

/**

 * @wordpress-plugin
 * Plugin Name:       Easyjob Webshop Addons
 * Description:       Addons für das Easyjob Webshop Plugin.
 * Version:           1.0.0
 * Author:            Kevin T.
 * Author URI:        https://github.com/kev-ac/wp-ejaddons
 * Text Domain:       ejaddons
 * Domain Path:       /languages
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Requires at least: 5.4
 * Tested up to:      5.7.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

require_once 'autoload.php';

function run_easyjob_addons() {

    $plugin = new \EasyjobAddons\EasyjobAddons();
}

run_easyjob_addons();

