<?php
/**
 * @author Bill Minozzi
 * @copyright 2017
 */

   if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
   
    function cardealer_add_custom_js_to_header() {
      
    ?> 
    <script type="text/javascript">
    function goBack() {
      window.history.back(); 
    }
    </script>
    <style type="text/css">

    .multiDetailcontentInfo {

        margin-top: -37px;
    }

    .multi-detail-title {
      margin-top: 0px;
      padding-top: 0px;
      font-size:16px;
      padding-bottom: 5px !important;
      }

    .sidebar {
        float: left;
        margin-left: 0%;
        padding: 0;
        width: 100%;
        margin-top: -20px;
      
    }

    .multiContent {
      max-width: 75% !important;
      float: left;
      /* background-color: #ededf2; */
    }

    .multiResumo {
      width: 25%;
      float: right;
    }

    .multi-detail-title {
      font-size: 23px;
    }

    .featuredCar {
      font-family: arial;
      font-size: 17px;
      /* color: gray; */
    }
    -->
    </style>

<?php

}
add_action('wp_head', 'cardealer_add_custom_js_to_header');





define('SINGLE_TITLE', get_the_title() );
 get_header();
  ?>
	    <div id="container2"> 
        <?php 
        if(isset($_SERVER['HTTP_REFERER']))
         {?>
          <center>
          <button id="cardealer_goback" onclick="goBack()">
          <?php 
          echo __('Back', 'cardealer');?> 
          </button>
          <br /><br />
          </center>
        <?php } ?>
            <div id="content2" role="main">
				<?php cardealer_detail();
               $CarDealer_enable_contact_form = trim(get_option('CarDealer_enable_contact_form', 'yes'));
               if ($CarDealer_enable_contact_form == 'yes')
               {               
                ?>
                 <br />
                 <center>
                 <button id="CarDealer_cform">
                 <?php echo __('Contact Us', 'cardealer'); ?>
                 </button>
                 </center>
                 <br />
			</div> 
            <?php 
            } 
            //
            //   $cardealer_the_title = get_the_title();
               if ($CarDealer_enable_contact_form == 'yes') 
               {
                   include_once (CARDEALERPATH . 'includes/contact-form/multi-contact-show-form.php');  
               }
         ?>  
		</div>
<?php 
        $registered_sidebars = wp_get_sidebars_widgets();
        foreach( $registered_sidebars as $sidebar_name => $sidebar_widgets ) {
        	unregister_sidebar( $sidebar_name );
        }
get_footer(); 
?>