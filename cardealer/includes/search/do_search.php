<?php

/**
 * @author Bill Minozzi
 * @copyright  2024
 * List View Search
 */
if (!defined("ABSPATH")) {
    exit();
}
/*
>>>>>> NA PAGINA TEMPL3, VERIFIQUE CANPOS CHECKBOX...
*/
// Verifica se é um tema FSE
if (wp_is_block_theme()) {
    //
}
function cardealer_single_car_ajax()
{
    ob_start();
    $post_id = $_POST['post_id'];
    $post = get_post($post_id);
    // die(var_export(__LINE__));
    if ($post) {
        echo '<div class="modal-overlay22"></div>';  // Overlay
        echo '<div class="modal-container22">';
        echo '<button class="close-modal22">Close</button>';
        echo '<br>';
        function cardealer_enqueue_flexslider_public()
        {
            if (!wp_script_is('jquery', 'enqueued')) {
                wp_enqueue_script('jquery');
            }
            // Carrega o script apenas para a parte pública
            wp_register_script('flexslider22', CARDEALERURL . 'includes/gallery/js/jquery.flexslider-min.js', array('jquery'), null, true);
            wp_enqueue_script('flexslider22');
        }
        add_action('wp_enqueue_scripts', 'cardealer_enqueue_flexslider_public', 1);
        function cardealer_enqueue_flexslider_admin($hook)
        {
            if (!wp_script_is('jquery', 'enqueued')) {
                wp_enqueue_script('jquery');
            }
            // Carrega o script apenas no painel de administração
            wp_register_script('flexslider23', CARDEALERURL . 'includes/gallery/js/jquery.flexslider-min.js', array('jquery'), null, true);
            wp_enqueue_script('flexslider23');
        }
        add_action('admin_enqueue_scripts', 'cardealer_enqueue_flexslider_admin', 1);
        $CarDealer_overwrite_gallery = strtolower(get_option(
            'CarDealer_overwrite_gallery',
            'yes'
        ));
        if ($CarDealer_overwrite_gallery == 'yes')
            require_once(CARDEALERPATH . 'includes/gallery/gallery.php');
        include(CARDEALERPATH . 'includes/templates/template-single.php');
        echo '</div>';
        $output = ob_get_clean();

        //die($output);


        $allowed_html = array(
            'div' => array(
                'class' => array(),
                'id' => array(),
                'style' => array(),
            ),
            'span' => array(
                'class' => array(),
            ),
            'a' => array(
                'href' => array(),
                'class' => array(),
                'data-toggle' => array(),
                'data-target' => array(),
            ),
            'img' => array(
                'src' => array(),
                'class' => array(),
                'alt' => array(),
            ),
            'input' => array(
                'type' => array(),
                'class' => array(),
                'id' => array(),
                'value' => array(),
                'onclick' => array(),
            ),
            'button' => array(
                'type' => array(),
                'class' => array(),
                'data-toggle' => array(),
                'data-target' => array(),
            ),
            'ul' => array(
                'class' => array(),
                'id' => array(),
                'data-*' => array(),
            ),
            'li' => array(
                'class' => array(),
                'data-*' => array(),
            ),
            'br' => array(),
            'h4' => array(),
            'style' => array(),
        );
        //wp_die(wp_kses($output, $allowed_html));
        // Bloqueia o flexslider.
        wp_die($output);

    }
    return;
}

function cardealer_search_cars_ajax()
{
    global $cardealer_aMeta;
    global $wp_query;
    parse_str($_POST['form_data'], $form_data);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verifica se a string de consulta 'form_data' está definida
        if (isset($_POST['form_data'])) {
            $form_data = $_POST['form_data'];
            if (!empty($form_data)) {
                parse_str($form_data, $queryArray);
                $cardealer_aMeta = [];
                foreach ($queryArray as $key => $value) {
                    $$key = $value;
                    // Verifica se a chave começa com 'meta_'
                    if (strpos($key, 'meta_') === 0) {
                        // Remove o prefixo 'meta_' da chave
                        $filterKey = substr($key, 5);
                        $cardealer_aMeta[] = [
                            'key' => $filterKey, // Chave sem o prefixo
                            'value' => $value    // Valor correspondente
                        ];
                    }
                }
            } else {
                //echo "A string de consulta está vazia.<br>";
            }
        } else {
            //echo "Nenhum dado foi recebido.<br>";
        }
    } else {
        echo "Not POST.<br>";
    }
    foreach ($cardealer_aMeta as $meta) {
        // Verifica se a chave 'key' e 'value' existem no elemento atual
        if (isset($meta['key']) && isset($meta['value'])) {
            // Cria uma variável com o nome baseado na chave e atribui o valor correspondente
            ${$meta['key']} = $meta['value'];
        }
    }
    foreach ($cardealer_aMeta as $item) {
        // Verifica se o primeiro elemento é 'order'
        if (isset($item[0]) && $item[0] === 'order') {
            // Pega o valor do segundo elemento
            $order = isset($item[1]) ? $item[1] : null;
            // Exibe ou faz o que for necessário com o valor
            //  echo $second_element_value;
            break; // Se você só precisa do primeiro item encontrado
        }
    }
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



    global $wp;
    global $query, $wp_query, $CarDealer_hp_or_kw;
    $wp_query->is_404 = false;
    $cardealer_afieldsId = cardealer_get_fields("all");
    $totfields = count($cardealer_afieldsId);
    $afilter = [];
    // Loop para construir a estrutura desejada
    foreach ($cardealer_aMeta as $x) {
        $excludedValues = ['', 'All', '0', '0 - 60000', '60000', 'year_high', "price_high", "price_low", "year_high", "year_low", "mileage_high", "mileage_low"];
        $excludedKeys = ['car_price', 'price', 'make']; // Defina as keys que você quer excluir
        if (!in_array($x['value'], $excludedValues) && !in_array($x['key'], $excludedKeys)) {
            // Inicializa a variável key
            $key = 'car-' . $x['key']; // Acessa a chave da entrada em cardealer_aMeta
            // Verifica se a chave é 'car-trans' e altera para 'transmission-type'
            if ($key === 'car-trans') {
                $key = 'transmission-type'; // Substitui a chave
            }
            $afilter[] = [
                'key' => $key,            // Acessa a chave da entrada em cardealer_aMeta
                'value' => $x['value']    // Acessa o valor da entrada em cardealer_aMeta
            ];
        }
    }
    if ($price != "") {
        $afilter[] = [
            // array(
            "relation" => "OR",
            [
                "key" => "car-price",
                "value" => [$priceMin, $priceMax],
                "type" => "numeric",
                "compare" => "BETWEEN",
            ],
            [
                "key" => "car-price",
                "value" => "0",
                "type" => "numeric",
                "compare" => "=",
            ],
        ];
    } // end meta_price
    if (!empty($order)) {
        if ($order == "price_high") {
            $wmetakey = "car-price";
            $wmetaorder = "DESC";
        }
        if ($order == "price_low") {
            $wmetakey = "car-price";
            $wmetaorder = "ASC";
        }
        if ($order == "year_high") {
            $wmetakey = "car-year";
            $wmetaorder = "DESC";
        }
        if ($order == "year_low") {
            $wmetakey = "car-year";
            $wmetaorder = "ASC";
        }
        if ($order == "mileage_high") {
            $wmetakey = "car-miles";
            $wmetaorder = "DESC";
        }
        if ($order == "mileage_low") {
            $wmetakey = "car-miles";
            $wmetaorder = "ASC";
        }
    } // no order
    $paged = isset($paged) ? $paged : null;  // Se $paged não estiver definido, assume null
    // Verificar se $paged é um valor válido (número inteiro)
    if (is_numeric($paged) && (int) $paged == $paged) {
        $paged = (int) $paged;  // Converte para inteiro
    } else {
        $paged = 1;  // Se não for válido, define como 1
    }
    $args = array(
        'post_type' => 'cars',
        'posts_per_page' => -1,  // Usando 'posts_per_page' em vez de 'showposts'
        'paged' => 1,       // Certifique-se de que a variável $paged está sendo corretamente definida
    );
    $args['meta_query'] = $afilter;  // Aqui $afilter deve ser um array válido de 'meta_query'
    // Se houver uma ordenação personalizada
    if (!empty($order)) {
        $args['orderby'] = 'meta_value';
        $args['meta_type'] = 'NUMERIC';
        $args['meta_key'] = $wmetakey; // Defina o meta_key para ordenar
        $args['order'] = $wmetaorder; // Ordem crescente ou decrescente
    }
    if (!empty($make) and $make != "Any") {
        $args["tax_query"] = [
            [
                "taxonomy" => "makes",
                "field" => "name",
                "terms" => $make,
            ],
        ];
    }



    
    wp_reset_query();
    $wp_query = new WP_Query($args);
    if (! $wp_query->have_posts()) {
        die(__('No posts found', 'cardealer').'<br>');
    }
    $qtotalposts = $wp_query->post_count;
    $postNumber = get_option('CarDealer_quantity', 6);
    // Verifique se a chave 'posts_per_page' existe e substitua seu valor.
    if (isset($args['posts_per_page'])) {
        $args['posts_per_page'] = $postNumber;  // Substitui o valor de 'posts_per_page' por $postNumber
    }
    // Verifique se a chave 'paged' existe e substitua seu valor
    if (isset($args['paged'])) {
        $args['paged'] = $paged;  // Substitui o valor de 'paged' pela variável $paged
    }
    wp_reset_query();
    $wp_query = new WP_Query($args);
    if (! $wp_query->have_posts()) {
        die('Query fail!');
        $output .= "<br /><h4>" . __("Not Found !", "cardealer") . "</h4>";
    } else {
        $qposts = $wp_query->post_count;
        $Cardealer_template_gallery = trim(get_option(
            'CarDealer_template_gallery',
            'yes'
        ));
        if ($Cardealer_template_gallery == 'yes')
            require_once(CARDEALERPATH . 'includes/templates/template-showroom2.php');
        else
            require_once(CARDEALERPATH . "includes/templates/template-showroom3.php");
    }
    $allowed_html = array(
        'div' => array(
            'class' => array(),
            'id' => array(),
            'style' => array(),
        ),
        'span' => array(
            'class' => array(),
        ),
        'a' => array(
            'href' => array(),
            'class' => array(),
            'data-toggle' => array(),
            'data-target' => array(),
        ),
        'img' => array(
            'src' => array(),
            'class' => array(),
            'alt' => array(),
        ),
        'input' => array(
            'type' => array(),
            'class' => array(),
            'id' => array(),
            'value' => array(),
            'onclick' => array(),
        ),
        'button' => array(
            'type' => array(),
            'class' => array(),
            'data-toggle' => array(),
            'data-target' => array(),
        ),
        'br' => array(),
        'h4' => array(),
        'style' => array(),
    );
    wp_die(wp_kses($output, $allowed_html));
}
