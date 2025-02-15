<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2021-03-19 10:20:31
 */
// http://codylindley.com/thickbox/
if (!defined('ABSPATH'))
  exit; // Exit if accessed directly
add_thickbox();
$is_modal = "&modal=true";
$is_modal = "&modal=false";
$is_modal = "";
if (empty($is_modal))
  $wheight = "400";
else
  $wheight = "300";

?>
<div style="display:none; max-width:400px !important;">
    <a href="#TB_inline?&width=400&height=290&inlineId=cardealer-vendor-id<?php echo esc_attr($is_modal); ?>" id="cardealer-vendor-ok"
        class="thickbox" title="Car Dealer Plugin"  style="display:none;">xx---xxx</a>
</div>
<div id="cardealer-vendor-id" style="display:none;">
            <video id="bill-banner-cd" style="margin: 0px; padding:0px;" width="400" height="240" muted>
                <source src="<?php echo esc_url(CARDEALERURL); ?>assets/videos/rallie.mp4" type="video/mp4">
            </video>

            <br> 
            <div id="cardealer-wait" style="display:none;text-align:center">
               <h3><?php esc_attr_e("Please, wait...  Dismissing...","cardealer");?></h3>
            </div>
        <div class="bill-navpanel">
                <a href="#" id="bill-vendor-button-ok-cd" style="margin-top: 0px !important; margin-right:10px;"
                    class="button button-primary bill-navitem"><?php esc_attr_e("Learn More","cardealer"); ?></a>
                <a href="#" id="bill-vendor-button-again-cd" style="margin-top: 0px !important;" class="button bill-navitem"><?php esc_attr_e("Watch Again","cardealer"); ?></a>
                <a href="#" id="bill-vendor-button-dismiss-cd" class="button bill-navitem" style="margin-left:10px !important;align:right;"><?php esc_attr_e("Dismiss","cardealer"); ?></a>
                <span class="spinner" style="display:none;"></span>
        </div>
</div>
<?php
return;