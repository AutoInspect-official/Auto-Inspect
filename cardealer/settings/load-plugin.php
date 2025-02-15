<?php
/**
 * @author Bill Minozzi
 * @copyright 2017
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $cardealer_pcs_settings_config;
$cardealer_pcs_settings_config = array();
/**
* Base Directory Setting
*/
$cardealer_pcs_settings_config['base_dir'] = __DIR__ . '/';
/**
* Base URI Settings
* Use Wordpress' plugins_url to set this if not a theme.
*/
$cardealer_pcs_settings_config['base_uri'] = plugins_url( 'settings' , dirname(__FILE__) ) . '/';
/**
* Requred Classes and Libraries
*/
require_once (plugin_dir_path(__FILE__) . "containers.php");
require_once (plugin_dir_path(__FILE__) . "fields.php");
require_once (plugin_dir_path(__FILE__) . "factories.php");
require_once (plugin_dir_path(__FILE__) . "page-builders.php");