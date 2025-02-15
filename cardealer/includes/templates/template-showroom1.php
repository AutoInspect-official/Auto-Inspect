<?php

/**
 * @author Bill Minozzi
 * @copyright 2017
 * List View
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
    $output .= '<div class="modal-content">';
    $output .= '</div>';
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
            return  $output;
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
    // orderby
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

    // 2024
    //$output .= '<div class="carGallery">';
    //$output .= '<div class="CarDealer_container">';


    // $output .= '<div class="multiGallery">';




    $output .= '<div class="multiGallery">';
    //$output .= '<div class="CarDealer_container">';
    $output .= '<div class="modal-content">';
    $output .= '</div>';



    while ($wp_query->have_posts()):
        $wp_query->the_post();
        $post_id = get_the_ID();
        $ctd++;
        $price = get_post_meta(get_the_ID(), 'car-price', true);
        if (!empty($price)) {
            $price = number_format_i18n($price, 0);
        }
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
        $year = get_post_meta(get_the_ID(), 'car-year', true);
        $hp = get_post_meta(get_the_ID(), 'car-hp', true);
        $year = get_post_meta(get_the_ID(), 'car-year', true);
        $fuel = get_post_meta(get_the_ID(), 'car-fuel', true);
        $transmission = get_post_meta(get_the_ID(), 'transmission-type', true);
        $miles = get_post_meta(get_the_ID(), 'car-miles', true);
        $output .= '<div id="CarDealer_container17" class="CarDealer_container17">';
        $output .= '<div class="CarDealer_gallery_17">';
        $output .= '<a href="#myModal-' . $post_id . '" class="open-modal">';
        $output .= '<img class="CarDealer_caption_img17" src="' . $thumb . '" />';
        $output .= "</a>";
        $output .= '</div>';
        $output .= '<div class="multiInfoRight17">';
        $output .= '<a href="#myModal-' . $post_id . '" class="open-modal">';
        $output .= '<div class="multiTitle17">' . get_the_title() . "</div>";
        $output .= "</a>";
        //$output .= '</a>';
        $output .= '<div class="multiInforightText17">';
        $output .= '<div class="multiInforightbold">';
        $output .= '<div class="cardealer_smallblock">';
        //         $price = get_post_meta(get_the_ID(), 'car-price', true);
        if ($price <> '' and $price != '0') {
            $price = cardealer_get_currency_symbol() . $price;
        } else
            $price =  __('Call for Price', 'cardealer');
        $output .= $price;
        $output .= '</div>';
        if ($hp <> '') {
            $output .= '<div class="cardealer_smallblock">';
            $output .= '<span class="billcar-belt2">';
            if ($CarDealer_hp_or_kw == 'hp')
                $output .= ' ' . $hp . __('HP', 'cardealer');
            else
                $output .= ' ' . $hp . __('KW', 'cardealer');
            $output .= '</div>';
        }
        if ($year <> '') {
            $output .= '<div class="cardealer_smallblock">';
            $output .= '<span class="billcar-calendar">';
            $output .= ' ' . $year;
            $output .= '</div>';
        }
        if ($fuel <> '') {
            $output .= '<div class="cardealer_smallblock">';
            $output .= '<span class="billcar-gas-station">';
            $output .= ' ' . $fuel;
            $output .= '</div>';
        }
        if ($transmission <> '') {
            $output .= '<div class="cardealer_smallblock">';
            $output .= '<span class="billcar-gearshift">';
            $output .= ' ' . $transmission;
            $output .= '</div>';
        }
        $miles_label = get_option('CarDealer_measure', 'Miles');
        if ($miles <> '' and null !== $miles_label) {
            $output .= '<div class="cardealer_smallblock">';
            $output .= '<span class="billcar-dashboard">';
            $miles_label = get_option('CarDealer_measure', 'Miles');
            $output .=  '  ' . esc_html(get_post_meta(get_the_ID(), 'car-miles', 'true'));
            if ($miles_label == 'Miles') {
                $output .= ' ' . esc_attr__('Miles', 'cardealer');
            } elseif ($miles_label == 'Hours') {
                $output .= ' ' . esc_attr__('Hours', 'cardealer');
            } elseif ($miles_label == 'Kms') {
                $output .= ' ' .  esc_attr__('Kms', 'cardealer');
            }
            $output .= '</div>';
        }
        $content_post = get_post(get_the_ID());
        $desc = sanitize_text_field($content_post->post_content);
        $desc = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $desc);
        $output .= '<div class="cardealer_description">';
        $output .= substr($desc, 0, 100);
        if (substr($desc, 200) <> '')
            $output .= '...';
        $output .= '</div>';
        $output .= '</div>';
        $CarDealer_template_single = '5';
        $output .= '</div>';
        //$output .= '</a>';
        $output .= '</div>';
        //$output .= '<input type="submit" value="' . __('View', 'cardealer') . '" class="btn btn-primary open-modal cardealer_btn_view" id="modal-submit-' . $post_id . '" />';
        $output .= '<input type="submit" value="' . __('View', 'cardealer') . '" class="btn btn-primary open-modal cardealer_btn_view" id="modal-submit-' . $post_id . '" />';
        $output .= '</div>';
    endwhile;

    // '</div>';


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

    //$output .= '</div>'; /* carGallery */

    //$output .= '</div>';


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
}
add_shortcode('car_dealer', 'cardealer_show_cars');
