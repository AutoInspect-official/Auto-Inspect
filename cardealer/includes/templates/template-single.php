<?php
/**
 * @author Bill Minozzi
 * @copyright 2017 - 2024
 */
if (! defined('ABSPATH')) exit; // Exit if accessed directly
define('CARDEALERSINGLE_TITLE', get_the_title());
?>
<div id="container2">
    <div id="content2" role="main">
        <?php
         echo cardealer_detail($post_id);
        ?>
</div>
<?php
$registered_sidebars = wp_get_sidebars_widgets();
foreach ($registered_sidebars as $sidebar_name => $sidebar_widgets) {
    //    unregister_sidebar($sidebar_name);
}
?>