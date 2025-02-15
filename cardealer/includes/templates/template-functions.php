<?php

/**
 * @author Bill Minozzi
 * @copyright 2017
 */
if (! defined('ABSPATH')) exit; // Exit if accessed directly 



function cardealer_content_detail()
{

  // $post_product_id = get_the_ID();

  $post_product_id = $_POST['post_id'];

  $post = get_post($post_id);
  if ($post) {











?>
    <div class="multiContent">
      <div id="sliderWrapper">
        <div class="featuredTitle">
          <?php echo esc_attr__('Details', 'cardealer'); ?>
        </div>
        <?php
        $cardealer_afieldsId = cardealer_get_fields('all');
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
                $value = __('Yes', 'cardealer');
              else
                $value = __('No', 'cardealer');
            }
        ?>
            <div class="featuredList">
              <span class="multiBold"> <?php echo esc_attr($label); ?>: </span><?php echo '<b>' . esc_attr($value) . '</b>'; ?>
            </div><!-- End of featured list -->
        <?php }
        } ?>
      </div><!-- End of featured car -->
      <div class="featuredTitle">
        <?php echo esc_attr__('Features', 'cardealer'); ?> </div>
      <div class="featuredCar">
        <?php
        $cardealer_features = trim(get_option('cardealer_fieldfeatures'));
        $cardealer_afeatures = explode(PHP_EOL, $cardealer_features);
        $qnew = count($cardealer_afeatures);
        //  print_r($cardealer_afeatures);
        // $post_id = trim(get_the_ID()); // trim($post->ID);      
        for ($i = 0; $i < $qnew; $i++) {
          // $title = $cardealer_afeatures[$i];
          $field_name =  trim($cardealer_afeatures[$i]);
          $field_name = str_replace(' ', '_', $field_name);
          $field_id = 'car_' . $field_name;
          $meta = get_post_meta($post_product_id, $field_id, true);
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

  }
}




function cardealer_content_info()
{
  global $CarDealer_hp_or_kw;
  ?>
  <div class="contentInfo">
    <div class="multiContent">
      <?php the_content(); ?>
    </div>
    <?php
    $terms = get_the_terms(get_the_id(), 'makes');
    if (is_array($terms)) {
      $term = $terms[0];
      echo '<div class="featuredTitle">';
      echo esc_attr__('Make', 'cardealer') . ': ';
      echo esc_attr($term->name);
      $model = trim(get_post_meta(get_the_ID(), 'car-model', 'true'));
      if (! empty($model)) {
        echo '&nbsp;&nbsp;&nbsp;';
        echo esc_attr__('Model', 'cardealer') . ': ';
        echo esc_attr($model);
      }
      echo '</div>';
    } else {
      $model = trim(get_post_meta(get_the_ID(), 'car-model', 'true'));
      if (! empty($model)) {
        echo '<div class="featuredTitle">';
        echo '&nbsp;&nbsp;&nbsp;';
        echo esc_attr__('Model', 'cardealer') . ': ';
        // echo esc_attr($term1->name);
        echo esc_attr($model);
        echo '</div>';
      }
    }
    ?>
    <?php if (is_array($terms))
      echo '<div class="featuredCar">';
    ?>
    <div class="multiDetail">
      <div class="multiBasicRow"><span class="singleInfo"><?php echo esc_attr__('Transmission', 'cardealer') ?>: </span><?php echo esc_html(get_post_meta(get_the_ID(), 'transmission-type', 'true')); ?></div>




      <!-- <div class="multiBasicRow"><span class="singleInfo">
                <?php // echo esc_attr__(get_option('CarDealer_measure', 'Miles'), 'cardealer')
                ?>: 
                

               



<!-- 2024 -->
      <div class="multiBasicRow">
        <span class="singleInfo">
          <?php

          /*
        $miles_label = get_option('CarDealer_measure', 'Miles');
        if ($miles_label == 'Miles') {
            echo 'Miles: ';
            echo '</span>';
            echo esc_html(get_post_meta(get_the_ID(), 'car-miles', 'true'));
        } elseif ($miles_label == 'Hours') {
            echo 'Hours: ';
            echo '</span>';
            echo esc_html(get_post_meta(get_the_ID(), 'car-miles', 'true'));
        } elseif ($miles_label == 'Kms') {
            echo 'Kms: ';
            echo '</span>';
            echo esc_html(get_post_meta(get_the_ID(), 'car-miles', 'true'));
        }
        */






          $miles_label = get_option('CarDealer_measure', 'Miles');
          if ($miles_label == 'Miles') {
            echo esc_attr__('Miles', 'cardealer') . ': ';
            echo '</span>';
            echo esc_html(get_post_meta(get_the_ID(), 'car-miles', 'true'));
          } elseif ($miles_label == 'Hours') {
            echo esc_attr__('Hours', 'cardealer') . ': ';
            echo '</span>';
            echo esc_html(get_post_meta(get_the_ID(), 'car-miles', 'true'));
          } elseif ($miles_label == 'Kms') {
            echo  esc_attr__('Kms', 'cardealer') . ': ';
            echo '</span>';
            echo esc_html(get_post_meta(get_the_ID(), 'car-miles', 'true'));
          }
          ?>

      </div>




      <div class="multiBasicRow"><span class="singleInfo"><?php echo esc_attr__('Cond', 'cardealer'); ?>: </span><?php echo esc_html(get_post_meta(get_the_ID(), 'car-con', 'true')); ?></div>
      <div class="multiBasicRow"><span class="singleInfo">
          <?php

          if ($CarDealer_hp_or_kw == 'hp') {
            echo esc_attr__('HP', 'cardealer');
          ?>:&nbsp; </span><?php echo esc_html(get_post_meta(get_the_ID(), 'car-hp', 'true'));
                          } else {
                            echo esc_attr__('KW', 'cardealer'); ?>:&nbsp;</span><?php echo esc_html(get_post_meta(get_the_ID(), 'car-hp', 'true'));
                                                                              }
                                                                                ?>
      </div>
    </div>
    <?php if (is_array($terms))
      echo '</div>';
    ?>
  </div>
  <?php }
function cardealer_detail()
{
  echo '<div class="multi-content">';
  while (have_posts()) : the_post();
    cardealer_top_detail();
    cardealer_content_info();
  ?>
    <div class="multicontentWrap">
      <?php cardealer_content_detail(); ?>
    </div><?php
          break;
        endwhile; // end of the loop.
        echo '</div>';
      }
      function cardealer_top_detail()
      {
        global $cardealer_the_title;


        $cardealer_the_title = get_the_title();
        define('CARDEALERSINGLE_TITLE', $cardealer_the_title);

        $price = get_post_meta(get_the_ID(), 'car-price', true);
        if ($price <> '' and $price != '0') {
          $price =   number_format_i18n($price, 0);
          $price = cardealer_get_currency_symbol() . $price;
        } else
          $price =  __('Call for Price', 'cardealer');
        $year = get_post_meta(get_the_ID(), 'car-year', 'true');
        if (!empty($year))
          $year = __('Year', 'cardealer') . ': ' . $year;
          ?>
  </div>
  <div class="multi-top-container">
    <div class="multi-detail-title"> <?php echo esc_attr(CARDEALERSINGLE_TITLE); ?> </div>
    <div class="multi-price-single"> <?php echo esc_attr($price); ?> </div>
    <div class="multi-detail-year"><?php echo esc_attr($year)  ?> </div>
    <?php
        $terms3 = get_the_terms(get_the_id(), 'locations');
        if (isset($terms3[0])) {
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
<?php }
      require_once(CARDEALERPATH . "assets/php/cardealer_mr_image_resize.php");
      function CarDealer_theme_thumb($url, $width, $height = 0, $align = '')
      {
        if (get_the_post_thumbnail() == '') {
          $url = CARDEALERIMAGES . 'image-no-available.jpg';
        }
        return cardealer_mr_image_resize($url, $width, $height, true, $align, false);
      }
