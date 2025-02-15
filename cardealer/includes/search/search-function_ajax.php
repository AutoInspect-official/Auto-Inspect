<?php
/**
 * @author Bill Minozzi
 * @copyright 2017
 */
if (! defined('ABSPATH')) exit; // Exit if accessed directly
function CarDealer_search_ajax($is_show_room)
{
    // global $postNumber, $wp, $post, $page_id, $cardealer_make, $meta_year;
    global $postNumber, $wp, $post, $page_id, $cardealer_make;
    global $cardealer_aMeta;
    // global $cardealer_make;
    foreach ($cardealer_aMeta as $meta) {
        // Verifica se a chave 'key' e 'value' existem no elemento atual
        if (isset($meta['key']) && isset($meta['value'])) {
            // Cria uma variável com o nome baseado na chave e atribui o valor correspondente
            ${$meta['key']} = $meta['value'];
        }
    }
    $meta_year = $year;
    $cardealer_make = $make;
    // Inicializa as variáveis de preço
    $priceMin = '';
    $priceMax = 9999999999;
    // Itera pela array para encontrar os valores de 'price' e 'price_max'
    foreach ($cardealer_aMeta as $meta) {
        if ($meta['key'] === 'price') {
            $price = $meta['value'];
            $pos = strpos($price, '-');
            if ($pos !== false) {
                $priceMin = trim(substr($price, 0, $pos - 1));
                $priceMax = trim(substr($price, $pos + 1));
            }
        } elseif ($meta['key'] === 'price_max') {
            // $priceMax = $meta['value'];
        }
    }
    // Converte as variáveis para inteiros
    $priceMin = (int)$priceMin;
    $priceMax = (int)$priceMax;
    $my_title = __("Search", 'cardealer');
    if ($is_show_room == '0') // widget
    {
        $searchlabel = 'search-label-widget';
        $selectboxmeta = 'cardealer-select-box-meta-widget';
        $selectbox = 'select-box-widget';
        $inputbox = 'input-box-widget';
        $searchItem = 'searchItem-widget';
        $searchItem2 = 'searchItem2-widget';
        $CarDealersubmitwrap = 'cardealer-submitBtn-widget';
        $CarDealer_search_box = 'cardealer-search-box-widget';
        $current_page_url = esc_url(home_url() . '/CarDealer_show_room_2/');
        $CarDealer_search_type = 'search-widget';
        $cardealer_afieldsId = cardealer_get_fields('widget');
        $cardealer_container_buttons_search = 'cardealer_container_buttons_search_widget';
    } elseif ($is_show_room == '1') // pag
    {
        $searchlabel = 'cardealer-search-label';
        $selectboxmeta = 'cardealer-select-box-meta';
        $selectbox = 'select-box';
        $inputbox = 'input-box';
        $searchItem = 'searchItem';
        $searchItem2 = 'searchItem';
        $CarDealersubmitwrap = 'cardealer-submitBtn';
        $CarDealer_search_box = 'cardealer-search-box';
        $current_page_url = home_url(esc_url(add_query_arg(null, null)));
        $CarDealer_search_type = 'page';
        $cardealer_afieldsId = cardealer_get_fields('search');
        $cardealer_container_buttons_search = 'cardealer_container_buttons_search';
    } elseif ($is_show_room == '2') // search result
    {
        $searchlabel = 'cardealer-search-label';
        $selectboxmeta = 'select-box-meta';
        $selectbox = 'select-box';
        $inputbox = 'input-box';
        $searchItem = 'searchItem';
        $searchItem2 = 'searchItem';
        $CarDealersubmitwrap = 'cardealer-submitBtn';
        $CarDealer_search_box = 'cardealer-search-box';
        $current_page_url = esc_url(home_url() . '/CarDealer_show_room_2/');
        $CarDealer_search_type = 'search-widget';
        $cardealer_afieldsId = cardealer_get_fields('search');
        $cardealer_container_buttons_search = 'cardealer_container_buttons_search';
    }
    //  $showsubmit = false; 
    $totfields = count($cardealer_afieldsId);
    $cardealer_aMetadataoptions = array();
    $output = '<div id="' . $CarDealer_search_box . '" class="' . $CarDealer_search_box . '">';
    $output .= '<div class="cardealer-search-cuore">';
    $output .= '<div class="cardealer-search-cuore-fields">';
    // $output .= '<form method="get" id="searchform3" action="' . $current_page_url . '">';
    $output .= '<form method="get" id="searchform3" action="' . $current_page_url . '" onsubmit="return false;">';
    if (isset($page_id)) {
        if ($page_id <> '0') {
            $output .= '        <input type="hidden" name="page_id" value="' . $page_id .
                '" />';
        }
    }
    $showsubmit = false;
    // container of buttons...
    $output .= '<div class="' . $cardealer_container_buttons_search . '">';
    // Make
    if ((trim(get_option('CarDealer_show_make', 'yes')) == 'yes' and $is_show_room !=
        0) or (trim(get_option('CarDealer_widget_show_make', 'yes')) == 'yes' and $is_show_room ==
        0)) {
        $showsubmit = true;
        $output .= '	 
     					<div class="' . $searchItem . '">
    						<span class="' . $searchlabel . '">' . __('Make', 'cardealer') .
            '</span>';
        if ($is_show_room <> 0)
            $output .= '<div id="bdp_oneline"></div>';
        $output .= ' 
                            <select class="' . $selectboxmeta .
            '" name="meta_make">
    							<option ' . (($cardealer_make == '') ? 'selected="selected"' : '') .
            ' value =""> ' . __('Any', 'cardealer') . ' </option>';
        $amakes = cardealer_car_get_makes();
        $qmakes = count($amakes);
        for ($i = 0; $i < $qmakes; $i++) {
            $output .= '<option ' . (($cardealer_make == trim($amakes[$i])) ? 'selected="selected"' :
                '') . '  value ="' . $amakes[$i] . '"> ' . $amakes[$i] . '</option>';
        }
        $output .= '</select></div>';
    }
    // end make
    // year
    if ((trim(get_option('CarDealer_show_year', 'yes')) == 'yes' and $is_show_room !=
        0) or (trim(get_option('CarDealer_widget_show_year', 'yes')) == 'yes' and $is_show_room ==
        0)) {
        $showsubmit = true;
        $output .= ' 
    					<div class="' . $searchItem2 . '">
    						<span class="' . $searchlabel . '">' . __('Year', 'cardealer') .
            '</span>';
        if ($is_show_room <> 0)
            $output .= '<div id="bdp_oneline"></div>';
        $output .= '           <select class="' . $selectboxmeta . '" name="meta_year">
    							<option value =""> ' . __('Any', 'cardealer') . ' </option>';
        $_year = gmdate("Y") + 1;
        $w = 50;
        for ($i = 0; $i <= $w; $i++) {
            $year = $_year - $i;
            $output .= '<option ';
            if ($meta_year == $year)
                $output .= 'selected="selected"';
            $output .= 'value ="';
            $output .= $year;
            $output .= '">';
            $output .= $year;
            $output .= '</option>';
        }
        $output .= '</select>
    					</div><!--end of item -->';
    }
    // Transmission
    if ((trim(get_option('CarDealer_show_transmission', 'yes')) == 'yes' and $is_show_room !=
        0) or (trim(get_option('CarDealer_widget_show_transmission', 'yes')) == 'yes' and
        $is_show_room == 0)) {
        $showsubmit = true;
        $output .= ' <div class="' . $searchItem . '">
    						<span class="' . $searchlabel . '">' . __('Transmission', 'cardealer') .
            '</span>';
        if ($is_show_room <> 0)
            $output .= '<div id="bdp_oneline"></div>';
        $output .= '<select class="' . $selectboxmeta . '" name="meta_trans">
    							<option ' . (($trans == '') ? 'selected="selected"' :
            '') . ' value =""> ' . __('Any', 'cardealer') . ' </option>
    							<option ' . (($trans ==  __("Automatic", "cardealer")) ?
            'selected="selected"' : '') . '  value ="' . __("Automatic", "cardealer") . '"> ' . __(
            'Automatic',
            'cardealer'
        ) . '</option>
    							<option ' . (($trans == __("Manual", "cardealer")) ?
            'selected="selected"' : '') . '  value ="' . __("Manual", "cardealer") . '"> ' . __('Manual', 'cardealer') .
            '</option>
    							<option ' . (($trans == __("Tiptronic", "cardealer")) ?
                'selected="selected"' : '') . '  value ="' . __("Tiptronic", "cardealer") . '"> ' . __(
                'Tiptronic',
                'cardealer'
            ) . '</option>
    						</select>  
    					</div>';
    }
    // Fuel
    if ((trim(get_option('CarDealer_show_fuel', 'yes')) == 'yes' and $is_show_room !=
        0) or (trim(get_option('CarDealer_widget_show_fuel', 'yes')) == 'yes' and $is_show_room ==
        0)) {
        $showsubmit = true;
        $output .= ' <div class="' . $searchItem . '">
    						<span class="' . $searchlabel . '">' . __('Fuel', 'cardealer') .
            '</span>';
        if ($is_show_room <> 0)
            $output .= '<div id="bdp_oneline"></div>';
        $output .= '<select class="' . $selectboxmeta . '" name="meta_fuel">
    							<option ' . (($fuel == '') ? 'selected="selected"' :
            '') . ' value =""> ' . __('Any', 'cardealer') . ' </option>
    							<option ' . (($fuel == __("Diesel", "cardealer")) ?
            'selected="selected"' : '') . '  value ="' . __("Diesel", "cardealer") . '"> ' . __('Diesel', 'cardealer') .
            '</option>
    							<option ' . (($fuel == __("Gasoline", "cardealer")) ?
                'selected="selected"' : '') . '  value ="' . __("Gasoline", "cardealer") . '"> ' . __(
                'Gasoline',
                'cardealer'
            ) . '</option>
    							<option ' . (($fuel == __("Hybrid", "cardealer")) ?
                'selected="selected"' : '') . '  value ="' . __("Hybrid", "cardealer") . '"> ' . __('Hybrid', 'cardealer') .
            '</option>
    							<option ' . (($fuel == __("Electric", "cardealer")) ?
                'selected="selected"' : '') . '  value ="' . __("Electric", "cardealer") . '"> ' . __(
                'Electric',
                'cardealer'
            ) . '</option>
     							<option ' . (($fuel == __("Biodiesel", "cardealer")) ?
                'selected="selected"' : '') . '  value ="' . __("Biodiesel", "cardealer") . '"> ' . __(
                'Biodiesel',
                'cardealer'
            ) . '</option>       
      							<option ' . (($fuel == 'CNG') ?
                'selected="selected"' : '') . '  value ="CNG"> ' . __('CNG', 'cardealer') .
            '</option>        
      							<option ' . (($fuel == __("Ethanol", "cardealer")) ?
                'selected="selected"' : '') . '  value ="' . __("Ethanol", "cardealer") . '"> ' . __('Ethanol', 'cardealer') .
            '</option>        
    							<option ' . (($fuel == __("Other", "cardealer")) ?
                'selected="selected"' : '') . '  value ="' . __("Other", "cardealer") . '"> ' . __('Other', 'cardealer') .
            '</option>
    						</select>  
    					</div>';
    }
    for ($i = 0; $i < $totfields; $i++) {
        $post_id = $cardealer_afieldsId[$i];
        $cardealer_aMetadata = cardealer_get_meta($post_id);
        // die(var_dump($cardealer_aMetadata));
        $field_value = array(
            'field_label', // 0
            'field_typefield', // 1
            'field_drop_options', // 2
            'field_searchbar', // 3
            'field_searchwidget', //4
            'field_rangemin', // 5
            'field_rangemax', //6
            'field_rangestep', // 7
            'field_slidemin', // 8
            'field_slidemax', // 9
            'field_slidestep', // 10
            'field_order', // 11
            'field_name'
        ); // 12
        if (!empty($cardealer_aMetadata[0]))
            $search_label = $cardealer_aMetadata[0];
        else
            $search_label = $cardealer_aMetadata[12];
        //12 => string 'type' (length=4)
        $search_name = $cardealer_aMetadata[12];
        // $meta = 'meta_' . $cardealer_aMetadata[12];
        $search_key  = $cardealer_aMetadata[12];
        // Procurando pelo valor correspondente à chave 'make'
        foreach ($cardealer_aMeta as $meta) {
            if ($meta['key'] == $search_key) {
                $meta_value = $meta['value'];
                //echo $result_value;  // Exibe 'Fiat' (o valor da chave 'make')
                break;  // Para o loop após encontrar o primeiro item correspondente
            }
        }
        $typefield = $cardealer_aMetadata[1];
        // Dropdown
        if ($typefield == 'dropdown') {
            $showsubmit = true;
            $output .= '<div class="' . $searchItem . '">';
            $output .= '<span class="' . $searchlabel . '">' . esc_html($search_label) . '</span>';
            if ($is_show_room <> 0)
                $output .= '<div id="bdp_oneline"></div>';
            $output .= '<select class="' . $selectboxmeta . '" name="' . $meta . '">';
            $options = explode("\n", $cardealer_aMetadata[2]);
            $output .= '<option value="All">' . __('Any', 'cardealer') . '</option>';
            foreach ($options as $option) {
                $output .= '<option ';
                // era $con...
                if (trim($meta_value) == trim($option)) {
                    $output .= ' selected="selected" ';
                }
                $output .= '>' . esc_html($option) . '</option>';
            }
            $output .= '</select>';
            $output .= '</div>'; // SearchItem;
        } // end Dropdown
        // Select Range
        if ($typefield == 'rangeselect') {
            $showsubmit = true;
            $output .= '<div class="' . $searchItem . '">';
            $output .= '<span class="' . $searchlabel . '">' . $search_label . '</span>';
            if ($is_show_room <> 0)
                $output .= '<div id="bdp_oneline"></div>';
            $output .= '<select class="' . $selectboxmeta . '" name="' . $meta . '">';
            $init = $cardealer_aMetadata[5];
            $max = $cardealer_aMetadata[6];
            $step = $cardealer_aMetadata[7];
            $options = array();
            $output .= '<option value="All">' . __('Any', 'cardealer') . '</option>';
            for ($z = $init; $z <= $max; $z += $step) {
                $option = $z;
                $output .= '<option ' . ($con == $option ?
                    ' selected="selected"' : '') . '>' . $option . '</option>';
            }
            $output .= '</select>';
            $output .= '</div>'; // SearchItem;
        } // end Dropdown       
        // Checkbox
        if ($typefield == 'checkbox') {
            $showsubmit = true;
            $output .= '<div class="' . $searchItem . '">';
            $output .= '<span class="' . $searchlabel . '">' . $search_label . '</span>';
            if ($is_show_room <> 0)
                $output .= '<div id="bdp_oneline"></div>';
            $output .= '<select class="' . $selectboxmeta . '" name="' . $meta . '">';
            $output .= '<option value = "All" ' . ($con == 'All' ? ' selected="selected"' : '') . '>' . __('Any', 'cardealer') . '</option>';
            $output .= '<option value = "enabled" ' . ($con == "enabled"  ? ' selected="selected"' : '') . '>Yes</option>';
            $output .= '<option value = "" ' . ($con == '' ? ' selected="selected"' : '') . '>No</option>';
            $output .= '</select>';
            $output .= '</div>'; // SearchItem;
        } // end Checkbox
    } // end Loop 
    // Order by
    if ((trim(get_option('CarDealer_show_orderby', 'yes')) == 'yes' and $is_show_room !=
        0) or (trim(get_option('CarDealer_widget_show_orderby', 'yes')) == 'yes' and $is_show_room ==
        0)) {
        $showsubmit = true;
        /*
        if (isset($_POST['meta_order']))
            $order = sanitize_text_field($_POST['meta_order']);
        else
            $order = '';
        $order = sanitize_text_field($order);
        */
        $output .= ' <div class="' . $searchItem . '">
    						<span class="' . $searchlabel . '">' . __('Order By', 'cardealer') .
            '</span>';
        if ($is_show_room <> 0)
            $output .= '<div id="bdp_oneline"></div>';
        $output .= '<select class="' . $selectboxmeta .
            '" name="meta_order" style="min-width: 120px;">
    							<option ' . (($order == '') ? 'selected="selected"' :
                '') . ' value =""> ' . __('Any', 'cardealer') . ' </option>
    							<option ' . (($order == 'year_high') ?
                'selected="selected"' : '') . '  value ="year_high"> ' . __(
                'Year newest first',
                'cardealer'
            ) . '</option>
    							<option ' . (($order == 'year_low') ?
                'selected="selected"' : '') . '  value ="year_low"> ' . __(
                'Year oldest first',
                'cardealer'
            ) . '</option>
    							<option ' . (($order == 'price_high') ?
                'selected="selected"' : '') . '  value ="price_high"> ' . __(
                'Price higher first',
                'cardealer'
            ) . '</option>
    							<option ' . (($order == 'price_low') ?
                'selected="selected"' : '') . '  value ="price_low"> ' . __(
                'Price lower first',
                'cardealer'
            ) . '</option>
    							<option ' . (($order == 'mileage_high') ?
                'selected="selected"' : '') . '  value ="mileage_high"> ' . __(
                'Mileage higher first',
                'cardealer'
            ) . '</option>
    							<option ' . (($order == 'mileage_low') ?
                'selected="selected"' : '') . '  value ="mileage_low"> ' . __(
                'Mileage lower first',
                'cardealer'
            ) . '</option>
    						</select>  
    					</div>';
    }
    $output .= '</div>'; // end container buttons
    // Slider
    if ($is_show_room == '0')
        $showslider =  trim(get_option('CarDealer_widget_show_price', 'yes'));
    else
        $showslider =  trim(get_option('CarDealer_show_price', 'yes'));
    if ($showslider == 'yes') {
        $showsubmit = true;
        $max_car_value = cardealer_get_max();
        //die(var_dump($max_car_value));
        if ($is_show_room != '0') // no widget
        {
            $output .= '<div id="cardealer-price-slider" class="cardealer-price-slider">';
            $output .= '<div id="cardealer-price-slider-label">';
            $output .= '<span class="cardealerlabelprice">' . __('Price Range', 'cardealer') . '</span>';
            $output .= '<input type="text" name="meta_price" id="meta_price" readonly>';
            // slider
            if ($is_show_room == '1')
                $output .= '<div id="price" class="cardealerslider" ></div>';
            else
                $output .= '<div id="price" class="cardealerslider" style="margin-top:0px;" ></div>';
            $output .= '<input type="hidden" name="meta_price_max" id="meta_price_max" value="' . $max_car_value . '">';
            $output .= '</div>'; // id="cardealer-price-slider-label">'; 
            $output .= '<input type="hidden" name="choice_price_min" id="choice_price_min" value="' .
                $priceMin . '">';
            $output .= '<input type="hidden" name="choice_price_max" id="choice_price_max" value="' .
                $priceMax . '">';
            // tinha so um end div demais aqui.... 2023
            // $output .= '</div>';
            $output .= '</div>';
        }  // show room != 0 
        if ($is_show_room == '0') // widget
        {
            $output .= '<div class="cardealer-price-slider2">';
            $output .= '<span class="cardealerlabelprice2">' . __('Price', 'cardealer') . '</span>';
            $output .= '<input type="text" name="meta_price2" id="meta_price2" readonly>';
            $output .= '<div id="price2" class="cardealerslider" "></div>';
            $output .= '<input type="hidden" name="meta_price_max2" id="meta_price_max2" value="' . $max_car_value . '">';
            $output .= '<input type="hidden" name="choice_price_min2" id="choice_price_min2" value="' .
                $priceMin . '">';
            $output .= '<input type="hidden" name="choice_price_max2" id="choice_price_max2" value="' .
                $priceMax . '">';
            $output .= '</div>';
        }  // show room = 0 
    } // End Slider  
    // Submit
    if ($showsubmit) {
        $output .= '<div class="cardealer-submitBtnWrap">';
        $output .= '<input type="submit" name="submit" id="' . $CarDealersubmitwrap .
            '" value=" ' . __('Search', 'cardealer') . '" />';
        $output .= '</div>';
        $output .= '<input type="hidden" name="CarDealer_post_type" value="cars" />';
        $output .= '<input type="hidden" name="postNumber" value="' . $postNumber .
            '" />';
        $output .= '<input type="hidden" name="CarDealer_search_type" value="' . $CarDealer_search_type .
            '" />';
    }
    $output .= '</form></div></div></div>  <!-- end of Basic -->';
    return $output;
}
