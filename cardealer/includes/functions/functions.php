<?php

/**
 * @author Bill Minozzi
 * @copyright 2017
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly




//if (!function_exists('wp_json_decode')) 
//  die("Nao existe mesmo");

/*
        function wp_json_decode($json, $assoc = false, $depth = 512, $options = 0) {
            // Use json_decode if wp_json_decode is not available
            return json_decode($json, $assoc, $depth, $options);
        }
    */
//}
//else
//die("Esiste ?????????????????????????????");


function cardealer_reorder_terms()
{
    global $wpdb;
    $args = array(
        'taxonomy' => 'team',
        'hide_empty' => false,
    );
    $terms = get_terms($args);
    $qteam = count($terms);
    $Cardealerteam = array();
    if ($qteam > 0) {
        $i = 0;
        foreach ($terms as $term) {
            $id = $term->term_id;
            $termMeta = get_option('cardealer_team_' . $id);
            $Cardealerteam[$i]['name'] =  $term->name;
            $Cardealerteam[$i]['description'] =  $term->description;
            $Cardealerteam[$i]['image'] = $termMeta['image'];
            $Cardealerteam[$i]['function'] = $termMeta['function'];
            $Cardealerteam[$i]['phone'] = $termMeta['phone'];
            $Cardealerteam[$i]['email'] = $termMeta['email'];
            $Cardealerteam[$i]['skype'] = $termMeta['skype'];
            $Cardealerteam[$i]['facebook'] = $termMeta['facebook'];
            $Cardealerteam[$i]['twitter'] = $termMeta['twitter'];
            $Cardealerteam[$i]['linkedin'] = $termMeta['linkedin'];
            $Cardealerteam[$i]['vimeo'] = $termMeta['vimeo'];
            $Cardealerteam[$i]['instagram'] = $termMeta['instagram'];
            $Cardealerteam[$i]['youtube'] = $termMeta['youtube'];
            $Cardealerteam[$i]['myorder'] = $termMeta['myorder'];
            $i++;
        }
        function cmp($a, $b)
        {
            return strcmp($a["myorder"], $b["myorder"]);
        }
        if ($i > 1)
            usort($Cardealerteam, "cmp");
    }
    return $Cardealerteam;
}
function cardealer_message_low_memory()
{
    echo '<div class="notice notice-warning">
                     <br />
                     <b>
                     Car Dealer Plugin Warning: You need increase the WordPress memory limit!
                     <br />
                     Please, check 
                     <br />
                     Dashboard => Car Dealer => (tab) Memory Checkup
                     <br /><br />
                     </b>
                     </div>';
}


/*
function cardealer_check_memory()
{
    global $cardealer_memory;
    $cardealer_memory['limit'] = (int) ini_get('memory_limit');
    $cardealer_memory['usage'] = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 0) : 0;
    if (!defined("WP_MEMORY_LIMIT")) {
        $cardealer_memory['msg_type'] = 'notok';
        return;
    }
    $cardealer_memory['wp_limit'] =  trim(WP_MEMORY_LIMIT);
    if ($cardealer_memory['wp_limit'] > 9999999)
        $cardealer_memory['wp_limit'] = ($cardealer_memory['wp_limit'] / 1024) / 1024;
    if (!is_numeric($cardealer_memory['usage'])) {
        $cardealer_memory['msg_type'] = 'notok';
        return;
    }
    if (!is_numeric($cardealer_memory['limit'])) {
        $cardealer_memory['msg_type'] = 'notok';
        return;
    }
    if ($cardealer_memory['usage'] < 1) {
        $cardealer_memory['msg_type'] = 'notok';
        return;
    }
    $wplimit = $cardealer_memory['wp_limit'];
    $wplimit = substr($wplimit, 0, strlen($wplimit) - 1);
    $cardealer_memory['wp_limit'] = $wplimit;
    $cardealer_memory['percent'] = $cardealer_memory['usage'] / $cardealer_memory['wp_limit'];
    $cardealer_memory['color'] = 'font-weight:normal;';
    if ($cardealer_memory['percent'] > .7) $cardealer_memory['color'] = 'font-weight:bold;color:#E66F00';
    if ($cardealer_memory['percent'] > .85) $cardealer_memory['color'] = 'font-weight:bold;color:red';
    $cardealer_memory['msg_type'] = 'ok';
    return $cardealer_memory;
}
*/

function cardealer_check_memory()
{
    // global $memory;
    $memory["color"] = "font-weight:normal;";
    try {

        // PHP $memory["limit"]
        if (!function_exists('ini_get')) {
            $memory["msg_type"] = "notok";
            return $memory;
        } else {
            $memory["limit"] = (int) ini_get("memory_limit");
        }

        if (!is_numeric($memory["limit"])) {
            $memory["msg_type"] = "notok";
            return $memory;
        } else {
            if ($memory["limit"] > 9999999) {
                $memory["limit"] =
                    $memory["limit"] / 1024 / 1024;
            }
        }


        // usage
        if (!function_exists('memory_get_usage')) {
            $memory["msg_type"] = "notok";
            return $memory;
        } else {
            // $bill_install_memory["usage"] = round(memory_get_usage() / 1024 / 1024, 0);
            $memory["usage"] = (int) memory_get_usage();
        }


        if ($memory["usage"] < 1) {
            $memory["msg_type"] = "notok";
            return $memory;
        } else {
            $memory["usage"] = round($memory["usage"] / 1024 / 1024, 0);
        }

        if (!is_numeric($memory["usage"])) {
            $memory["msg_type"] = "notok";
            return $memory;
        }


        // WP
        if (!defined("WP_MEMORY_LIMIT")) {
            $memory['wp_limit'] = 40;
        } else {
            $memory['wp_limit'] = (int) WP_MEMORY_LIMIT;
        }

        $memory["percent"] =
            $memory["usage"] / $memory["wp_limit"];
        $memory["color"] = "font-weight:normal;";
        if ($memory["percent"] > 0.7) {
            $memory["color"] = "font-weight:bold;color:#E66F00";
        }
        if ($memory["percent"] > 0.85) {
            $memory["color"] = "font-weight:bold;color:red";
        }
        $memory["msg_type"] = "ok";
        return $memory;
    } catch (Exception $e) {
        $memory["msg_type"] = "notok(7)";
        return $memory;
    }
}


function cardealer_check_memory_old()
{
    global $cardealer_memory;
    $cardealer_memory["color"] = "font-weight:normal;";
    try {


        // $cardealer_memory["limit"] = (int) ini_get("memory_limit");

        if (!function_exists('ini_get')) {
            $cardealer_memory["msg_type"] = "notok";
            return;
        } else {
            $cardealer_memory["limit"] = (int) ini_get("memory_limit");
        }


        //$cardealer_memory["usage"] = function_exists("memory_get_usage")
        //    ? round(memory_get_usage() / 1024 / 1024, 0)
        //: 0;

        //if ($cardealer_memory["usage"] == 0) {
        //    $cardealer_memory["msg_type"] = "notok";
        //    return;
        // }

        if (!function_exists('memory_get_usage')) {
            $cardealer_memory["msg_type"] = "notok";
            return;
        } else {

            // $bill_install_memory["usage"] = round(memory_get_usage() / 1024 / 1024, 0);
            $cardealer_memory["usage"] = (int) memory_get_usage();
        }


        if ($cardealer_memory["usage"] == 0) {
            $cardealer_memory["msg_type"] = "notok";
            return;
        } else {
            $cardealer_memory["usage"] = round($cardealer_memory["usage"] / 1024 / 1024, 0);
        }

        if (!is_numeric($cardealer_memory["usage"])) {
            $cardealer_memory["msg_type"] = "notok";
            return;
        }





        //if (!defined("WP_MEMORY_LIMIT")) {
        //    $cardealer_memory["msg_type"] = "notok";
        //    return;
        //}

        if (!defined("WP_MEMORY_LIMIT")) {
            $cardealer_memory['wp_limit'] = 40;
            define('WP_MEMORY_LIMIT', '40M');
        } else {
            $cardealer_memory["wp_limit"] = (int) WP_MEMORY_LIMIT;
        }

        if (!defined("WP_MEMORY_LIMIT")) {
            $memory["wp_limit"] = 40;
            define('WP_MEMORY_LIMIT', '40M');
        } else {
            $wp_memory_limit = WP_MEMORY_LIMIT;
            $wp_memory_limit = rtrim($wp_memory_limit, 'M');
            $memory["wp_limit"] = (int) $wp_memory_limit;
        }

        // $cardealer_memory["wp_limit"] = trim(WP_MEMORY_LIMIT);

        if (!is_numeric($cardealer_memory["limit"])) {
            $cardealer_memory["msg_type"] = "notok";
            return;
        } else {
            if ($cardealer_memory["limit"] > 9999999) {
                $cardealer_memory["limit"] =
                    $cardealer_memory["limit"] / 1024 / 1024;
            }
        }
        if ($cardealer_memory["usage"] < 1) {
            $cardealer_memory["msg_type"] = "notok";
            return;
        }

        /*
        $wplimit = $cardealer_memory["wp_limit"];
        // $wplimit = substr($wplimit, 0, strlen($wplimit) - 1);
        $cardealer_memory["wp_limit"] = $wplimit;
        */


        $cardealer_memory["percent"] =
            $cardealer_memory["usage"] / $cardealer_memory["wp_limit"];
        $cardealer_memory["color"] = "font-weight:normal;";
        if ($cardealer_memory["percent"] > 0.7) {
            $cardealer_memory["color"] = "font-weight:bold;color:#E66F00";
        }
        if ($cardealer_memory["percent"] > 0.85) {
            $cardealer_memory["color"] = "font-weight:bold;color:red";
        }
        $cardealer_memory["msg_type"] = "ok";
        return $cardealer_memory;
    } catch (Exception $e) {
        $bill_install_memory["msg_type"] = "notok(7)";
        return $bill_install_memory;
    }
}




function cardealer_howmanycars()
{
    global $wpdb;
    $posts = get_posts(array(
        'post_type'            => 'cars'
    ));
    $number = 0;
    if ($posts) {
        foreach ($posts as $post) {
            $number++;
        }
    }
    return $number;
}
add_action('wp_loaded', 'cardealer_car_get_makes');
function cardealer_car_get_makes()
{
    global $wpdb;
    $carmake = array();
    $args = array(
        'taxonomy'               => 'makes',
        'orderby'                => 'name',
        'order'                  => 'ASC',
        'hide_empty'             => false,
    );
    $the_query = new WP_Term_Query($args);
    foreach ($the_query->get_terms() as $term) {
        $carmake[] = $term->name;
    }
    $qtypes = count($carmake);
    if ($qtypes < 1) {
        $atypes = array("Dodge", "Ford", "Mercedes", "Other");
        $parent_term = term_exists('makes', 'cars'); // array is returned if taxonomy is given
        // $parent_term_id = $parent_term['term_id']; // get numeric term id
        for ($i = 0; $i < 4; $i++) {
            wp_insert_term(
                $atypes[$i],
                'makes',
                array(
                    'slug' =>  $atypes[$i],
                )
            );
        }
        $carmake = $atypes;
    }
    return $carmake;
}
function cardealer_update_files()
{
    global $wpdb;
    $args = array('post_type' => 'cars');
    $posts = get_posts($args);
    foreach ($posts as $post) {
        $post_id = $post->ID;
        $value = get_post_meta($post_id, 'body_color', true);
        if (!empty($value))
            update_post_meta($post_id, 'car-body_color', $value);
    }
}
function cardealer_check_field_exist($field_id)
{
    $cardealer_afieldsId = cardealer_get_fields('all');
    $totfields = count($cardealer_afieldsId);
    $ametadataoptions = array();
    for ($i = 0; $i < $totfields; $i++) {
        $post_id = $cardealer_afieldsId[$i];
        $ametadata = cardealer_get_meta($post_id);
        if (trim($ametadata[12]) == trim($field_id))
            return true;
    }
    return false;
}
function cardealer_add_new_field($fields, $fieldsv)
{
    $mypost = array(
        'post_title' => sanitize_text_field($fieldsv[12]),
        'post_type' => 'cardealerfields',
        'post_status' => 'publish',
    );
    $post_id = wp_insert_post($mypost);
    $tot = count($fields);
    for ($i = 0; $i < ($tot) - 1; $i++) {
        $meta_key = $fields[$i];
        $meta_value = trim($fieldsv[$i]);
        update_post_meta($post_id, $meta_key, $meta_value);
    }
}
function cardealer_add_default_fields()
{
    $fields = array(
        'field-label',
        'field-typefield',
        'field-drop_options',
        'field-searchbar',
        'field-searchwidget',
        'field-rangemin',
        'field-rangemax',
        'field-rangestep',
        'field-slidemin',
        'field-slidemax',
        'field-slidestep',
        'field-order',
        'field-name'
    );
    $atypes = array(
        __("Coupe", "cardealer"),
        __("Luxury Car", "cardealer"),
        __("Sedan", "cardealer"),
        __("Sports Car", "cardealer"),
        __("Sport Utility Vehicle", "cardealer"),
        __("Van", "cardealer"),
        __("Wagon", "cardealer"),
        __("Other", "cardealer")
    );
    $n = count($atypes);
    $bodytypes = '';
    for ($j = 0; $j < $n; $j++) {
        $bodytypes .= $atypes[$j];
        if (($j + 1) < $n)
            $bodytypes .= PHP_EOL;
    }
    $acondition = 'New';
    $acondition .= PHP_EOL;
    $acondition .= 'Used';
    $acondition .= PHP_EOL;
    $acondition .= 'Damaged';
    $allfields = array(
        $fieldsv = array(
            'Body Type',
            'dropdown',
            $bodytypes,
            // '',
            '1',
            '1',
            '',
            '',
            '',
            '',
            '',
            '',
            '10',
            'type'
        ),
        $fieldsv = array(
            'Condition',
            'dropdown',
            $acondition,
            '1',
            '1',
            '',
            '',
            '',
            '',
            '',
            '',
            '11',
            'con'
        ),
        $fieldsv = array(
            'Model',
            'text',
            '',
            '0',
            '0',
            '',
            '',
            '',
            '',
            '',
            '',
            '12',
            'model'
        ),
        $fieldsv = array(
            'Engine',
            'text',
            '',
            '0',
            '0',
            '',
            '',
            '',
            '',
            '',
            '',
            '13',
            'engine'
        ),
        $fieldsv = array(
            'Body Color',
            'text',
            '',
            '0',
            '0',
            '',
            '',
            '',
            '',
            '',
            '',
            '14',
            'body_color'
        ),
        $fieldsv = array(
            'Passenger Capacity',
            'text',
            '',
            '0',
            '0',
            '',
            '',
            '',
            '',
            '',
            '',
            '15',
            'capacity'
        ),
        $fieldsv = array(
            'Interior Color',
            'text',
            '',
            '0',
            '0',
            '',
            '',
            '',
            '',
            '',
            '',
            '16',
            'int'
        ),
        $fieldsv = array(
            'Interior Material',
            'text',
            '',
            '0',
            '0',
            '',
            '',
            '',
            '',
            '',
            '',
            '17',
            'mat'
        )
    ); // end all fields
    $totnewfields = count($allfields);
    for ($i = 0; $i < $totnewfields; $i++) {
        if (!cardealer_check_field_exist($allfields[$i][12])) {
            cardealer_add_new_field($fields, $allfields[$i]);
        }
    }
}
function cardealer_get_fields($type)
{
    global $wpdb;
    if (!function_exists('get_userdata()')) {
        include(ABSPATH . "/wp-includes/pluggable.php");
    }
    if ($type == 'search') {
        $args = array(
            'post_status' => 'publish',
            'post_type' => 'cardealerfields',
            'meta_key' => 'field-order',
            'posts_per_page' => -1,
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(array('key' => 'field-searchbar', 'value' => '1'))
        );
    } elseif ($type == 'all') {
        $args = array(
            'post_status' => 'publish',
            'post_type' => 'cardealerfields',
            'meta_key' => 'field-order',
            'posts_per_page' => -1,
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        );
    } elseif ($type == 'widget') {
        $args = array(
            'post_status' => 'publish',
            'post_type' => 'cardealerfields',
            'meta_key' => 'field-order',
            'posts_per_page' => -1,
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(array('key' => 'field-searchwidget', 'value' => '1'))
        );
    }
    query_posts($args);
    $afields = array();
    $cardealer_afieldsId = array();
    while (have_posts()) :
        the_post();
        $cardealer_afieldsId[] = esc_attr(get_the_ID());
    endwhile;
    ob_start();
    if (isset($GLOBALS['wp_the_query']))
        wp_reset_query();
    ob_end_clean();
    return $cardealer_afieldsId;
} // end Funcrions
function cardealer_get_meta($post_id)
{
    $fields = array(
        'field-label',
        'field-typefield',
        'field-drop_options',
        'field-searchbar',
        'field-searchwidget',
        'field-rangemin',
        'field-rangemax',
        'field-rangestep',
        'field-slidemin',
        'field-slidemax',
        'field-slidestep',
        'field-order',
        'field-name'
    );
    $tot = count($fields);
    for ($i = 0; $i < $tot; $i++) {
        $field_value[$i] = esc_attr(get_post_meta($post_id, $fields[$i], true));
    }
    $field_value[$tot - 1] = esc_attr(get_the_title($post_id));
    return $field_value;
}
/*
function cardealer_get_types()
{
global $wpdb;
$productmake = array();  
$args = array(
'taxonomy'               => 'team',
'orderby'                => 'name',
'order'                  => 'ASC',
'hide_empty'             => false,
);
$the_query = new WP_Term_Query($args);
$productmake = array();  
foreach($the_query->get_terms() as $term){ 
$productmake[] = $term->name;
}
return $productmake; 
}
*/
function cardealer_get_max()
{
    global $wpdb;
    $args = array(
        'numberposts' => 1,
        'post_type' => 'cars',
        'meta_key' => 'car-price',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );
    $posts = get_posts($args);
    foreach ($posts as $post) {
        $x = get_post_meta($post->ID, 'car-price', true);
        if (!empty($x)) {
            $x = (int)$x;
            if (is_int($x)) {
                $x = ($x) * 1.2;
                $x = round($x, 0, PHP_ROUND_HALF_EVEN);
                //return $x;
            }
        }
        if ($x < 1)
            return '100000';
        else
            return $x;
    }
}
//add_action( 'wp_loaded', 'cardealer_get_types' );
function cardealer_get_currency_symbol_new()
{

    /*
    $currencies = array(
		'USD'  => __( 'US Dollars (&#36;)', 'cardealer' ),
		'EUR'  => __( 'Euros (&euro;)', 'cardealer' ),
		'GBP'  => __( 'Pound Sterling (&pound;)', 'cardealer' ),
		'AUD'  => __( 'Australian Dollars (&#36;)', 'cardealer' ),
		'BRL'  => __( 'Brazilian Real (R&#36;)', 'cardealer' ),
		'CAD'  => __( 'Canadian Dollars (&#36;)', 'cardealer' ),
		'CZK'  => __( 'Czech Koruna', 'cardealer' ),
		'DKK'  => __( 'Danish Krone', 'cardealer' ),
		'HKD'  => __( 'Hong Kong Dollar (&#36;)', 'cardealer' ),
		'HUF'  => __( 'Hungarian Forint', 'cardealer' ),
		'ILS'  => __( 'Israeli Shekel (&#8362;)', 'cardealer' ),
		'JPY'  => __( 'Japanese Yen (&yen;)', 'cardealer' ),
		'MYR'  => __( 'Malaysian Ringgits', 'cardealer' ),
		'MXN'  => __( 'Mexican Peso (&#36;)', 'cardealer' ),
		'NZD'  => __( 'New Zealand Dollar (&#36;)', 'cardealer' ),
		'NOK'  => __( 'Norwegian Krone', 'cardealer' ),
		'PHP'  => __( 'Philippine Pesos', 'cardealer' ),
		'PLN'  => __( 'Polish Zloty', 'cardealer' ),
		'SGD'  => __( 'Singapore Dollar (&#36;)', 'cardealer' ),
		'SEK'  => __( 'Swedish Krona', 'cardealer' ),
		'CHF'  => __( 'Swiss Franc', 'cardealer' ),
		'TWD'  => __( 'Taiwan New Dollars', 'cardealer' ),
		'THB'  => __( 'Thai Baht (&#3647;)', 'cardealer' ),
		'INR'  => __( 'Indian Rupee (&#8377;)', 'cardealer' ),
		'TRY'  => __( 'Turkish Lira (&#8378;)', 'cardealer' ),
		'RIAL' => __( 'Iranian Rial (&#65020;)', 'cardealer' ),
		'RUB'  => __( 'Russian Rubles', 'cardealer' ),
		'AOA'  => __( 'Angolan Kwanza', 'cardealer' ),
	);
*/

    $currencies = array(
        'AED'  => __('United Arab Emirates Dirham (&#1583;.&#1573;)', 'cardealer'),
        'AFN'  => __('Afghan Afghani (&#1547;)', 'cardealer'),
        'AOA'  => __('Angolan Kwanza', 'cardealer'),
        'ARS'  => __('Argentine Pesos (&#36;)', 'cardealer'),
        'AUD'  => __('Australian Dollars (&#36;)', 'cardealer'),
        'BRL'  => __('Brazilian Real (R&#36;)', 'cardealer'),
        'BGN'  => __('Bulgarian Lev', 'cardealer'),
        'CAD'  => __('Canadian Dollars (&#36;)', 'cardealer'),
        'CHF'  => __('Swiss Franc', 'cardealer'),
        'CNY'  => __('Chinese Yuan (&yen;)', 'cardealer'),
        'CZK'  => __('Czech Koruna', 'cardealer'),
        'DKK'  => __('Danish Krone', 'cardealer'),
        'EUR'  => __('Euros (&euro;)', 'cardealer'),
        'GBP'  => __('Pound Sterling (&pound;)', 'cardealer'),
        'HKD'  => __('Hong Kong Dollar (&#36;)', 'cardealer'),
        'HRK'  => __('Croatian Kuna', 'cardealer'),
        'HUF'  => __('Hungarian Forint', 'cardealer'),
        'IDR'  => __('Indonesian Rupiah (Rp)', 'cardealer'),
        'ILS'  => __('Israeli Shekel (&#8362;)', 'cardealer'),
        'INR'  => __('Indian Rupee (&#8377;)', 'cardealer'),
        'JPY'  => __('Japanese Yen (&yen;)', 'cardealer'),
        'KRW'  => __('South Korean Won (&#8361;)', 'cardealer'),
        'MXN'  => __('Mexican Peso (&#36;)', 'cardealer'),
        'MYR'  => __('Malaysian Ringgits', 'cardealer'),
        'NGN'  => __('Nigerian Naira', 'cardealer'),
        'NOK'  => __('Norwegian Krone', 'cardealer'),
        'NZD'  => __('New Zealand Dollar (&#36;)', 'cardealer'),
        'PHP'  => __('Philippine Pesos', 'cardealer'),
        'PLN'  => __('Polish Zloty', 'cardealer'),
        'PKR'  => __('Pakistani Rupee (₨)', 'cardealer'),
        'PCH'  => __('Pesos Chilenos($)', 'cardealer'),
        'RON'  => __('Romanian Leu', 'cardealer'),
        'RUB'  => __('Russian Rubles', 'cardealer'),
        'SAR'  => __('Saudi Riyal (&#65020;)', 'cardealer'),
        'SEK'  => __('Swedish Krona', 'cardealer'),
        'SGD'  => __('Singapore Dollar (&#36;)', 'cardealer'),
        'THB'  => __('Thai Baht (&#3647;)', 'cardealer'),
        'TRY'  => __('Turkish Lira (&#8378;)', 'cardealer'),
        'TWD'  => __('Taiwan New Dollars', 'cardealer'),
        'USD'  => __('US Dollars (&#36;)', 'cardealer'),
        'VND'  => __('Vietnamese Dong (&#8363;)', 'cardealer'),
        'YEN'  => __('Yen (&yen;)', 'cardealer'),
        'ZAR'  => __('South African Rand', 'cardealer'),
    );



    // $currency =  get_option('cardealer_get_currency_symbol');

    if (!function_exists('cardealer_get_currency_symbol_new')) {
        function cardealer_get_currency_symbol_new($currency)
        {
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


    /*
    if ($currency == 'AUD') {
        return "AUD";
    }
    //  Bulgarian Bulgarian lev BGN
    if ($currency == 'Bulgarian') {
        return "lev BGN";
    }
    if ($currency == 'Dollar') {
        return "$";
    }
    if ($currency == 'Euro') {
        return "&euro;";
    }
    if ($currency == 'Forint') {
        return "Ft"; 
        // Ft or HUF is also perfect for me. 
    }
    if ($currency == 'Indian') {
        return "₹";
    }
    if ($currency == 'Naira') {
        return "₦";
    }
    if ($currency == 'Pound') {
        return "&pound;";
    }
    if ($currency == 'Krone') {
        return "kr";
    }

    if ($currency == 'Kronor') {
        return "SEK";
    }

    if ($currency == 'Kuna') {
        return "HRK";
    }


    if ($currency == 'Malaysia') {
        return "MYR";
    }
    if ($currency == 'Philippine') {
        // ₱
        return "&#8369;";
    }
    if ($currency == 'Pound') {
        return "&pound;";
    }

    if ($currency == 'Polish') {
        return "PLN";
    }
    if ($currency == 'Real') {
        return "R&#36;";
    }
    if ($currency == 'Swiss') {
        return "CHF";
    }

    if ($currency == 'Thai Bath') {
        return "฿";
    }
    if ($currency == 'Yen') {
        return "&yen;";
    }
    // Afric Sul
    if ($currency == 'Zar') {
        return "R"; 
    if ($currency == 'Universal') {
        return "&curren;";
    }
    */
}
function CarDealer_Show_Notices1()
{
    echo '<div class="update-nag notice"><br />';
    echo 'Warning: Upload directory not found (CarDealer Plugin). Enable debug for more info.';
    echo '<br /><br /></div>';
}
function CarDealer_plugin_was_activated()
{
    echo '<div class="updated"><p>';
    //$bd_msg = '<img src="' . CARDEALERURL . 'assets/images/infox350.png" />';
    $bd_msg = '<h2>CarDealer Plugin was activated! </h2>';
    $bd_msg .= '<h3>For details and help, take a look at Car Dealer Dashboard at your left menu <br />';
    $bd_url = '  <a class="button button-primary" href="admin.php?page=car_dealer_plugin">or click here</a>';
    $bd_msg .= $bd_url;

    $cardealer_allowed_atts = array(
        'align'      => array(),
        'class'      => array(),
        'type'       => array(),
        'id'         => array(),
        'dir'        => array(),
        'lang'       => array(),
        'style'      => array(),
        'xml:lang'   => array(),
        'src'        => array(),
        'alt'        => array(),
        'href'       => array(),
        'rel'        => array(),
        'rev'        => array(),
        'target'     => array(),
        'novalidate' => array(),
        'type'       => array(),
        'value'      => array(),
        'name'       => array(),
        'tabindex'   => array(),
        'action'     => array(),
        'method'     => array(),
        'for'        => array(),
        'width'      => array(),
        'height'     => array(),
        'data'       => array(),
        'title'      => array(),

        'checked' => array(),
        'selected' => array(),


    );




    $cardealer_myallowed['form'] = $cardealer_allowed_atts;
    $cardealer_myallowed['select'] = $cardealer_allowed_atts;
    // select options
    $cardealer_myallowed['option'] = $cardealer_allowed_atts;
    $cardealer_myallowed['style'] = $cardealer_allowed_atts;
    $cardealer_myallowed['label'] = $cardealer_allowed_atts;
    $cardealer_myallowed['input'] = $cardealer_allowed_atts;
    $cardealer_myallowed['textarea'] = $cardealer_allowed_atts;

    //more...future...
    $cardealer_myallowed['form']     = $cardealer_allowed_atts;
    $cardealer_myallowed['label']    = $cardealer_allowed_atts;
    $cardealer_myallowed['input']    = $cardealer_allowed_atts;
    $cardealer_myallowed['textarea'] = $cardealer_allowed_atts;
    $cardealer_myallowed['iframe']   = $cardealer_allowed_atts;
    $cardealer_myallowed['script']   = $cardealer_allowed_atts;
    $cardealer_myallowed['style']    = $cardealer_allowed_atts;
    $cardealer_myallowed['strong']   = $cardealer_allowed_atts;
    $cardealer_myallowed['small']    = $cardealer_allowed_atts;
    $cardealer_myallowed['table']    = $cardealer_allowed_atts;
    $cardealer_myallowed['span']     = $cardealer_allowed_atts;
    $cardealer_myallowed['abbr']     = $cardealer_allowed_atts;
    $cardealer_myallowed['code']     = $cardealer_allowed_atts;
    $cardealer_myallowed['pre']      = $cardealer_allowed_atts;
    $cardealer_myallowed['div']      = $cardealer_allowed_atts;
    $cardealer_myallowed['img']      = $cardealer_allowed_atts;
    $cardealer_myallowed['h1']       = $cardealer_allowed_atts;
    $cardealer_myallowed['h2']       = $cardealer_allowed_atts;
    $cardealer_myallowed['h3']       = $cardealer_allowed_atts;
    $cardealer_myallowed['h4']       = $cardealer_allowed_atts;
    $cardealer_myallowed['h5']       = $cardealer_allowed_atts;
    $cardealer_myallowed['h6']       = $cardealer_allowed_atts;
    $cardealer_myallowed['ol']       = $cardealer_allowed_atts;
    $cardealer_myallowed['ul']       = $cardealer_allowed_atts;
    $cardealer_myallowed['li']       = $cardealer_allowed_atts;
    $cardealer_myallowed['em']       = $cardealer_allowed_atts;
    $cardealer_myallowed['hr']       = $cardealer_allowed_atts;
    $cardealer_myallowed['br']       = $cardealer_allowed_atts;
    $cardealer_myallowed['tr']       = $cardealer_allowed_atts;
    $cardealer_myallowed['td']       = $cardealer_allowed_atts;
    $cardealer_myallowed['p']        = $cardealer_allowed_atts;
    $cardealer_myallowed['a']        = $cardealer_allowed_atts;
    $cardealer_myallowed['b']        = $cardealer_allowed_atts;
    $cardealer_myallowed['i']        = $cardealer_allowed_atts;


    echo wp_kses($bd_msg, $cardealer_myallowed);



    echo "</p></h3></div>";
    $cardealerplugin_installed = trim(get_option('cardealerplugin_installed', ''));
    if (empty($cardealerplugin_installed)) {
        add_option('cardealerplugin_installed', time());
        update_option('cardealerplugin_installed', time());
    }
}
/*
if (is_admin()) {
    if (get_option('CarDealer_activated', '0') == '1') {
        add_action('admin_notices', 'CarDealer_plugin_was_activated');
        $r = update_option('CarDealer_activated', '0');
        if (!$r)
            add_option('CarDealer_activated', '0');
    }
}
*/
if (!function_exists('write_log')) {
    function write_log($log)
    {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}
add_filter('plugin_row_meta', 'cardealer_custom_plugin_row_meta', 10, 2);
function cardealer_custom_plugin_row_meta($links, $file)
{
    if (strpos($file, 'cardealer.php') !== false) {
        $new_links = array(
            'OnLine Guide' =>
            '<a href="http://cardealerplugin.com/guide/" target="_blank">OnLine Guide</a>',
            'Pro' => '<a href="http://cardealerplugin.com/premium/" target="_blank"><b><font color="#FF6600">Go Pro</font></b></a>'
        );
        $links = array_merge($links, $new_links);
    }
    return $links;
}
function cardealer_get_page()
{
    $page = 1;
    $url = sanitize_url($_SERVER['REQUEST_URI']);
    $pieces = explode("/", $url);
    for ($i = 0; $i < count($pieces); $i++) {
        if ($pieces[$i] == 'page' and ($i + 1) < count($pieces)) {
            $page = $pieces[$i + 1];
            if (is_numeric($page))
                return $page;
        }
    }
    return $page;
}
function CarDealer_wrong_permalink()
{
    echo '<div class="notice notice-warning">
                     <br />
                     Car Dealer Plugin: Wrong Permalink settings !
                     <br />
                     Please, fix it to avoid 404 error page.
                     <br />
                     To correct, just follow this steps:
                     <br />
                     Dashboard => Settings => Permalinks => Post Name (check)
                     <br />  
                     Click Save Changes
                     <br /><br />
                     </div>';
}


$cardealerurl = sanitize_url($_SERVER['REQUEST_URI']);
if (strpos($cardealerurl, '/options-permalink.php') === false) {
    $permalinkopt = get_option('permalink_structure');
    if ($permalinkopt != '/%postname%/')
        add_action('admin_notices', 'CarDealer_wrong_permalink');
}


ob_start();
$num_fields = count(cardealer_get_fields('all'));
$num_cars = cardealer_howmanycars();
$updated_version =  trim(get_option('CarDealer_updated', ''));
if ($num_fields < 8 and $num_cars > 0) {
    if ($updated_version < 2) {
        $w = update_option('CarDealer_updated', '2');
        if (!$w)
            add_option('CarDealer_updated', '2');
        cardealer_add_default_fields();
    }
}
ob_end_clean();
function cardealer_control_availablememory()
{
    $cardealer_memory = cardealer_check_memory();
    if ($cardealer_memory['msg_type'] == 'notok')
        return;
    if ($cardealer_memory['percent'] > .7)
        add_action('admin_notices', 'cardealer_message_low_memory');
}
//
//    add_action('wp_loaded', 'cardealer_control_availablememory');
function cardealer_change_note_submenu_order($menu_ord)
{
    global $submenu;
    function cardealer_str_replace_json($search, $replace, $subject)
    {
        if (function_exists('wp_json_decode'))
            return wp_json_decode(str_replace($search, $replace, wp_json_encode($subject)), true);
        else
            return json_decode(str_replace($search, $replace, json_encode($subject)), true);
    }

    $key = 'Car Dealer';
    $val =  __('Dashboard', 'cardealer');
    $submenu = cardealer_str_replace_json($key, $val, $submenu);
}
add_filter('custom_menu_order', 'cardealer_change_note_submenu_order');
function cardealer_submenu_order($menu_ord)
{
    global $submenu;
    // Enable the next line to see all menu orders
    // echo '<pre>'.print_r($submenu['car_dealer_plugin'],true).'</pre>';
    $arr = array();
    $arr[] = $submenu['car_dealer_plugin'][0];     //my original order was 5,10,15,16,17,18
    $arr[] = $submenu['car_dealer_plugin'][6];
    $arr[] = $submenu['car_dealer_plugin'][1];
    $arr[] = $submenu['car_dealer_plugin'][2];
    $arr[] = $submenu['car_dealer_plugin'][3];
    $arr[] = $submenu['car_dealer_plugin'][4];
    $arr[] = $submenu['car_dealer_plugin'][5];
    $arr[] = $submenu['car_dealer_plugin'][7];
    $submenu['car_dealer_plugin'] = $arr;
    return $menu_ord;
}
function cardealer_gopro2_callback()
{
    $urlgopro = "http://cardealerplugin.com/premium/";
?>
    <script type="text/javascript">
        <!--
        window.location = "<?php echo esc_url($urlgopro); ?>";
        -->
    </script>
<?php
}
function cardealer_add_menu_gopro2()
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
function cardealer_cardealer_bill_go_pro_hide()
{
    // $today = date('Ymd', strtotime('+06 days'));
    $today = time();
    if (!update_option('cardealer_bill_go_pro_hide', $today))
        add_option('cardealer_bill_go_pro_hide', $today);
    wp_die();
}
// add_action('admin_notices', 'stop_bad_bots_init');
add_action('wp_ajax_cardealer_cardealer_bill_go_pro_hide', 'cardealer_cardealer_bill_go_pro_hide');
?>