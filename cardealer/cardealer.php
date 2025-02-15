<?php /*
Plugin Name: CarDealer 
Plugin URI: http://cardealerplugin.com
Description: Car Dealer Plugin for Car Dealer agency.
Version: 4.50
Text Domain: cardealer
Domain Path: /language
Author: Bill Minozzi
Author URI: http://billminozzi.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
// https://cardealerplugin.com/help/#11
// https://cardealerplugin.com/movies/customizer.mp4
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
if (!defined('ABSPATH')) exit; // Exit if accessed directly
define('CARDEALERVERSION', '4.49');
define('CARDEALERPATH', plugin_dir_path(__file__));
define('CARDEALERURL', plugin_dir_url(__file__));
define('CARDEALERIMAGES', plugin_dir_url(__file__) . 'assets/images/');
define('CARDEALERHOMEURL', admin_url());
include_once(ABSPATH . 'wp-includes/pluggable.php');
define('CARDEALERPATHLANGUAGE', dirname(plugin_basename(__FILE__)) . '/language/');
$cardealer_is_admin = cardealer_check_wordpress_logged_in_cookie();

if ($cardealer_is_admin)
    add_action('init', 'cardealer_localization_init');


$cardealer_plugin = plugin_basename(__file__);
$CarDealer_hp_or_kw = sanitize_text_field(get_option('CarDealer_hp_or_kw', 'HP'));
$CarDealer_modal_size = sanitize_text_field(get_option('CarDealer_modal_size', '900'));
$CarDealer_template_single = trim(get_option('CarDealer_template_single',  '1'));
$cardealer_auto_updates = trim(get_option('cardealer_auto_updates',  ''));
function cardealer_plugin_settings_link($links)
{
    $settings_link = '<a href="options.php?page=cardealer_settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
if ($cardealer_is_admin) {
    function CarDealer_add_admstylesheet()
    {
        $color = get_user_meta(get_current_user_id(), 'admin_color', true);
        wp_enqueue_style('cardealer-metabox-tabs', CARDEALERURL .
            'includes/post-type/metabox-tabs.css');
        wp_enqueue_style("cardealer-$color", CARDEALERURL .
            'includes/post-type/metabox-$color.css');
        wp_enqueue_script('cardealer-metabox-tabs', CARDEALERURL .
            'includes/post-type/metabox-tabs.js', array('jquery'));
    }
    add_action('admin_print_styles-post.php', 'CarDealer_add_admstylesheet', 1000);

    function cardealer_localization_init_fail()
    {
        if (get_option('cardealer_dismiss_language') == '1')
            return;
        echo '<div id="cardealer_an2" class="notice notice-warning is-dismissible">';
        echo '<br />';
        echo esc_attr__('Car Dealer Plugin: Could not load the localization file (Language file)', 'cardealer');
        echo '.<br />';
        echo esc_attr__('Please, take a look in our site, FAQ page, item => How can i translate this plugin?', 'cardealer');
        echo '<br /><br /></div>';
    }
    // cardealer dismissible_notice2
    function cardealer_dismissible_notice2()
    {
        $r = update_option('cardealer_dismiss_language', '1');
        if (!$r) {
            $r = add_option('cardealer_dismiss_language', '1');
        }
        if ($r)
            die('OK!!!!!');
        else
            die('NNNN');
    }
    add_action('wp_ajax_cardealer_dismissible_notice2', 'cardealer_dismissible_notice2');
    /* End language */
} else {
    add_action('init', 'cardealer_localization_init');
}
add_filter(
    "plugin_action_links_$cardealer_plugin",
    'cardealer_plugin_settings_link'
);
if ($cardealer_is_admin) {
    add_action('setup_theme', 'cardealer_load_settings');
    function cardealer_load_settings()
    {
        require_once(CARDEALERPATH . 'dashboard/main.php');
        require_once(CARDEALERPATH . "settings/load-plugin.php");
        require_once(CARDEALERPATH . "settings/options/plugin_options_tabbed.php");
        require_once(CARDEALERPATH . 'includes/functions/function_sysinfo.php');
    }
}
require_once(CARDEALERPATH . 'includes/help/help.php');
//add_action( 'admin_menu', 'cardealer_add_menu_gopro2' );
require_once(CARDEALERPATH . 'includes/functions/functions.php');
require_once(CARDEALERPATH . 'includes/post-type/meta-box.php');
require_once(CARDEALERPATH . 'includes/post-type/post-functions.php');
// require_once (CARDEALERPATH . 'includes/templates/template-functions.php');
// require_once(CARDEALERPATH . 'includes/templates/redirect.php');
require_once(CARDEALERPATH . 'includes/widgets/widgets.php');
require_once(CARDEALERPATH . 'includes/search/search-function.php');
require_once(CARDEALERPATH . 'includes/search/search-function_ajax.php');
require_once(CARDEALERPATH . 'includes/multi/multi.php');
//require_once (CARDEALERPATH . 'dashboard/main.php');
require_once(CARDEALERPATH . 'includes/contact-form/multi-contact-form.php');
require_once(CARDEALERPATH . 'includes/team/team.php');
if ($cardealer_is_admin) {
    // require_once (CARDEALERPATH . 'includes/functions/health.php');
    // require_once (CARDEALERPATH . 'includes/functions/health_permalink.php');
}
require_once(CARDEALERPATH . 'dashboard/main.php');


if (!function_exists('cardealer_install_ajaxurl')) {
    function cardealer_install_ajaxurl()
    {
        echo '<script type="text/javascript">
            var ajaxurl = "' .
            esc_attr(admin_url("admin-ajax.php")) .
            '";
            </script>';
    }
}
add_action("wp_head", "cardealer_install_ajaxurl");


// require_once(CARDEALERPATH . 'includes/vendor/vendor.php');
$Cardealer_template_gallery = trim(get_option(
    'CarDealer_template_gallery',
    'yes'
));
if ($Cardealer_template_gallery == 'yes')
    require_once(CARDEALERPATH . 'includes/templates/template-showroom.php');
else
    require_once(CARDEALERPATH . 'includes/templates/template-showroom1.php');
require_once(CARDEALERPATH . 'includes/multi/multi-functions.php');
//die(var_export($CarDealer_template_single));
/*
>>>>>>>>>>>>>>>>>>  POP UP 4
if ($CarDealer_template_single == '1')         
require_once (CARDEALERPATH . 'includes/templates/template-functions.php');
if ($CarDealer_template_single == '2')         
require_once (CARDEALERPATH . 'includes/templates/template-functions2.php');
if ($CarDealer_template_single == '3')         
require_once (CARDEALERPATH . 'includes/templates/template-functions3.php');
*/
//if ($CarDealer_template_single == '4')
// require_once(CARDEALERPATH . 'includes/templates/template-functions4.php');
//else
require_once(CARDEALERPATH . 'includes/templates/template-functions4.php');
$cardealerurl = sanitize_url($_SERVER['REQUEST_URI']);
if (strpos($cardealerurl, 'product') !== false or strpos($cardealerurl, '/car/') !== false) {
    $CarDealer_overwrite_gallery = strtolower(get_option(
        'CarDealer_overwrite_gallery',
        'yes'
    ));
    if ($CarDealer_overwrite_gallery == 'yes')
        require_once(CARDEALERPATH . 'includes/gallery/gallery.php');
    // die('xxx');
}
/*
add_action("wp_head", "cardealeer_ajaxurl");
function cardealer_ajaxurl()
{
    echo '<script type="text/javascript">
       var ajaxurl = "' .
        esc_url(admin_url("admin-ajax.php")) .
        '";
     </script>';
}
     */
add_action('wp_enqueue_scripts', 'CarDealer_add_files');
function CarDealer_add_files()
{
    // wp_enqueue_style('bootstrapcss', CARDEALERURL . 'assets/css/bootstrap.min.css', false, null);
    wp_enqueue_script('bootstapjs',  CARDEALERURL . 'assets/js/bootstrap.min.js', false, null);
    wp_enqueue_script("jquery");
    wp_enqueue_style('show-room', CARDEALERURL . 'includes/templates/show-room.css');
    wp_enqueue_style('pluginStyleGeneral', CARDEALERURL .
        'includes/templates/template-style.css');
    //wp_enqueue_style('pluginStyleSearch2', CARDEALERURL .
    //    'includes/search/style-search-box.css');
    wp_enqueue_style('pluginStyleSearchwidget', CARDEALERURL .
        'includes/widgets/style-search-widget.css');
    wp_enqueue_style('pluginStyleGeneral4', CARDEALERURL .
        'includes/gallery/css/flexslider.css');
    wp_register_style(
        'jqueryuiSkin',
        CARDEALERURL . 'assets/jquery/jqueryui.css',
        array(),
        '1.12.1'
    );
    wp_enqueue_style('jqueryuiSkin');
    //wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_style('bill-caricons', CARDEALERURL . 'assets/icons/icons-style.css');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_style('pluginStyleGeneral5', CARDEALERURL .
        'includes/contact-form/css/multi-contact-form.css');
    wp_enqueue_style('pluginTeam2', CARDEALERURL .
        'includes/team/team-custom.css');
    wp_enqueue_style('pluginTeam1', CARDEALERURL .
        'includes/team/team-custom-bootstrap.css');
    wp_register_style('fontawesome-css', CARDEALERURL . 'assets/fonts/font-awesome/css/font-awesome.min.css', array(), CARDEALERVERSION);
    wp_enqueue_style('fontawesome-css');
    wp_register_script('search-slider', CARDEALERURL .
        'includes/search/search_slider.js', array('jquery'), null, true);
    wp_enqueue_script('search-slider');
    /*
    wp_register_script('cardealer-search', CARDEALERURL .
        'includes/search/search.js', array('jquery'), null, true);
    wp_enqueue_script('cardealer-search');
    */
    // Enfileira o seu script
    wp_enqueue_script('cardealer-search', CARDEALERURL . 'includes/search/search.js', array('jquery'), null, true);
    /*
    // Cria um objeto para o JavaScript e passa a URL do admin-ajax.php
    wp_localize_script('cardealer-search', 'cardealer_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('my_nonce_action'), // Opcional, para segurança
    ));
*/
    wp_enqueue_style('search-slider-css', CARDEALERURL .
        'includes/search/style-search-box.css', array('jqueryuiSkin'), CARDEALERVERSION);
    // wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/style.css', array( 'jquery-ui-css' ), '1.0' );
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('wp-color-picker');
    wp_register_script('flexslider', CARDEALERURL .
        'includes/gallery/js/jquery.flexslider-min.js', array('jquery'), null, false);
    wp_enqueue_script('flexslider');
}
add_action('admin_enqueue_scripts', 'cardealer_enqueue_admin_scripts', 5);
function cardealer_enqueue_admin_scripts()
{
    wp_enqueue_script('bootstapjs',  CARDEALERURL . 'assets/js/bootstrap.min.js', false, null);
    wp_enqueue_style('pluginTeam1', CARDEALERURL .
        'includes/team/team-custom-bootstrap.css');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('wp-color-picker');
    // Enfileira o seu script
    wp_enqueue_script('cardealer-search', CARDEALERURL . 'includes/search/search.js', array('jquery'), null, true);
    /*
    // Cria um objeto para o JavaScript e passa a URL do admin-ajax.php
    wp_localize_script('cardealer-search', 'cardealer_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('my_nonce_action'), // Opcional, para segurança
    ));
    */
    wp_register_script('flexslider', CARDEALERURL .
        'includes/gallery/js/jquery.flexslider-min.js', array('jquery'), null, false);
    wp_enqueue_script('flexslider');
}
function CarDealer_activated()
{
    $cardealer_plugin_version = get_site_option('cardealer_plugin_version', '');
    if ($cardealer_plugin_version < CARDEALERVERSION) {
        if ($cardealer_plugin_version < '2.3') {
            if (cardealer_howmanycars() > 0) {
                ob_start();
                cardealer_add_default_fields();
                ob_end_clean();
            }
            add_action('wp_loaded', 'cardealer_update_files');
        }
        if (!add_option('cardealer_plugin_version', CARDEALERVERSION))
            update_option('cardealer_plugin_version', CARDEALERVERSION);
    }
    $w = update_option('CarDealer_activated', '1');
    if (!$w)
        add_option('CarDealer_activated', '1');
    $w = update_option('CarDealer_activated_message', '1');
    if (!$w)
        add_option('CarDealer_activated_message', '1');
    $pointers = ''; // str_replace( 'plugins', '', $pointers );
    update_user_meta(get_current_user_id(), 'dismissed_wp_pointers', $pointers);
    $admin_email = get_option('admin_email');
    $old_admin_email = trim(get_option('CarDealer_recipientEmail', ''));
    if (empty($old_admin_email)) {
        $w = update_option('CarDealer_recipientEmail', $admin_email);
        if (!$w)
            add_option('CarDealer_recipientEmail', $admin_email);
    }
    $a = array(
        'CarDealer_show_make',
        'CarDealer_show_type',
        'CarDealer_show_price',
        'CarDealer_show_year',
        'CarDealer_show_condition',
        'CarDealer_show_transmission',
        'CarDealer_show_fuel',
        'CarDealer_show_orderby',
        'CarDealer_show_price'
    );
    $q = count($a);
    for ($i = 0; $i < $q; $i++) {
        $x = trim(get_option($a[$i], ''));
        if ($x != 'yes' and $x != 'no') {
            $w = update_option($a[$i], 'yes');
            if (!$w)
                add_option($a[$i], 'yes');
        }
    }
}
register_activation_hook(__file__, 'CarDealer_activated');
function cardealerplugin_load_bill_stuff()
{
    global $cardealer_is_admin;
    wp_enqueue_script('jquery-ui-core');
    if ($cardealer_is_admin) {
        if (isset($_GET['taxonomy']))
            $active_tax = sanitize_text_field($_GET['taxonomy']);
        if (isset($active_tax))
            if ($active_tax == 'team')
                wp_enqueue_media();
    }
}
add_action('wp_loaded', 'cardealerplugin_load_bill_stuff');
// add_action('in_admin_footer', 'cardealerplugin_load_activate'); 
if ($cardealer_is_admin) {
    if (get_option('CarDealer_activated_message', '0') == '1') {
        add_action('admin_notices', 'CarDealer_plugin_was_activated');
        $r = update_option('CarDealer_activated_message', '0');
        if (!$r)
            add_option('CarDealer_activated_message', '0');
    }
}
add_action('admin_menu', 'cardealer_add_menu_gopro2');
$body_type = __('Body Type', 'cardealer');
$condition = __('Condition', 'cardealer');
add_filter('custom_menu_order', 'cardealer_submenu_order');
/* =============================== */
function cardealer_add_menu_gopro2222()
{
    $cardealer_gopro_page = add_submenu_page(
        'car_dealer_plugin', // $parent_slug
        'Go Pro', // string $page_title
        '<font color="#FF6600">' . __('Go Pro', 'cardealer') . '</font>', // string $menu_title
        'manage_options', // string $capability
        'cardealer_my-custom-submenu-page3',
        'cardealer_gopro2_callback',
        8
    );
}
/*
function cardealer_more_plugins() {
    echo '<script>';
    echo 'window.location.replace("'.esc_url(CARDEALERHOMEURL).'plugin-install.php?s=sminozzi&tab=search&type=author");';
    echo '</script>';
}
*/
function cardealer_show_logo()
{
    echo '<div id="cardealers_logo" style="margin-top:10px;">';
    // echo '<br>';
    echo '<img src="';
    echo esc_url(CARDEALERIMAGES) . '/logo300.png';
    echo '">';
    echo '<br>';
    echo '</div>';
}
if (!function_exists('wp_get_current_user')) {
    require_once(ABSPATH . "wp-includes/pluggable.php");
}
/*
function cardealer_localization_init()
{
    $loaded = load_plugin_textdomain('cardealer', false, CARDEALERPATHLANGUAGE);
    if (!$loaded and get_locale() <> 'en_US') {
        if (function_exists('cardealer_localization_init_fail'))
            if ($cardealer_is_admin)
                add_action('admin_notices', 'cardealer_localization_init_fail');
    }
}
*/
function cardealer_cardealer_bill_go_pro_hide2()
{
    // $today = date('Ymd', strtotime('+06 days'));
    $today = time();
    if (!update_option('cardealer_bill_go_pro_hide', $today))
        add_option('cardealer_bill_go_pro_hide', $today);
    wp_die();
}
add_action('wp_ajax_cardealer_cardealer_bill_go_pro_hide2', 'cardealer_cardealer_bill_go_pro_hide2');
/*
add_action('wp_ajax_cardealer_search_autos', 'cardealer_handle_search_autos');
add_action('wp_ajax_nopriv_cardealer_search_autos', 'cardealer_handle_search_autos');
function cardealer_handle_search_autos()
{
    custom_error_log(__LINE__);
    // mail('sergiominozzi@gmail.com', '11------888888111', '2228----888822');
    require_once(CARDEALERURL . "includes/search/do_search.php");
}
// die(CARDEALERURL . "includes/search/do_search.php");
custom_error_log(__LINE__);
*/
require_once(CARDEALERPATH . "includes/search/do_search.php");
// Adiciona a ação para usuários logados
add_action("wp_ajax_cardealer_search_cars_ajax", "cardealer_search_cars_ajax");
// Adiciona a ação para usuários não logados
add_action("wp_ajax_nopriv_cardealer_search_cars_ajax", "cardealer_search_cars_ajax");
// Adiciona a ação para usuários logados
add_action("wp_ajax_cardealer_single_car_ajax", "cardealer_single_car_ajax");
// Adiciona a ação para usuários não logados
add_action("wp_ajax_nopriv_cardealer_single_car_ajax", "cardealer_single_car_ajax");
/*
function cardealer_new_more_plugins()
{
  // cardealer_show_logo();
	$plugins_to_install = array();
	$plugins_to_install[0]["Name"] = "Anti Hacker Plugin";
	$plugins_to_install[0]["Description"] = "Firewall, Scanner, Login Protect, block user enumeration and TOR, disable Json WordPress Rest API, xml-rpc (xmlrpc) & Pingback and more security tools...";
	$plugins_to_install[0]["image"] = "https://ps.w.org/cardealer/assets/icon-256x256.gif?rev=2524575";
	$plugins_to_install[0]["slug"] = "cardealer";
	$plugins_to_install[1]["Name"] = "Stop Bad Bots";
	$plugins_to_install[1]["Description"] = "Stop Bad Bots, Block SPAM bots, Crawlers and spiders also from botnets. Save bandwidth, avoid server overload and content steal. Blocks also by IP.";
	$plugins_to_install[1]["image"] = "https://ps.w.org/stopbadbots/assets/icon-256x256.gif?rev=2524815";
	$plugins_to_install[1]["slug"] = "stopbadbots";
	$plugins_to_install[2]["Name"] = "WP Tools";
	$plugins_to_install[2]["Description"] = "More than 35 useful tools! It is a swiss army knife, to take your site to the next level.";
	$plugins_to_install[2]["image"] = "https://ps.w.org/wptools/assets/icon-256x256.gif?rev=2526088";
	$plugins_to_install[2]["slug"] = "wptools";
	$plugins_to_install[3]["Name"] = "reCAPTCHA For All";
	$plugins_to_install[3]["Description"] = "Protect ALL Pages of your site against bots (spam, hackers, fake users and other types of automated abuse)
	with invisible reCaptcha V3 (Google). You can also block visitors from China.";
	$plugins_to_install[3]["image"] = "https://ps.w.org/recaptcha-for-all/assets/icon-256x256.gif?rev=2544899";
	$plugins_to_install[3]["slug"] = "recaptcha-for-all";
	$plugins_to_install[4]["Name"] = "WP Memory";
	$plugins_to_install[4]["Description"] = "Check High Memory Usage, Memory Limit, PHP Memory, show result in Site Health Page and fix php low memory limit.";
	$plugins_to_install[4]["image"] = "https://ps.w.org/wp-memory/assets/icon-256x256.gif?rev=2525936";
	$plugins_to_install[4]["slug"] = "wp-memory";
	$plugins_to_install[5]["Name"] = "Database Backup";
	$plugins_to_install[5]["Description"] = "Database Backup with just one click.";
	$plugins_to_install[5]["image"] = "https://ps.w.org/database-backup/assets/icon-256x256.gif?rev=2862571";
	$plugins_to_install[5]["slug"] = "database-backup";
	$plugins_to_install[6]["Name"] = "Database Restore Bigdump";
	$plugins_to_install[6]["Description"] = "Database Restore with BigDump script.";
	$plugins_to_install[6]["image"] = "https://ps.w.org/bigdump-restore/assets/icon-256x256.gif?rev=2872393";
	$plugins_to_install[6]["slug"] = "bigdump-restore";
	$plugins_to_install[7]["Name"] = "Easy Update URLs";
	$plugins_to_install[7]["Description"] = "Fix your URLs at database after cloning or moving sites.";
	$plugins_to_install[7]["image"] = "https://ps.w.org/easy-update-urls/assets/icon-256x256.gif?rev=2866408";
	$plugins_to_install[7]["slug"] = "easy-update-urls";
	$plugins_to_install[8]["Name"] = "S3 Cloud Contabo";
	$plugins_to_install[8]["Description"] = "Connect you with your Contabo S3-compatible Object Storage.";
	$plugins_to_install[8]["image"] = "https://ps.w.org/s3cloud/assets/icon-256x256.gif?rev=2855916";
	$plugins_to_install[8]["slug"] = "s3cloud";
	$plugins_to_install[9]["Name"] = "Tools for S3 AWS Amazon";
	$plugins_to_install[9]["Description"] = "Connect you with your Amazon S3-compatible Object Storage.";
	$plugins_to_install[9]["image"] = "https://ps.w.org/toolsfors3/assets/icon-256x256.gif?rev=2862487";
	$plugins_to_install[9]["slug"] =  "toolsfors3";
?>
	<div style="padding-right:20px;">
		<br>
		<h1>Useful FREE Plugins of the same author</h1>
		<div id="bill-wrap-install" class="bill-wrap-install" style="display:none">
			<h3>Please wait</h3>
			<big>
				<h4>
					Installing plugin <div id="billpluginslug">...</div>
				</h4>
			</big>
			<img src="/wp-admin/images/wpspin_light-2x.gif" id="billimagewaitfbl" style="display:none;margin-left:0px;margin-top:0px;" />
			<br />
		</div>
		<table style="margin-right:20px; border-spacing: 0 25px; " class="widefat" cellspacing="0" id="cardealer-more-plugins-table">
			<tbody class="cardealer-more-plugins-body">
				<?php
				$counter = 0;
				$total = count($plugins_to_install);
				for ($i = 0; $i < $total; $i++) {
					if ($counter % 2 == 0) {
						echo '<tr style="background:#f6f6f1;">';
					}
					++$counter;
					if ($counter % 2 == 1)
						echo '<td style="max-width:140px; max-height:140px; padding-left: 40px;" >';
					else
						echo '<td style="max-width:140px; max-height:140px;" >';
					echo '<img style="width:100px;" src="' . esc_url($plugins_to_install[$i]["image"]) . '">';
					echo '</td>';
					echo '<td style="width:40%;">';
					echo '<h3>' . esc_attr($plugins_to_install[$i]["Name"]) . '</h3>';
					echo esc_attr($plugins_to_install[$i]["Description"]);
					echo '<br>';
					echo '</td>';
					echo '<td style="max-width:140px; max-height:140px;" >';
					if (cardealer_plugin_installed($plugins_to_install[$i]["slug"]))
						echo '<a href="#" class="button activate-now">Installed</a>';
					else
						echo '<a href="#" id="' . esc_attr($plugins_to_install[$i]["slug"]) . '"class="button button-primary cd-bill-install-now">Install</a>';
					echo '</td>';
					if ($counter % 2 == 1) {
						echo '<td style="width; 100px; border-left: 1px solid gray;">';
						echo '</td>';
					}
					if ($counter % 2 == 0) {
						echo '</tr>';
					}
				}
				?>
			</tbody>
		</table>
        <?php echo '<div id="cardealer_nonce" style="display:none;" >'. esc_attr(wp_create_nonce('cardealer_install_plugin')); ?>
	</div>
<?php
}
*/
/*
function cardealer_plugin_installed($slug)
{
	$all_plugins = get_plugins();
	foreach ($all_plugins as $key => $value) {
		$plugin_file = $key;
		$slash_position = strpos($plugin_file, '/');
		$folder = substr($plugin_file, 0, $slash_position);
		// match FOLDER against SLUG
		if ($slug == $folder) {
			return true;
		}
	}
	return false;
}
*/
function cardealer_load_upsell()
{
    wp_enqueue_script('jquery-ui-accordion');
    /*
	wp_enqueue_style('cardealer-more2', CARDEALERURL . 'includes/more/more2.css');
	wp_register_script('cardealer-more2-js', CARDEALERURL . 'includes/more/more2.js', array('jquery'));
	wp_enqueue_script('cardealer-more2-js');
    */
    $cardealer_cardealer_bill_go_pro_hide = trim(get_option('cardealer_bill_go_pro_hide'));
    // $cardealer_cardealer_bill_go_pro_hide = '';
    // Debug ...
    $wtime = strtotime('-08 days');
    // update_option('cardealer_cardealer_bill_go_pro_hide', $wtime);
    if (empty($cardealer_cardealer_bill_go_pro_hide)) {
        $wtime = strtotime('-05 days');
        update_option('cardealer_bill_go_pro_hide', $wtime);
        $cardealer_cardealer_bill_go_pro_hide =  $wtime;
    }
    $now = time();
    $delta = $now - $cardealer_cardealer_bill_go_pro_hide;
    if ($delta > (3600 * 24 * 6)) {
        $list = 'enqueued';
        if (!wp_script_is('bill-css-vendor-fix', $list)) {
            require_once(CARDEALERPATH . 'includes/vendor/vendor.php');
            wp_enqueue_style('bill-css-vendor-fix', CARDEALERURL . 'includes/vendor/vendor_fix.css');
            wp_register_script("bill-js-vendor", CARDEALERURL . 'includes/vendor/vendor.js', array('jquery'), CARDEALERVERSION, true);
            wp_enqueue_script('bill-js-vendor');
        }
    }
    wp_register_script("bill-js-vendor-sidebar", CARDEALERURL . 'includes/vendor/vendor-sidebar.js', array('jquery'), CARDEALERVERSION, true);
    wp_enqueue_script('bill-js-vendor-sidebar');
    wp_enqueue_style('bill-css-vendor', CARDEALERURL . 'includes/vendor/vendor.css');
}
if (!function_exists('wp_get_current_user')) {
    require_once(ABSPATH . "wp-includes/pluggable.php");
}
if ($cardealer_is_admin) {
    add_action('admin_enqueue_scripts', 'cardealer_load_upsell');
    add_action('wp_ajax_cardealer_install_plugin', 'cardealer_install_plugin');
}
function cardealer_install_plugin()
{
    if (isset($_POST['slug'])) {
        $slug = sanitize_text_field($_POST['slug']);
    } else {
        echo 'Fail error (-5)';
        wp_die();
    }
    if (isset($_POST['nonce'])) {
        $nonce = sanitize_text_field($_POST['nonce']);
        if (! wp_verify_nonce($nonce, 'cardealer_install_plugin'))
            die('Bad Nonce');
    } else
        wp_die('nonce not set');
    if ($slug != "database-backup" &&  $slug != "bigdump-restore" &&  $slug != "easy-update-urls" &&  $slug != "s3cloud" &&  $slug != "toolsfors3" && $slug != "antihacker" && $slug != "toolstruthsocial" && $slug != "stopbadbots" && $slug != "wptools" && $slug != "recaptcha-for-all" && $slug != "wp-memory") {
        wp_die('wrong slug');
    }
    $plugin['source'] = 'repo'; // $_GET['plugin_source']; // Plugin source.
    require_once ABSPATH . 'wp-admin/includes/plugin-install.php'; // Need for plugins_api.
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php'; // Need for upgrade classes.
    // get plugin information
    $api = plugins_api('plugin_information', array('slug' => $slug, 'fields' => array('sections' => false)));
    if (is_wp_error($api)) {
        echo 'Fail error (-1)';
        wp_die();
        // proceed
    } else {
        // Set plugin source to WordPress API link if available.
        if (isset($api->download_link)) {
            $plugin['source'] = $api->download_link;
            $source =  $api->download_link;
        } else {
            echo 'Fail error (-2)';
            wp_die();
        }
        $nonce = 'install-plugin_' . $api->slug;
        /*
        $type = 'web';
        $url = $source;
        $title = 'wptools';
        */
        $plugin = $slug;
        // verbose...
        //    $upgrader = new Plugin_Upgrader($skin = new Plugin_Installer_Skin(compact('type', 'title', 'url', 'nonce', 'plugin', 'api')));
        class cardealer_QuietSkin extends \WP_Upgrader_Skin
        {
            public function feedback($string, ...$args)
            { /* no output */
            }
            public function header()
            { /* no output */
            }
            public function footer()
            { /* no output */
            }
        }
        $skin = new cardealer_QuietSkin(array('api' => $api));
        $upgrader = new Plugin_Upgrader($skin);
        // var_dump($upgrader);
        try {
            $upgrader->install($source);
            //	get all plugins
            $all_plugins = get_plugins();
            // scan existing plugins
            foreach ($all_plugins as $key => $value) {
                // get full path to plugin MAIN file
                // folder and filename
                $plugin_file = $key;
                $slash_position = strpos($plugin_file, '/');
                $folder = substr($plugin_file, 0, $slash_position);
                // match FOLDER against SLUG
                // if matched then ACTIVATE it
                if ($slug == $folder) {
                    /*
					// Activate
					$result = activate_plugin(ABSPATH . 'wp-content/plugins/' . $plugin_file);
					if (is_wp_error($result)) {
						// Process Error
						echo 'Fail error (-3)';
						wp_die();
					}
                    */
                } // if matched
            }
        } catch (Exception $e) {
            echo 'Fail error (-4)';
            wp_die();
        }
    } // activation
    echo 'OK';
    wp_die();
}
//////////////////////////  CUSTOMIZER PREVIEW  //
function cardealer_add_custom_submenu_page()
{
    add_theme_page(
        'Car_Dealer_Designer', // Page title
        'CarDealer Designer',  // Menu title
        'manage_options',  // Capability required to access the page
        'Car_Dealer_Designer', // Unique identifier for the page
        '__return_null' // Callback function to display
    );
}
add_action('admin_menu', 'cardealer_add_custom_submenu_page');
function cardealer_plugin_customize_preview_js()
{
    $file =  CARDEALERURL . 'assets/js/cardealer_customizer-preview.js';
    $r = wp_enqueue_script(
        "my-customize-preview222",
        $file,
        array('jquery'),
        '1.99'
    );
    // Localize script and pass the variable
    $cardealer_previewUrl =  home_url() . '/' . cardealer_find_single_url();
    wp_localize_script('my-customize-preview222', 'cardealer_my_data', array(
        'cardealer_previewUrl' => $cardealer_previewUrl,
    ));
}
add_action('customize_preview_init', 'cardealer_plugin_customize_preview_js');
function cardealer_customize_controls_js()
{
    $file =  CARDEALERURL . 'js/cardealer_customize_events.js';
    wp_enqueue_script(
        "cardealer-customize-events222",
        CARDEALERURL . 'assets/js/cardealer_customize_events.js',
        array('jquery'),
        '1.99'
    );
    //$file =  CARDEALERURL . 'assets/js/cardealer_customize-controls.js';
    wp_enqueue_script(
        "cardealer-customize-controls222",
        CARDEALERURL . 'assets/js/cardealer_customize-controls.js',
        array('customize-preview'),
        '1.99'
    );
    // Localize script and pass the variable
    $cardealer_previewUrl =  home_url() . '/' . cardealer_find_single_url();
    wp_localize_script('my-customize-controls222', 'cardealer_my_data', array(
        'cardealer_previewUrl' => $cardealer_previewUrl,
    ));
}
add_action('admin_enqueue_scripts', 'cardealer_customize_controls_js');
///////////////////////////// find single url
function cardealer_find_single_url()
{
    global $wp;
    //global $query;
    global $wp_query;
    global $wp_the_query;
    $args = array(
        'post_type' => 'cars'
    );
    wp_reset_query();
    $car_query = new WP_Query($args);
    $car_posts = get_posts($args);
    if (!isset($car_posts[0]->ID))
        return '-1';
    $post_name = basename(get_permalink($car_posts[0]->ID));
    return $post_name;
}
/*
debug
function cardealer_check_jquery_enqueue() {
    if (wp_script_is('my-customize-controls222', 'enqueued')) {
        // O jQuery está enfileirado
        echo 'O jmy-customize-controls222 está enfileirado!';
        error_log('1');
    } else {
        // O jQuery não está enfileirado
        echo 'O my-customize-controls222 não está enfileirado.';
        error_log('2');
    }
}
add_action('wp_footer', 'cardealer_check_jquery_enqueue', 99999);
*/
function cardealer_last()
{
    include_once CARDEALERPATH . '/includes/customizer/customizer.php';
    include_once  CARDEALERPATH  . '/includes/customizer/public.php';
}
add_action('plugins_loaded', 'cardealer_last');
//////////////////////////          END CUSTOMIZER PREVIEW  //
// 08 2023
// require_once ABSPATH . 'wp-includes/pluggable.php';
// check 4 errors...
/*
if(is_admin() and current_user_can("manage_options")){
    if (!class_exists('Bill_Class_Diagnose') and !function_exists('cardealer_bill_my_custom_hooking_function')) {
		function cardealer_bill_my_custom_hooking_function() {
            $plugin_slug = "cardealer"; // Replace with your actual text domain
            $plugin_text_domain = "cardealer"; // Replace with your actual text domain
                $notification_url = "https://wpmemory.com/fix-low-memory-limit/";
			$notification_url2 =
				"https://wptoolsplugin.com/site-language-error-can-crash-your-site/";
            require_once(CARDEALERPATH . "includes/checkup/bill_class_diagnose.php");
            }
		add_action('init', 'cardealer_bill_my_custom_hooking_function');
    }
}
// catch js errors...
if (! class_exists('bill_catch_errors') and !function_exists('cardealer_bill_my_custom_hooking_function2')) {
    function cardealer_bill_my_custom_hooking_function2() {
        require_once(CARDEALERPATH . "includes/checkup/class_bill_catch_errors.php");   
    }
    add_action('init', 'cardealer_bill_my_custom_hooking_function2');
 }
 */
/*
// run the ajax...
if (!function_exists('cardealer_bill_get_js_errors')) {
    function cardealer_bill_get_js_errors()
        {
            if (isset($_REQUEST)) {
                if (!isset($_REQUEST['cardealer_bill_js_error_catched']))
                    die("empty error");
                if (!wp_verify_nonce(sanitize_text_field($_POST['_wpnonce']), 'jquery-bill')) {
                    status_header(406, 'Invalid nonce');
                    die();
                }
                $cardealer_bill_js_error_catched = sanitize_text_field($_REQUEST['cardealer_bill_js_error_catched']);
                $cardealer_bill_js_error_catched = trim($cardealer_bill_js_error_catched);
                if (!empty($cardealer_bill_js_error_catched)) {
                    $txt = 'Javascript ' . $cardealer_bill_js_error_catched;
                    error_log($txt);
                    // send email
                    // bill_php_error($txt);
                    //set_transient( 'sbb_javascript_error', '1', (3600*24) );
                    //add_option( 'sbb_javascript_error', time() );
                    die('OK!!!');
                }
            }
            die('NOT OK!');
        }
}
*/
// Use wp_load_alloptions() instead. 
//$options = get_alloptions();
//foreach ($options as $key => $value) {
//echo $key . ' => ' . $value . '<br>';
//}
// delete_option('CarDealer_recipientEmail');
//$cardealer_fieldfeatures = get_option('cardealer_fieldfeatures');
//echo $cardealer_fieldfeatures;
//die();
//
//
if (!function_exists('cardealer_get_currency_symbol')) {
    function cardealer_get_currency_symbol()
    {
        $currency =  get_option('cardealer_get_currency_symbol', 'USD');
        $currencies = array(
            'AED'  => '&#1583;.&#1573;',
            'AFN'  => '&#1547;',
            'AOA'  => 'Kz',
            'ARS'  => '&#36;',
            'AUD'  => '&#36;',
            'BRL'  => 'R&#36;',
            'BGN'  => 'лв',
            'CAD'  => '&#36;',
            'CHF'  => 'CHF',
            'CNY'  => '&yen;',
            'CZK'  => 'Kč',
            'DKK'  => 'kr',
            'EUR'  => '&euro;',
            'GBP'  => '&pound;',
            'HKD'  => '&#36;',
            'HRK'  => 'kn',
            'HUF'  => 'Ft',
            'IDR'  => 'Rp',
            'ILS'  => '&#8362;',
            'INR'  => '&#8377;',
            'JPY'  => '&yen;',
            'KRW'  => '&#8361;',
            'MXN'  => '&#36;',
            'MYR'  => 'RM',
            'NOK'  => 'kr',
            'NZD'  => '&#36;',
            'PHP'  => '&#8369;',
            'PLN'  => 'zł',
            'PKR'  => '₨',
            'RON'  => 'lei',
            'RUB'  => '&#8381;',
            'SAR'  => '&#65020;',
            'SEK'  => 'kr',
            'SGD'  => '&#36;',
            'THB'  => '&#3647;',
            'TRY'  => '&#8378;',
            'TWD'  => 'NT$',
            'USD'  => '&#36;',
            'VND'  => '&#8363;',
            'ZAR'  => 'R',
            // Adicione outros símbolos de moeda conforme necessário
        );
        // Verifique se a moeda está na array e retorne o símbolo correspondente
        if (array_key_exists($currency, $currencies)) {
            return $currencies[$currency];
        } else {
            return '&curren;'; // Retorna vazio se a moeda não estiver na array
        }
    }
}
// ---------------------------------- 2024  -------------------------------------
function cardealer_new_more_plugins()
{
    $plugin = new cardealer_Bill_show_more_plugins();
    $plugin->bill_show_plugins();
}
function cardealer_bill_more()
{
    global $cardealer_is_admin;
    //if (function_exists('is_admin') && function_exists('current_user_can')) {
    if ($cardealer_is_admin and current_user_can("manage_options")) {
        $declared_classes = get_declared_classes();
        foreach ($declared_classes as $class_name) {
            if (strpos($class_name, "Bill_show_more_plugins") !== false) {
                //return;
            }
        }
        require_once dirname(__FILE__) . "/includes/more-tools/class_bill_more.php";
    }
    // }
}
add_action("init", "cardealer_bill_more", 5);
/*
// Function to display the content of Tab 3 (More Tools)
function cardealer_new_more_plugins(){
    echo '<h2>More Tools</h2>';
    //$plugin = new \cardealer_BillMore\Bill_show_more_plugins();
    $plugin = new cardealer_Bill_show_more_plugins();
    $plugin->bill_show_plugins();
}
add_action('admin_menu', 'cardealer_init',10);
*/
//
/*
function cardealer_init()
{
	add_management_page(
		'More Useful Tools',
		'<font color="#FF6600">More Useful Tools</font>', // string $menu_title
		'manage_options',
		'cardealers_new_more_plugins', // slug
		'cardealers_new_more_plugins',
		1
	);
}	
function cardealer_row_meta($links, $file)
{
	if (strpos($file, 'cardealers.php') !== false) {
		if (is_multisite())
			$url = admin_url() . "plugin-install.php?s=sminozzi&tab=search&type=author";
		else
			$url = admin_url() . "admin.php?page=cardealer_new_more_plugins";
		$new_links['Pro'] = '<a href="' . $url . '" target="_blank"><b><font color="#FF6600">Click To see more FREE plugins from same author</font></b></a>';
		$links = array_merge($links, $new_links);
	}
	return $links;
}
add_filter('plugin_row_meta', 'cardealer_row_meta', 10, 2);
*/

function cardealer_load_chat()
{
    if (function_exists('is_admin') && function_exists('current_user_can')) {
        if (is_admin() and current_user_can("manage_options")) {
            if (! class_exists('cardealer_BillChat\ChatPlugin')) {
                require_once dirname(__FILE__) . "/includes/chat/class_bill_chat.php";
            }
        }
    }
}
add_action('wp_loaded', 'cardealer_load_chat');
// -------------------------------------
function cardealer_bill_hooking_diagnose()
{
    global $cardealer_is_admin;
    // if (function_exists('is_admin') && function_exists('current_user_can')) {
    if ($cardealer_is_admin and current_user_can("manage_options")) {
        $declared_classes = get_declared_classes();
        foreach ($declared_classes as $class_name) {
            if (strpos($class_name, "Bill_Diagnose") !== false) {
                return;
            }
        }
        $plugin_slug = 'cardealer';
        $plugin_text_domain = $plugin_slug;
        $notification_url = "https://wpmemory.com/fix-low-memory-limit/";
        $notification_url2 =
            "https://wptoolsplugin.com/site-language-error-can-crash-your-site/";
        require_once dirname(__FILE__) . "/includes/diagnose/class_bill_diagnose.php";
    }
    // } 
}
add_action("init", "cardealer_bill_hooking_diagnose", 10);
function cardealer_bill_hooking_catch_errors()
{
    global $cardealer_plugin_slug;
    global $cardealer_is_admin;
    $declared_classes = get_declared_classes();
    foreach ($declared_classes as $class_name) {
        if (strpos($class_name, "bill_catch_errors") !== false) {
            return;
        }
    }
    $cardealer_plugin_slug = 'cardealer';
    require_once dirname(__FILE__) . "/includes/catch-errors/class_bill_catch_errors.php";
}
add_action("init", "cardealer_bill_hooking_catch_errors", 15);
// ------------------------
function cardealer_load_feedback()
{
    global $cardealer_is_admin;
    //if (function_exists('is_admin') && function_exists('current_user_can')) {
    if ($cardealer_is_admin and current_user_can("manage_options")) {
        // ob_start();
        //
        require_once dirname(__FILE__) . "/includes/feedback-last/feedback-last.php";
        // ob_end_clean();
        //
    }
    //}
    //
}
add_action('wp_loaded', 'cardealer_load_feedback', 10);
// ------------------------
function cardealer_bill_install()
{
    global $cardealer_is_admin;
    if ($cardealer_is_admin and current_user_can("manage_options")) {
        $declared_classes = get_declared_classes();
        foreach ($declared_classes as $class_name) {
            if (strpos($class_name, "Bill_Class_Plugins_Install") !== false) {
                return;
            }
        }
        if (!function_exists('bill_install_ajaxurl')) {
            function bill_install_ajaxurl()
            {
                echo '<script type="text/javascript">
					var ajaxurl = "' .
                    esc_attr(admin_url("admin-ajax.php")) .
                    '";
					</script>';
            }
        }
        // ob_start();
        $plugin_slug = 'cardealer';
        $plugin_text_domain = $plugin_slug;
        $notification_url = "https://wpmemory.com/fix-low-memory-limit/";
        $notification_url2 =
            "https://wptoolsplugin.com/site-language-error-can-crash-your-site/";
        $logo = CARDEALERIMAGES . '/logo300.png';
        //$plugin_adm_url = admin_url('tools.php?page=stopbadbots_new_more_plugins');
        $plugin_adm_url = admin_url();
        require_once dirname(__FILE__) . "/includes/install-checkup/class_bill_install.php";
        // ob_end_clean();
    }
}
add_action('wp_loaded', 'cardealer_bill_install', 15);
function cardealer_check_wordpress_logged_in_cookie()
{
    // Percorre todos os cookies definidos
    foreach ($_COOKIE as $key => $value) {
        // Verifica se algum cookie começa com 'wordpress_logged_in_'
        if (strpos($key, 'wordpress_logged_in_') === 0) {
            // Cookie encontrado
            return true;
        }
    }
    // Cookie não encontrado
    return false;
}
function cardealer_localization_init()
{
    $path = CARDEALERPATH . 'language/';
    $locale = apply_filters('plugin_locale', determine_locale(), 'cardealer');
    // Full path of the specific translation file (e.g., es_AR.mo)
    $specific_translation_path = $path . "cardealer-$locale.mo";
    $specific_translation_loaded = false;
    // Check if the specific translation file exists and try to load it
    if (file_exists($specific_translation_path)) {
        $specific_translation_loaded = load_textdomain('cardealer', $specific_translation_path);
    }
    // List of languages that should have a fallback to a specific locale
    $fallback_locales = [
        'de' => 'de_DE',  // German
        'fr' => 'fr_FR',  // French
        'it' => 'it_IT',  // Italian
        'es' => 'es_ES',  // Spanish
        'pt' => 'pt_BR',  // Portuguese (fallback to Brazil)
        'nl' => 'nl_NL'   // Dutch (fallback to Netherlands)
    ];
    // If the specific translation was not loaded, try to fallback to the generic version
    if (!$specific_translation_loaded) {
        $language = explode('_', $locale)[0];  // Get only the language code, ignoring the country (e.g., es from es_AR)
        if (array_key_exists($language, $fallback_locales)) {
            // Full path of the generic fallback translation file (e.g., es_ES.mo)
            $fallback_translation_path = $path . "cardealer-{$fallback_locales[$language]}.mo";
            // Check if the fallback generic file exists and try to load it
            if (file_exists($fallback_translation_path)) {
                load_textdomain('cardealer', $fallback_translation_path);
            }
        }
    }
    // Load the plugin
    load_plugin_textdomain('cardealer', false, plugin_basename(CARDEALERPATH) . '/language/');
}
function CarDealer_customize_enqueue()
{
    // Enfileirar o estilo do Color Picker
    wp_enqueue_style('wp-color-picker');
    // Enfileirar o script do Color Picker
    wp_enqueue_script('wp-color-picker');
    // Adicionar o seu script de inicialização
    wp_add_inline_script('wp-color-picker', '
        jQuery(document).ready(function($) {
            $(".color-field").wpColorPicker();
        });
    ');
}
add_action('customize_controls_enqueue_scripts', 'CarDealer_customize_enqueue');
function cardealer_my_plugin_activation()
{
    // Inicia o buffer de saída
    ob_start();
    $output = ob_get_clean();
    if (!empty($output)) {
        error_log("Output not expected during ativation: $output");
    }
}
register_activation_hook(__FILE__, 'cardealer_my_plugin_activation');

/*
function cardealer_check_jquery_loaded_before_shutdown() {
    // Check if jQuery is registered and enqueued
    if (wp_script_is('jquery', 'registered')) {
        if (wp_script_is('jquery', 'enqueued')) {
            error_log('jQuery is registered and enqueued.');
        } else {
            error_log('jQuery is registered but not enqueued.');
        }
    } else {
        error_log('jQuery is NOT registered.');
    }
}
    */
