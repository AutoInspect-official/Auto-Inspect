<?php

/**
 * @author William Sergio Minozzi
 * @copyright 2017
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
// var_dump(__LINE__);
?>
<div id="cardealer-dashboard-wrap">
    <div id="cardealer-dashboard-left">
        <div id="cardealer-services3">
            <div class="cardealer-block-title">
                <?php echo esc_attr__('Server Check', 'cardealer'); ?>
            </div>
            <div class="cardealer-help-container1">
                <div class="cardealer-help-column cardealer-help-column-1">
                    <h3><?php echo esc_attr__('Memory Status', 'cardealer'); ?></h3>
                    <?php
                    $ds = 256;
                    $du = 60;
                    $cardealer_memory = cardealer_check_memory();
                    if ($cardealer_memory['msg_type'] == 'notok') {
                        echo esc_attr__('Unable to get your Memory Info', 'cardealer');
                    } else {
                        $ds = $cardealer_memory['wp_limit'];
                        $du = $cardealer_memory['usage'];
                        if ($ds > 0)
                            $perc = number_format(100 * $du / $ds, 2);
                        else
                            $perc = 0;
                        if ($perc > 100)
                            $perc = 100;
                        $color = '#e87d7d';
                        $color = '#029E26';
                        if ($perc > 50)
                            $color = '#e8cf7d';
                        if ($perc > 70)
                            $color = '#ace97c';
                        if ($perc > 50)
                            $color = '#F7D301';
                        if ($perc > 70)
                            $color = '#ff0000';;
                        echo '<p><li style="max-width:50%;font-weight:bold;padding:5px 15px;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;background-color:#0073aa;margin-left:13px;color:white;">' .
                            esc_attr__('Memory Usage', 'cardealer') . '<div style="border:1px solid #ccc;background:white;width:100%;margin:2px 5px 2px 0;padding:1px">' .
                            '<div style="width: ' . esc_html($perc) . '%;background-color:' . esc_html($color) .
                            ';height:6px"></div></div>' . esc_attr($du) . ' ' . esc_attr__('of', 'cardealer') . ' ' . esc_attr($ds) . ' MB ' . esc_attr__('Usage', 'cardealer') . '</li>'; ?>
                        <br /> <br />
                        <?php echo esc_attr__('For details, click the Memory Checkup Tab above.', 'cardealer'); ?>
                        <br /> <br />
                    <?php } ?>
                </div>
                <!-- "Column1">  -->
                <div class="cardealer-help-column cardealer-help-column-2">
                    <h3><?php echo esc_attr__('Permalink Settings', 'cardealer'); ?></h3>
                    <?php
                    $permalinkopt = get_option('permalink_structure');
                    if ($permalinkopt != '/%postname%/') { ?>
                        <img alt="aux" width="40px" src="<?php echo esc_url(CARDEALERURL) ?>assets/images/noktick.png" />
                        <br />
                        <br />
                        <?php echo esc_attr__('Wrong Permalink settings !', 'cardealer'); ?>
                        <br />
                        <?php echo esc_attr__('Please, fix it to avoid 404 error page.', 'cardealer'); ?>
                        <br />
                        <?php echo esc_attr__('To correct, just follow this steps:', 'cardealer'); ?>
                        <br />
                        <?php echo esc_attr__('Dashboard => Settings => Permalinks => Post Name (check)', 'cardealer'); ?>
                        <br />
                        <?php echo esc_attr__('Click Save Changes', 'cardealer'); ?>
                    <?php
                    } else
                        echo '<img alt="aux" width="40px" src="' . esc_url(CARDEALERURL) . 'assets/images/oktick.png" />';
                    ?>
                    <br /> <br />
                </div> <!-- "columns 2">  -->
                <div class="cardealer-help-column cardealer-help-column-3">
                    <h3 style="color:red;"><?php echo esc_attr__('Premium Version Disabled.', 'cardealer'); ?></h3>
                    <?php echo esc_attr__('Get more Grid template', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('Get more 3 single page templates', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('Template Visual Customizer (also colors)', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('Get more shortcodes:', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Filter Cars for Type (Van, Sedan, and so on)', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Last Cars', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Featured Cars', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Order by Price/Year Ascending/Descending', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Create Blocks type Gallery or Page List', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Combine Shortcodes', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Number of Cars to show', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Show or Hide Pagination', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Show or Hide Search Box', 'cardealer'); ?>
                    <br />
                    <?php $site = 'http://cardealerplugin.com/premium/'; ?>
                    <a href="<?php echo esc_url($site); ?>" class="button button-primary"><?php echo esc_attr__('Learn More', 'cardealer'); ?></a>
                </div>
                <!-- "Column 3">  -->
            </div> <!-- "Container 1 " -->
        </div>
        <div id="cardealer-steps3">
            <div class="cardealer-block-title">
                <img alt="aux" src="<?php echo esc_url(CARDEALERURL) ?>assets/images/3steps.png" />
                <br /> <br />
                <?php echo esc_attr__('Follow this 3 steps after install the plugin:', 'cardealer'); ?>
            </div>
            <div class="cardealer-help-container1">
                <div class="cardealer-help-column cardealer-help-column-1">
                    <img alt="aux" src="<?php echo esc_url(CARDEALERURL) ?>assets/images/step1.png" />
                    <h3><?php echo esc_attr__('Configurate Settings', 'cardealer'); ?></h3>
                    <?php echo esc_attr__('Go to', 'cardealer'); ?> <br />
                    <?php echo esc_attr__('Dashboard=>Car Dealer=>Settings', 'cardealer'); ?>
                    <br />
                    <em><?php echo esc_attr__('Fill out the information', 'cardealer'); ?></em>:
                    <br />
                    <?php echo esc_attr__('- Your Currency', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Miles - Km', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Your Contact eMail', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- And So On ...', 'cardealer'); ?>
                    <br /> <br />
                    <strong><?php echo esc_attr__('Import Demo Data:', 'cardealer'); ?></strong>
                    <br />
                    <?php echo esc_attr__('If you want import demo data, click the Help Button at top right corner and take a look Import Demo Data or, if you are using our theme, you can import together with theme demo import.', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('If you import demo data, you can skip step 2.', 'cardealer'); ?>
                </div> <!-- "Column1">  -->
                <div class="cardealer-help-column cardealer-help-column-2">
                    <img alt="aux" src="<?php echo esc_url(CARDEALERURL) ?>assets/images/step2.png" />
                    <h3><?php echo esc_attr__('Fill Out the Fields and Car Tables', 'cardealer'); ?></h3>
                    <b><?php echo esc_attr__('Go to Fields Table:', 'cardealer'); ?></b><br />
                    <?php echo esc_attr__('Dashboard=>Car Dealer=>Fields Table', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('They are the fields to show up at your cars form.', 'cardealer'); ?>
                    <?php echo esc_attr__('For example:', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Number of Doors', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Passenger Capacity', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Body Color', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- And So On.', 'cardealer'); ?>
                    <br /><br />
                    <?php echo esc_attr__('You don\'t need include this fields: Price, Year, Miles, HP, Transmission Type, Fuel Type, Condition and Featured.', 'cardealer'); ?>
                    <br /><br />
                    <b><?php echo esc_attr__('Go to Cars Table:', 'cardealer'); ?></b><br />
                    <?php echo esc_attr__('Dashboard=>Car Dealer=>Cars table', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('And fill out this table with yours products.', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('For example:', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Cars', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- Vans', 'cardealer'); ?>
                    <br />
                    <?php echo esc_attr__('- And So On.', 'cardealer'); ?>
                </div> <!-- "columns 2">  -->
                <div class="cardealer-help-column cardealer-help-column-3">
                    <img alt="aux" src="<?php echo esc_url(CARDEALERURL) ?>assets/images/step3.png" />
                    <h3><?php echo esc_attr__('Paste the code in your page:', 'cardealer'); ?></h3>
                    <?php echo esc_attr__('Go to your page and copy and paste this code:', 'cardealer'); ?>
                    <br />
                    [car_dealer]
                    <br /><br />
                    <?php echo esc_attr__('To create one Team page, just past this shortcode in your page:', 'cardealer'); ?>
                    <br />
                    [cardealer_team]
                    <br /><br />
                    <?php echo esc_attr__('To show only the Search Bar, just past this shortcode in your page:', 'cardealer'); ?>
                    <br />
                    [car_dealer onlybar="yes"]
                    <br /><br />
                    <strong><?php echo esc_attr__('The Premium Version have dozens of extra codes and visual template editor, also colors control.', 'cardealer'); ?></strong>
                    <br /><br />
                </div>
                <!-- "Column 3">  -->
            </div> <!-- "Container 1 " -->
        </div> <!-- "cardealer-steps3"> -->
        <div id="cardealer-services3">
            <div class="cardealer-block-title">
                <?php echo esc_attr__('Help, Demo, Support, Troubleshooting:', 'cardealer'); ?>
            </div>
            <div class="cardealer-help-container1">
                <div class="cardealer-help-column cardealer-help-column-1">
                    <img alt="aux" src="<?php echo esc_url(CARDEALERURL) ?>assets/images/support.png" />
                    <h3><?php echo esc_attr__('Help and more tips', 'cardealer'); ?></h3>
                    <?php echo esc_attr__('Just click the HELP button at top right corner this page for context help. Also <em>Tooltip</em> available in Fields form.', 'cardealer'); ?>
                    <br /><br />
                </div> <!-- "Column1">  -->
                <div class="cardealer-help-column cardealer-help-column-2">
                    <img alt="aux" src="<?php echo esc_url(CARDEALERURL) ?>assets/images/service_configuration.png" />
                    <h3><?php echo esc_attr__('OnLine Guide, Support, Demo, Demo Video, Faq...', 'cardealer'); ?></h3>
                    <?php echo esc_attr__('You will find our complete and updated OnLine guide, demo, demo video, faqs page, link to support page and more usefull stuff in our site.', 'cardealer'); ?>
                    <br /><br />
                    <?php $site = 'http://cardealerplugin.com'; ?>
                    <a href="<?php echo esc_url($site); ?>" class="button button-primary"><?php echo esc_attr__('Go', 'cardealer'); ?></a>
                </div> <!-- "columns 2">  -->
                <div class="cardealer-help-column cardealer-help-column-3">
                    <img alt="aux" src="<?php echo esc_url(CARDEALERURL) ?>assets/images/system_health.png" />
                    <h3><?php echo esc_attr__('Troubleshooting Guide', 'cardealer'); ?></h3>
                    <?php echo esc_attr__('Use old WordPress version, Low memory, some plugin with Javascript error, wrong permalink settings are some possible problems. Read this and fix it quickly!', 'cardealer'); ?>
                    <br /><br />
                    <a href="http://siterightaway.net/troubleshooting/" class="button button-primary"><?php echo esc_attr__('Troubleshooting Page', 'cardealer'); ?></a>
                </div> <!-- "Column 3">  -->
            </div> <!-- "Container1 ">  -->
        </div> <!-- "services"> -->
    </div> <!-- "cardealer-dashboard-left"> -->
    <div id="cardealer-dashboard-right">
        <div id="containerright-dashboard">
            <?php
            require_once(CARDEALERPATH . "dashboard/mybanners.php");
            ?>
        </div>
    </div> <!-- "cardealer-dashboard-right"> -->
</div> <!-- "car-dealer-dashboard-wrap"> -->
