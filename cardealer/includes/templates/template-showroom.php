<?php
/**
 * @author Bill Minozzi
 * @copyright 2017
 * 
 * Gallery
 */
if (! defined('ABSPATH')) exit; // Exit if accessed directly
function cardealer_show_cars($atts)
{
    global $CarDealer_hp_or_kw;
    global $CarDealer_template_single;
    $CarDealer_overwrite_gallery = strtolower(get_option(
        'CarDealer_overwrite_gallery',
        'yes'
    ));
    if ($CarDealer_overwrite_gallery == 'yes')
        require_once(CARDEALERPATH . 'includes/gallery/gallery.php');
    $output = '<div id="cardealer_content">';
    $cardealer_pagination = 'yes';
    if (!isset($postNumber)) {
        $postNumber = get_option('CarDealer_quantity', 6);
    }
    if (empty($postNumber)) {
        $postNumber = get_option('CarDealer_quantity', 6);
    }
    $output .= CarDealer_search(1);
    if (isset($atts['onlybar'])) {
        //$output .= carDealer_search(1);
        $output .= '</div';
        if (!wp_doing_ajax()) {
           // return' NOT doing ajax';
          $output .= '<div class="modal-content">';
          $output .= '</div>';
          $output .= '<div class="carGallery">';
          $output .= '</div>';
          return  $output ;
        }
    }
    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    }
    if (! isset($paged))
        $paged = cardealer_get_page();
    global $wp_query;
    wp_reset_query();
    $args = array(
        'post_type' => 'cars',
        'showposts' => $postNumber,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'ASC'
    );
    if (!empty($orderby)) {
        $args['orderby'] = 'meta_value';
        $args['meta_type'] = 'NUMERIC';
        if ($orderby == 'price_high') {
            $args['meta_key'] = 'car-price';
            $args['order'] = 'DESC';
        }
        if ($orderby == 'price_low') {
            $args['meta_key'] = 'car-price';
            $args['order'] = 'ASC';
        }
        if ($orderby == 'year_high') {
            $args['meta_key'] = 'car-year';
            $args['order'] = 'DESC';
        }
        if ($orderby == 'year_low') {
            $args['meta_key'] = 'car-year';
            $args['order'] = 'ASC';
        }
    } else {
        $args['orderby'] = 'date';
        $args[] = 'ASC';
    }
    $wp_query = new WP_Query($args);
    $qposts = $wp_query->post_count;
    $ctd = 0;
    $CarDealer_measure = get_option('CarDealer_measure', 'M2');
    if (!defined('CARDEALERSINGLE_TITLE')) {
        define('CARDEALERSINGLE_TITLE', 'x');
    }
    $output .= '<div class="carGallery">';
    $output .= '<div class="CarDealer_container">';
    $output .= '<div class="modal-content">';
    $output .= '</div>';
    while ($wp_query->have_posts()):
        $wp_query->the_post();
        $post_id = get_the_ID();
        $ctd++;
        $price = get_post_meta(get_the_ID(), 'car-price', true);
        if ($price <> '' and $price != '0') {
            $price = number_format($price);
        } else
            $price = '';
        $image_id = get_post_thumbnail_id();
        if (empty($image_id)) {
            $image = CARDEALERIMAGES . 'image-no-available-800x400_br.jpg';
            $image = str_replace("-", "", $image);
        } else {
            $image_url = wp_get_attachment_image_src($image_id, 'medium', true);
            $image = str_replace("-" . $image_url[1] . "x" . $image_url[2], "", $image_url[0]);
        }
        $CarDealer_thumbs_format = trim(get_option('CarDealer_thumbs_format', '1'));
        if ($CarDealer_thumbs_format == '2')
            $thumb = CarDealer_theme_thumb($image, 300, 225, 'br'); // Crops from bottom right
        else
            $thumb = CarDealer_theme_thumb($image, 400, 200, 'br'); // Crops from bottom right
        $hp = get_post_meta(get_the_ID(), 'car-hp', true);
        $year = get_post_meta(get_the_ID(), 'car-year', true);
        $fuel = get_post_meta(get_the_ID(), 'car-fuel', true);
        $transmission = get_post_meta(get_the_ID(), 'transmission-type', true);
        $miles = get_post_meta(get_the_ID(), 'car-miles', true);
        $output .= '<div>';
        $output .= '<a href="#myModal-' . $post_id . '" class="open-modal">';
        $output .= '<div class="CarDealer_gallery_2016">';
        $output .= '<img class="CarDealer_caption_img" src="' . $thumb . '" alt="' .
            get_the_title() . '" />';
        $output .= '<div class="CarDealer_caption_text">';
        $output .= ($price <> '' ? cardealer_get_currency_symbol() . $price : __(
            'Call for Price',
            'cardealer'
        ));
        // $output .= ($price <> '' ? '<br />' : '');
        $output .= '<br />';
        //  $output .= ($hp <> '' ? $hp . ' ' . __('HP', 'cardealer') . '<br />' : '');
        if ($hp <> '') {
            if ($CarDealer_hp_or_kw == 'hp')
                $output .= ' ' . $hp . __('HP', 'cardealer') . '<br />';
            else
                $output .= ' ' . $hp . __('KW', 'cardealer') . '<br />';
        }
        $output .= ($year <> '' ? __('Year', 'cardealer') . ': ' . $year . '<br />' : '');
        $output .= ($fuel <> '' ? __('Fuel', 'cardealer') . ': ' . $fuel . '<br />' : '');
        $output .= ($transmission <> '' ? __('Transmission', 'cardealer') . ': ' . $transmission .
            '<br />' : '');
        $miles_label = get_option('CarDealer_measure', 'Miles');
        if ( $miles <> '' and null !== $miles_label ) {
            $miles_label = get_option('CarDealer_measure', 'Miles');
            if ($miles_label == 'Miles') {
                $output .= esc_attr__('Miles', 'cardealer') . ': ';
                //$output .= '<br />';
                $output .=  esc_html(get_post_meta(get_the_ID(), 'car-miles', 'true'));
            } elseif ($miles_label == 'Hours') {
                $output .= esc_attr__('Hours', 'cardealer') . ': ';
                //$output .= '<br />';
                $output .=  esc_html(get_post_meta(get_the_ID(), 'car-miles', 'true'));
            } elseif ($miles_label == 'Kms') {
                $output .=  esc_attr__('Kms', 'cardealer') . ': ';
                //$output .= '<br />';
                $output .= esc_html(get_post_meta(get_the_ID(), 'car-miles', 'true'));
            }
        }
        $output .= '</div>';
        $output .= '<div class="carTitle">' . esc_html(get_the_title()) . '</div>';
        $output .= '</a>';
        $output .= '</div>';
        $output .= '</div>';
        if ($ctd < $qposts) {
            if ($ctd % 3 == 0) {
                $output .= '</div>';
                $output .= '<div class="CarDealer_container">';
            }
        }
    endwhile;
    $output .= '</div>';
    $output .= '<br/> <br/>';
    if ($cardealer_pagination == 'yes') {
        $output .= '<div class="cardealer_navigation">';
        $output .= '';
        ob_start();
        the_posts_pagination(array(
            'mid_size' => 2,
            'prev_text' => __('Back', 'cardealer'),
            'next_text' => __('Onward', 'cardealer'),
        ));
        $output .= ob_get_contents();
        ob_end_clean();
        $output .= '</div>';
    }
    $output .= '</div>';
    wp_reset_postdata();
    wp_reset_query();
    if ($qposts < 1) {
        $output .= '<h4>' . __('Not Found !', 'cardealer') . '</h4>';
    }
    $output .= '</div>'; /* cardealer_content */
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
        "onclick" => array(),
    );
    $cardealer_my_allowed['form'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['select'] = $cardealer_allowed_atts;
    // select options
    $cardealer_my_allowed['option'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['style'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['label'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['input'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['textarea'] = $cardealer_allowed_atts;
    //more...future...
    $cardealer_my_allowed['form']     = $cardealer_allowed_atts;
    $cardealer_my_allowed['label']    = $cardealer_allowed_atts;
    $cardealer_my_allowed['input']    = $cardealer_allowed_atts;
    $cardealer_my_allowed['textarea'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['iframe']   = $cardealer_allowed_atts;
    $cardealer_my_allowed['script']   = $cardealer_allowed_atts;
    $cardealer_my_allowed['style']    = $cardealer_allowed_atts;
    $cardealer_my_allowed['strong']   = $cardealer_allowed_atts;
    $cardealer_my_allowed['small']    = $cardealer_allowed_atts;
    $cardealer_my_allowed['table']    = $cardealer_allowed_atts;
    $cardealer_my_allowed['span']     = $cardealer_allowed_atts;
    $cardealer_my_allowed['abbr']     = $cardealer_allowed_atts;
    $cardealer_my_allowed['code']     = $cardealer_allowed_atts;
    $cardealer_my_allowed['pre']      = $cardealer_allowed_atts;
    $cardealer_my_allowed['div']      = $cardealer_allowed_atts;
    $cardealer_my_allowed['img']      = $cardealer_allowed_atts;
    $cardealer_my_allowed['h1']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['h2']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['h3']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['h4']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['h5']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['h6']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['ol']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['ul']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['li']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['em']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['hr']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['br']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['tr']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['td']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['p']        = $cardealer_allowed_atts;
    $cardealer_my_allowed['a']        = $cardealer_allowed_atts;
    $cardealer_my_allowed['b']        = $cardealer_allowed_atts;
    $cardealer_my_allowed['i']        = $cardealer_allowed_atts;
    return wp_kses($output, $cardealer_my_allowed);
    //  return $output;
}
add_shortcode('car_dealer', 'cardealer_show_cars');
