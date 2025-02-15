<?php
/**
 * @author Bill Minozzi
 * @copyright 2017 - 2020
 * List View Search
 */
if (!defined("ABSPATH")) {
    exit();
} // Exit if accessed directly
$output = <<<CSS
<style type="text/css">
    <!-- 
    <?php if (get_option("sidebar_search_page_result", "no") == "yes") { ?>#secondary,
    .sidebar-container {
        display: none !important;
    }
    <?php } ?>#main {
        width: 100% !important;
        position: absolute;
    }
    -->
</style>
CSS;
$output .= '<div style="margin-top: 20px;">';
$output .= '<div id="cardealer_container_search">';
$output .= '<div id="cardealer_content">';
$CarDealer_measure = get_option("CarDealer_measure", "M2");
$output .= '<div class="modal-content">';
$output .= '</div>';
$output .= '<div class="multiGallery">';
$ctd = 0;
while ($wp_query->have_posts()):
    $wp_query->the_post();
    $post_id = get_the_ID();
    // die($post_id);
    $ctd++;
    $price = get_post_meta(get_the_ID(), "car-price", true);
    if (!empty($price)) {
        $price = number_format_i18n($price, 0);
    }
    $image_id = get_post_thumbnail_id();
    if (empty($image_id)) {
        $image = CARDEALERIMAGES . "image-no-available-800x400_br.jpg";
        $image = str_replace("-", "", $image);
    } else {
        $image_url = wp_get_attachment_image_src($image_id, "medium", true);
        $image = str_replace(
            "-" . $image_url[1] . "x" . $image_url[2],
            "",
            $image_url[0]
        );
    }
    $CarDealer_thumbs_format = trim(get_option("CarDealer_thumbs_format", "1"));
    if ($CarDealer_thumbs_format == "2") {
        $thumb = CarDealer_theme_thumb($image, 300, 225, "br");
    }
    // Crops from bottom right
    else {
        $thumb = CarDealer_theme_thumb($image, 400, 200, "br");
    } // Crops from bottom right
    $year = get_post_meta(get_the_ID(), "car-year", true);
    $hp = get_post_meta(get_the_ID(), "car-hp", true);
    $year = get_post_meta(get_the_ID(), "car-year", true);
    $fuel = get_post_meta(get_the_ID(), "car-fuel", true);
    $transmission = get_post_meta(get_the_ID(), "transmission-type", true);
    $miles = get_post_meta(get_the_ID(), "car-miles", true);
    //$output .= '<br /><div class="CarDealer_container17">'
    $output .= '<div class="CarDealer_container17">';
    $output .= '<div class="CarDealer_gallery_17">';
    //$output .= '<a class="nounderline" href="' . get_permalink() . '">';
    $output .= '<a href="#myModal-' . $post_id . '" class="open-modal">';
    $output .= '<img class="CarDealer_caption_img17" src="' . $thumb . '" />';
    $output .= "</a>";
    $output .= "</div>";
    $output .= '<div class="multiInfoRight17">';
    //  $output .= '<a class="nounderline" href="' . get_permalink() . '">';
    //  $output .= '<div class="multiTitle17">' . get_the_title() . '</div>';
    $output .= '<a href="#myModal-' . $post_id . '" class="open-modal">';
    $output .= '<div class="multiTitle17">' . get_the_title() . "</div>";
    $output .= "</a>";
    $output .= '<div class="multiInforightText17">';
    $output .= '<div class="multiInforightbold">';
    $output .= '<div class="cardealer_smallblock">';
    //         $price = get_post_meta(get_the_ID(), 'car-price', true);
    if ($price != "" and $price != "0") {
        $price = cardealer_get_currency_symbol() . $price;
    } else {
        $price = __("Call for Price", "cardealer");
    }
    $output .= $price;
    $output .= "</div>";
    if ($hp != "") {
        $output .= '<div class="cardealer_smallblock">';
        $output .= '<span class="billcar-belt2">';
        if ($CarDealer_hp_or_kw == "hp") {
            $output .= " " . $hp . __("HP", "cardealer");
        } else {
            $output .= " " . $hp . __("KW", "cardealer");
        }
        $output .= "</div>";
    }
    if ($year != "") {
        $output .= '<div class="cardealer_smallblock">';
        $output .= '<span class="billcar-calendar">';
        $output .= " " . $year;
        $output .= "</div>";
    }
    if ($fuel != "") {
        $output .= '<div class="cardealer_smallblock">';
        $output .= '<span class="billcar-gas-station">';
        $output .= " " . $fuel;
        $output .= "</div>";
    }
    if ($transmission != "") {
        $output .= '<div class="cardealer_smallblock">';
        $output .= '<span class="billcar-gearshift">';
        $output .= " " . $transmission;
        $output .= "</div>";
    }
    $miles_label = get_option('CarDealer_measure', 'Miles');
    if ( $miles <> '' and null !== $miles_label ) {
        $output .= '<div class="cardealer_smallblock">';
        $output .= '<span class="billcar-dashboard">';
        $output .= " " . $miles . "  ";
            $miles_label = get_option('CarDealer_measure', 'Miles');
            if ($miles_label == 'Miles') {
                $output .= esc_attr__('Miles', 'cardealer') ;
            } elseif ($miles_label == 'Hours') {
                $output .= esc_attr__('Hours', 'cardealer') ;
            } elseif ($miles_label == 'Kms') {
                $output .=  esc_attr__('Kms', 'cardealer');
            }
        $output .= "</div>";
    }
    $content_post = get_post(get_the_ID());
    $desc = sanitize_textarea_field($content_post->post_content);
    $desc = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $desc);
    $output .= '<div class="cardealer_description">';
    $output .= substr($desc, 0, 100);
    if (substr($desc, 200) != "") {
        $output .= "...";
    }
    $output .= "</div>";
    $output .= "</div>";
    $output .= "</div>";
    $output .= "</a>";
    $output .= "</div>";
    $output .= '<input type="submit" value="' . __('View', 'cardealer') . '" class="btn btn-primary open-modal cardealer_btn_view" id="modal-submit-' . $post_id . '" />';
    $output .= "</div>";
endwhile;
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
$output .= "</div>";
$output .= "</div>";
wp_reset_postdata();
wp_reset_query();
if ($qposts < 1) {
    $output .= "<br /><h4>" . __("Not Found !", "cardealer") . "</h4>";
}
/*
$registered_sidebars = wp_get_sidebars_widgets();
if (get_option("sidebar_search_page_result", "no") == "yes") {
    foreach ($registered_sidebars as $sidebar_name => $sidebar_widgets) {
        unregister_sidebar($sidebar_name);
    }
}
*/
$output .= "</div>"; // cardealer_container_search
