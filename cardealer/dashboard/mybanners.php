<?php

namespace bill_banners;

/**
 * @author William Sergio Minossi
 * @copyright 26/11/2021-2023
 */
if (!defined("ABSPATH")) {
    die("Invalid request.");
}

echo '<ul>';


$x = rand(1, 3);
if ($x == 1) {
    $url = CARDEALERURL . "assets/videos/rallie.mp4";
    $title_ad = esc_attr__("Car Dealer Premium: More Features, More Control, More Sales!", "cardealer");
}
if ($x == 2) {
    $url = CARDEALERURL . "assets/videos/rallie2.mp4";
    $title_ad = esc_attr__("Access Advanced Features for Design and Car Filtering!", "cardealer");
}
if ($x == 3) {
    $url = CARDEALERURL . "assets/videos/rallie3.mp4";
    $title_ad = esc_attr__("Unlock the Full Potential of Your Showroom with Car Dealer Premium!", "cardealer");
}

echo '<h2>' . esc_attr($title_ad) . '</h2>';

?>

<video id="bill-banner-2" style="margin:-30px 0px -15px -12px; padding:0px;" width="400" height="230" muted>
    <source src="<?php echo esc_attr($url); ?>" type="video/mp4">
</video>
<li><?php esc_attr_e("Many Features are not included in the free version", "cardealer"); ?></li>
<li><?php esc_html_e("More Shortcodes to increase your control over the show room page", "cardealer"); ?></li>
<li><?php esc_html_e("Filter Cars for Type (Van, Sedan, and so on…)", "cardealer"); ?></li>
<li><?php esc_html_e("Last Cars and Featured Cars Page", "cardealer"); ?></li>
<li><?php esc_html_e("More Show Room and Single Car Page Templates", "cardealer"); ?></li>
<li><?php esc_html_e("Complete real time visual template design functionality.", "cardealer"); ?></li>
<li><?php esc_html_e("Unlimited Colours Setup to match your site theme", "cardealer"); ?></li>
<li><?php esc_html_e("Dedicated Premium Support", "cardealer"); ?></li>
<li><?php esc_html_e("A Lot More...", "cardealer"); ?></li>

<a href="https://siterightaway.net/car-dealer-premium-plugin/" class="button button-medium button-primary"><?php esc_attr_e('Learn More', 'cardealer'); ?></a>
<?php
echo '</ul>';
ob_start();
// Define the expiration time for transients (1 day)
$transient_expiration = DAY_IN_SECONDS;
// Try to get the data stored in transients
$cached_news_data = get_transient('news_data');
$cached_coupon_data = get_transient('coupon_data');
//DEBUG
/*
$cached_news_data = false;
$cached_coupon_data = false;
*/
// Verifique se os transientes não existem
if ($cached_news_data === false && $cached_coupon_data === false) {
    try {
        // Define the API URL
        $url = "https://billminozzi.com/API/bill-api.php";
        // Make the POST request
        $response = wp_remote_post($url, array(
            'method' => 'POST',
            'timeout' => 5,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => array(
                'version' => '2'
            ),
            'cookies' => array()
        ));
        // Check if there was an error in the request
        if (is_wp_error($response)) {
            // throw new \Exception($response->get_error_message());
        }
        // Retrieve the body of the response
        $response_body = wp_remote_retrieve_body($response);
        // Check if the response is not empty
        if (empty($response_body)) {
            // throw new \Exception('The API response is empty.');
        }
        // Decode the JSON response
        $data = json_decode($response_body, true);
        // Check if JSON decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            // throw new \Exception('JSON decoding error: ' . json_last_error_msg());
        }
        // Check if it's a coupon message
        if (isset($data['title']) && isset($data['code'])) {
            // Coupon data
            $sanitized_title = sanitize_text_field($data['title']);
            $sanitized_code = sanitize_text_field($data['code']);
            // Prepare coupon data
            $coupon_data = json_encode(array(
                'title' => $sanitized_title,
                'code' => $sanitized_code,
                'image' => isset($data['image']) ? sanitize_text_field($data['image']) : 'default.png',
            ));
            // Store the sanitized coupon data in transients
            set_transient('coupon_data', $coupon_data, $transient_expiration);
            // Store the coupon data in $cached_coupon_data
            $cached_coupon_data = $coupon_data;
        } elseif (isset($data['message'])) {
            // News data
            $message_text = stripslashes($data['message']);
            // Sanitize the message text
            $sanitized_message_text = wp_kses($message_text, array(
                'p' => array(),
                'b' => array(),
                'strong' => array(),
                'br' => array(),
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'target' => array(),
                    'rel' => array()
                ),
            ));
            // Store the sanitized news data in transients
            set_transient('news_data', $sanitized_message_text, $transient_expiration);
            // Store the news data in $cached_news_data
            $cached_news_data = $sanitized_message_text;
        } else {
            // Set $cached_news_data and $cached_coupon_data to empty strings if neither case is found
            $cached_news_data = '';
            $cached_coupon_data = '';
        }
    } catch (\Exception $e) {
        // Set $cached_news_data and $cached_coupon_data to empty strings in case of an error
        $cached_news_data = '';
        $cached_coupon_data = '';
    }
}
// Exibição dos dados com prioridade para o cupom
if ($cached_coupon_data !== '' && $cached_coupon_data !== false) {
    // Handle coupon data
    $r = json_decode($cached_coupon_data, true);
    $title = sanitize_text_field($r['title']);
    $code = sanitize_text_field($r['code']);
    $image = 'coupon.gif';
    $message_text = 'Use the code: ' . $code;
    // Clean the output buffer
    ob_end_clean();
    // Display the coupon block
    echo '<ul>';
    echo '<h2>' . esc_html($title) . '</h2>';
    echo '<img src="' . esc_url(CARDEALERIMAGES) . '/' . esc_attr($image) . '" style="width: 100%; height: auto;" />';
    echo "<br>";
    echo '<p><h2>' . wp_kses_post($message_text) . '</h2></p>';
    echo '</ul>';
} elseif ($cached_news_data !== '') {
    // Handle news data
    // Split the message into individual news items using ' | ' as a separator
    $news_items = explode(' | ', $cached_news_data);
    // Initialize variables to store the title and message
    $title = '';
    $message_text = '';
    // Randomly select a news item
    $random_key = array_rand($news_items);
    $random_news_item = $news_items[$random_key];
    // Iterate over the selected news item and separate title and body using ' || '
    $parts = explode(' || ', $random_news_item, 2);
    if (count($parts) == 2) {
        $title = sanitize_text_field(trim($parts[0]));
        $message_text = trim($parts[1]);
    }
    // Sanitize the message text
    $message_text = wp_kses($message_text, array(
        'p' => array(),
        'b' => array(),
        'strong' => array(),
        'br' => array(),
        'a' => array(
            'href' => array(),
            'title' => array(),
            'target' => array(),
            'rel' => array()
        ),
    ));
    // Store the data in transients
    set_transient('title', $title, $transient_expiration);
    set_transient('message', $message_text, $transient_expiration);
    // Clean the output buffer
    ob_end_clean();
    // Display the news block
    if ($title && $message_text) {
        echo '<ul>';
        echo '<h2>' . esc_html($title) . '</h2>';
        echo '<img src="' . esc_url(CARDEALERIMAGES) . '/news.gif" style="width: 100%; height: auto;" />';
        echo "<br>";
        echo '<p>' . wp_kses($message_text, array(
            'p' => array(),
            'b' => array(),
            'strong' => array(),
            'br' => array(),
            'a' => array(
                'href' => array(),
                'title' => array(),
                'target' => array(),
                'rel' => array()
            ),
        )) . '</p>';
        echo '</ul>';
    }
}
// Exibe vídeos e informações adicionais





// Always...
echo '<ul>';
$x = rand(1, 2);
if ($x < 2) {
    echo '<h2>' . esc_attr__("Did you like the CarDealer Plugin?", "cardealer") . '</h2>';
    echo '<img src="' . esc_url(CARDEALERIMAGES) . '/help3.jpg' . '" style="width: 100%; height: auto;" />';
    esc_html_e('Please support us by rating our plugin on WordPress.org. Help us keep this plugin live and updated.', 'cardealer');
?>
    <br /><br />
    <a href="https://wordpress.org/support/plugin/cardealer/reviews/#new-post" class="button button-medium button-primary"><?php esc_attr_e('Rate', 'cardealer'); ?></a>
<?php
} else {
    echo '<h2>' . esc_attr__("Please help us keep the plugin live & up-to-date", "cardealer") . '</h2>';
    echo '<img src="' . esc_url(CARDEALERIMAGES) . '/help1.jpg' . '" style="width: 100%; height: auto;" />';

    esc_attr_e('If you use & enjoy CarDealer Plugin, please rate it on WordPress.org. It only takes a second and helps us keep the plugin live and maintained. Thank you!', 'cardealer');
?>
    <br />
    <a href="https://wordpress.org/support/plugin/cardealer/reviews/#new-post" class="button button-medium button-primary"><?php esc_attr_e('Rate', 'cardealer'); ?></a>
<?php
}

echo '</ul>';
?>