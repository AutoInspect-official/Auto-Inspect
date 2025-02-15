<?php
/**
 * @author Bill Minozzi
 * @copyright 2017 - 2024
 * Template Functions for Single Modal
 */
if (! defined('ABSPATH')) exit; // Exit if accessed directly 
function cardealer_detail($post_id)
{
    global $cardealer_queried_post;
    $cardealer_queried_post = get_post($post_id);
    $r =    cardealer_top_detail($post_id);
    $r .=  cardealer_content_info($post_id);
?>
    <div class="multicontentWrap">
        <?php
        $r .= cardealer_content_detail($post_id); ?>
    <?php
    echo '</div>';
    return $r;
}
function cardealer_top_detail($post_id)
{
    global $cardealer_the_title;
    global $cardealer_queried_post;
    // global $post_id;
    ob_start();
    $cardealer_the_title = $cardealer_queried_post->post_title;
    $price = get_post_meta($post_id, 'car-price', true);
    if ($price <> '' and $price != '0') {
        $price =   number_format_i18n($price, 0);
        $price = cardealer_get_currency_symbol() . $price;
    } else
        $price =  __('Call for Price', 'cardealer');
    $year = get_post_meta($post_id, 'car-year', 'true');
    if (!empty($year))
        $year = __('Year', 'cardealer') . ': ' . $year;
    ?>
        <div class="multi-top-container">
            <div class="multi-detail-title"> <?php echo esc_attr($cardealer_the_title); ?> </div>
            <div class="multi-price-single"> <?php echo esc_attr($price); ?> </div>
            <div class="multi-detail-year"><?php echo esc_attr($year)  ?> </div>
            <?php
            $terms3 = get_the_terms($post_id, 'locations');
            if (gettype($terms3) == 'array') {
                $term3 = $terms3[0];
                if (is_object($term3)) {
                    echo '<div class="multi-detail-location">';
                    echo esc_attr__('Location', 'cardealer') . ': ';
                    echo esc_attr($term3->name);
                    echo '</div>';
                }
            }
            ?>
        </div>
    <?php
    // echo  $cardealer_queried_post->post_content;
    $r = ob_get_contents();
    ob_end_clean();
    return $r;
}
function cardealer_content_detail($post_id)
{
    global $cardealer_afieldsId; //  = cardealer_get_fields('all');
    //global $post_ID;
    $post_product_id = $post_id;
    ob_start();
    ?>
        <div class="multiContent">
            <div id="sliderWrapper">
                <div class="featuredTitle">
                    <?php echo esc_attr__('Details', 'cardealer'); ?>
                </div>
                <?php
                $totfields = count($cardealer_afieldsId);
                $ametadataoptions = array();
                echo '<div class="featuredCar">';
                for ($i = 0; $i < $totfields; $i++) {
                    $post_id = $cardealer_afieldsId[$i];
                    $ametadata = cardealer_get_meta($post_id);
                    if (!empty($ametadata[0]))
                        $label = $ametadata[0];
                    else
                        $label = $ametadata[12];
                    $field_id = 'car-' . $ametadata[12];
                    $value = get_post_meta($post_product_id, $field_id, true);
                    $typefield = $ametadata[1];
                    if ($value != '') {
                        if ($typefield == 'checkbox') {
                            if ($value == 'enabled')
                                $value = 'Yes';
                            else
                                $value = 'No';
                        }
                ?>
                        <div class="featuredList">
                            <span class="multiBold"> <?php echo esc_attr($label); ?>: </span><?php echo '<b>' . esc_attr($value) . '</b>'; ?>
                        </div><!-- End of featured list -->
                <?php
                    }
                } ?>
            </div><!-- End of featured car -->
            <div class="featuredTitle">
                <?php echo esc_attr__('Features', 'cardealer'); ?> </div>
            <div class="featuredCar">
                <?php
                $cardealer_features = trim(get_option('cardealer_fieldfeatures'));
                $cardealer_afeatures = explode(PHP_EOL, $cardealer_features);
                $qnew = count($cardealer_afeatures);
                for ($i = 0; $i < $qnew; $i++) {
                    // $title = $cardealer_afeatures[$i];
                    $field_name =  trim($cardealer_afeatures[$i]);
                    $field_name = str_replace(' ', '_', $field_name);
                    $field_id = 'car_' . $field_name;
                    $meta = get_post_meta($post_product_id, $field_id, true);
                    // var_dump($meta);
                    $field_name = str_replace('_', ' ', $field_name);
                    if ($meta != '') { ?>
                        <div class="featuredList">
                            <span class="carBold"> <?php echo esc_attr($field_name); ?>: </span><?php echo esc_attr($meta); ?>
                        </div><!-- End of featured list --><?php }
                                                    }
                                                            ?>
            </div><!-- End of featured multi -->
        </div> <!-- end of Slider Content -->
    </div> <!-- end of Slider Wrapper -->
<?php // }
    $r = ob_get_contents();
    ob_end_clean();
    return $r;
}
function cardealer_strip_shortcode_gallery($content)
{
    preg_match_all('/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER);
    if (!empty($matches)) {
        foreach ($matches as $shortcode) {
            if ('gallery' === $shortcode[2]) {
                $pos = strpos($content, $shortcode[0]);
                if (false !== $pos) {
                    return substr_replace($content, '', $pos, strlen($shortcode[0]));
                }
            }
        }
    }
    return $content;
}
function cardealer_content_info($post_id)
{
    global $CarDealer_hp_or_kw;
    // global $post_id;
    global $cardealer_queried_post;
    ob_start();
    // $post_id = 18485;
    $cardealer_queried_post = get_post($post_id);
    $title = $cardealer_queried_post->post_title;
?>
    <div class="contentInfo">
        <div class="multiContent">
            <?php
            $text = cardealer_strip_shortcode_gallery($cardealer_queried_post->post_content);
            $gallery = get_post_gallery($post_id);
            echo $gallery;
            echo str_replace("\r", "<br />", $text);
            ?>
        </div>
        <?php
        $terms = get_the_terms($post_id, 'makes');
        if (is_array($terms)) {
            $term = $terms[0];
            echo '<div class="featuredTitle">';
            echo esc_attr__('Make', 'cardealer') . ': ';
            echo esc_attr($term->name);
            $model = trim(get_post_meta($post_id, 'car-model', 'true'));
            if (!empty($model)) {
                echo '&nbsp;&nbsp;&nbsp;';
                echo esc_attr__('Model', 'cardealer') . ': ';
                echo esc_attr($model);
            }
            echo '</div>';
        } else {
            $model = trim(get_post_meta($post_id, 'car-model', 'true'));
            if (!empty($model)) {
                echo '<div class="featuredTitle">';
                echo '&nbsp;&nbsp;&nbsp;';
                echo esc_attr__('Model', 'cardealer') . ': ';
                // echo esc_attr($term1->name);
                echo esc_attr($model);
                echo '</div>';
            }
        }
        ?>
        <?php
        if (is_array($terms))
            echo '<div class="featuredCar">';
        ?>
        <div class="multiDetail">
            <div class="multiBasicRow"><span class="singleInfo"><?php echo esc_attr__('Transmission', 'cardealer') ?>:
                </span><br><?php echo esc_attr(get_post_meta($post_id, 'transmission-type', 'true')); ?></div>
            <div class="multiBasicRow"><span class="singleInfo"><?php echo esc_attr__('Fuel', 'cardealer') ?>:
                </span><br><?php echo esc_attr(get_post_meta($post_id, 'car-fuel', 'true')); ?></div>
           
        
                

                    <?php
                        $miles_label = get_option('CarDealer_measure', 'Miles');
                        $miles = get_post_meta($post_id, 'car-miles', 'true');
                        if ( $miles <> '' and null !== $miles_label ) {
                            $miles_label = get_option("CarDealer_measure", "Miles");
                            if ($miles_label == 'Miles') {
                                echo '<div class="multiBasicRow"><span class="singleInfo">Miles: </span><br>' . get_post_meta($post_id, 'car-miles', 'true') . '</div>';
                            } elseif ($miles_label == 'Hours') {
                                echo '<div class="multiBasicRow"><span class="singleInfo">Hours: </span><br>' . get_post_meta($post_id, 'car-miles', 'true') . '</div>';
                            } elseif ($miles_label == 'Kms') {
                                echo '<div class="multiBasicRow"><span class="singleInfo">Kms: </span><br>' . get_post_meta($post_id, 'car-miles', 'true') . '</div>';
                            }
                            else
                            {
                                echo '</span>';
                            }
                        }
                        ?>
          
            <div class="multiBasicRow"><span class="singleInfo"><?php echo esc_attr__('Cond', 'cardealer'); ?>:
                </span><br><?php echo esc_attr(get_post_meta($post_id, 'car-con', 'true')); ?></div>
            <div class="multiBasicRow"><span class="singleInfo">
                    <?php
                    if ($CarDealer_hp_or_kw == 'hp') {
                        echo esc_attr__('HP', 'cardealer');
                    ?>:&nbsp; </span><br><?php echo esc_attr(get_post_meta($post_id, 'car-hp', 'true'));
                    } else {
                        echo esc_attr__('KW', 'cardealer'); ?>:&nbsp;</span><br><?php echo esc_attr(get_post_meta($post_id, 'car-hp', 'true'));
                                                                                            } ?>
            </div>
        </div>
        <?php if (is_array($terms))
            echo '</div>';
        ?>
    </div>
<?php
    $r = ob_get_contents();
    ob_end_clean();
    return $r;
}
require_once(CARDEALERPATH . "assets/php/cardealer_mr_image_resize.php");
function CarDealer_theme_thumb($url, $width, $height = 0, $align = '')
{
    if (get_the_post_thumbnail() == '') {
        $url = CARDEALERIMAGES . 'image-no-available.jpg';
    }
    return cardealer_mr_image_resize($url, $width, $height, true, $align, false);
}
?>