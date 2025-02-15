<?php
/**
 * @author Bill Minozzi
 * @copyright 2017
 * search gallery
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
$CarDealer_template_single = '4';
$display_sidebar = (get_option('sidebar_search_page_result', 'no') == 'yes') ? '#secondary, .sidebar-container { display: none !important; }' : '';
// Construa o CSS como uma string
$output = <<<CSS
<style type="text/css">
    <!-- 
    {$display_sidebar}
    #main {
        width: 100% !important;
        position: absolute;
    }
    -->
</style>
CSS;
//var_dump($wp_query->have_posts());
$output = '<div style="margin-top: 20px;">';
$output .= '<div id="cardealer_container_search">';
$output .= '<div id="cardealer_content">';
$CarDealer_measure = get_option('CarDealer_measure', 'M2');
$ctd = 0;
//$output .= '<br><hr>';
$output .= '<div class="modal-content">';
$output .= '</div>';
$output .= '<div class="carGallery">';
$output .= '<div class="CarDealer_container">';
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
       // $output .= '<a href="#myModal-' . $post_id . '" class="open-modal">';
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
    // $output .= ($hp <> '' ? $hp . ' ' . __('HP', 'cardealer') . '<br />' : '');
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
    $miles_label = get_option("CarDealer_measure", "Miles");
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
    $output .= '<div class="carTitle">' . get_the_title() . '</div>';
    $output .= '</a>';
    $CarDealer_template_single = '5';
    if ($CarDealer_template_single == '4') {
        $CarDealer_modal_size = '900';
        $output .= '
            <!-- Modal -->
            <div class="modal fade"  id="myModal-' . $post_id . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" style="width: 90%; max-width:' . $CarDealer_modal_size . 'px;"  role="document">
                 <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <!--  <h4 class="modal-title" id="myModalLabel">Single Car Page</h4> -->
                </div>
                <div class="modal-body">';
        // $output .= cardealer_detail($post_id);
        $output .= '
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
            </div>
            ';
    }
    $output .= '</div>';
    $output .= '</div>';
    if ($ctd < $qposts) {
        if ($ctd % 3 == 0) {
            $output .= '</div>';
            $output .= '<div class="CarDealer_container">';
        }
    }
endwhile;
// wp_reset_postdata();
$output .= '</div>';
$output .= '<br/> <br/>';
/*
ob_start();
the_posts_pagination(array(
    'mid_size' => 2,
    'prev_text' => __('Back', 'cardealer'),
    'next_text' => __('Onward', 'cardealer'),
));
$output .= ob_get_contents();
ob_end_clean();
*/
ob_start();
// Obtém o número total de posts
$total_posts = $qtotalposts;
// echo 'Total de Posts: ' . $total_posts . '<br>'; // Depuração
// Verifique o número de posts por página
$postNumber = (isset($postNumber) && is_numeric($postNumber)) ? $postNumber : 3; // Defina um valor padrão, caso necessário
// echo 'Posts por Página: ' . $postNumber . '<br>'; // Depuração
$total_pages = ceil($total_posts / $postNumber); // Calcula o total de páginas
// echo 'Total de Páginas: ' . $total_pages . '<br>'; // Depuração
// Se houver mais de uma página, exibe a navegação
if ($total_pages > 1) {
    $current_page = max(1, $paged); // Página atual ou 1 se não estiver setada
    // echo 'Página Atual: ' . $current_page . '<br>'; // Depuração
    $range = 2; // Número de páginas antes e depois da página atual
    // echo 'Intervalo de Páginas (range): ' . $range . '<br>'; // Depuração
    $show_prev = ($current_page > 1); // Exibe o botão "Back" se não for a primeira página
    // echo 'Mostrar "Back": ' . ($show_prev ? 'Sim' : 'Não') . '<br>'; // Depuração
    $show_next = ($current_page < $total_pages); // Exibe o botão "Onward" se não for a última página
    // echo 'Mostrar "Onward": ' . ($show_next ? 'Sim' : 'Não') . '<br>'; // Depuração
    $output .= '<div id="cardealer-pagination">';
    // Botão "Back"
    if ($show_prev) {
        $output .= '<a href="?page=' . ($current_page - 1) . '" class="page-link" data-page="' . ($current_page - 1) . '">' . __('Back', 'cardealer') . '</a>';
    }
    // Exibe os links das páginas de forma limitada
    for ($i = max(1, $current_page - $range); $i <= min($total_pages, $current_page + $range); $i++) {
        // Se for a página atual, não cria o link, apenas exibe o número
        if ($i == $current_page) {
            $output .= '<span class="page-link current">' . $i . '</span>';
        } else {
            // Se não for a página atual, cria o link
            $output .= '<a href="?page=' . $i . '" class="page-link" data-page="' . $i . '">' . $i . '</a>';
        }
    }
    // Botão "Onward"
    if ($show_next) {
        $output .= '<a href="?page=' . ($current_page + 1) . '" class="page-link" data-page="' . ($current_page + 1) . '">' . __('Onward', 'cardealer') . '</a>';
    }
    $output .= '</div>';
} else {
    // Se houver 1 ou menos posts, não exibe a paginação
    // echo 'Nenhuma página a ser exibida';
}
$output .= ob_get_contents();
ob_end_clean();
$output .= '</div>';
$output .= '</div>';
//wp_reset_postdata();
// echo $output;
$registered_sidebars = wp_get_sidebars_widgets();
if (get_option('sidebar_search_page_result', 'no') == 'yes') {
    foreach ($registered_sidebars as $sidebar_name => $sidebar_widgets) {
        unregister_sidebar($sidebar_name);
    }
}
$output .= '</div>';  // cardealer_container_search
