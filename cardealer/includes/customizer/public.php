<?php

/**
 * Front-facing functionality.
 * 2023-05-31
 */
if (! defined('ABSPATH')) {
	die();
}

/**
 * Print inline style element.
 *
 */
function cardealer_enqueue_dynamic_styles()
{
	// Generate the dynamic CSS code

	$dynamic_styles = cardealer_the_css();
	wp_register_style('cardealer-dynamic-styles', false);
	wp_enqueue_style('cardealer-dynamic-styles');
	$r = wp_add_inline_style('cardealer-dynamic-styles', $dynamic_styles);
}
add_action('wp_enqueue_scripts', 'cardealer_enqueue_dynamic_styles', 99999);
function cardealer_enqueue_dynamic_script2()
{
	$cardealer_template_button_color =	get_option('cardealer-template-button-color', 'wwhite');
	$cardealer_template_button_bkg_color =	get_option('cardealer-template-button-bkg-color', 'gray');
	$cardealer_template_button_radius =	get_option('cardealer-template-button-radius', '0 px');
	$set_border =  $cardealer_template_button_radius . 'px';
	$set_bkg_color = $cardealer_template_button_bkg_color;
	$set_color = $cardealer_template_button_color;
	$cardealer_slider_color =	get_option('cardealer-search-slider-control-bkg-color', '0 px');
	$cardealer_template_single_features_border_color = get_option('cardealer-template-single-features-border-color', 'gray');
	$dynamic_script = "
        jQuery(document).ready(function($) {
			var count = $('[id^=\"cardealer_btn_view-\"]').length;
			for (let i = 1; i <= count; i++) {
				let elementId = '#cardealer_btn_view-' + i;
				//console.log(elementId);
				$(elementId).css('background', '$set_bkg_color');
				$(elementId).css('color', '$set_color');
				$(elementId).css('border-radius', '$set_border');
			}
			var setcolor = '1px solid $cardealer_template_single_features_border_color';
			$('.featuredCar').css('border', 'setcolor');
		});
    ";
	$handle = 'dynamic-script';
	wp_register_script('cardealer-dynamic-script', false);
	wp_enqueue_script('cardealer-dynamic-script');
	wp_add_inline_script('cardealer-dynamic-script', $dynamic_script);
}
add_action('wp_enqueue_scripts', 'cardealer_enqueue_dynamic_script2', '99999');
/**
 * Echo the CSS.
 *
 */
function cardealer_the_css()
{ ?>
	<style type='text/css'>
		/* Car Template */
		.cardealer-item {
			border: 1px solid #707070;
		}

		.CarDealer_gallery_2016 {
			border: 1px solid #606060;
		}

		.sideTitle,
		.CarDealer_caption_img,
		.CarDealer_caption_text,
		.CarDealer_gallery_2016 {
			border-radius: 6px 6px 0px 0px;
		}

		.carTitle,
		.sideTitle,
		.multiTitle-widget {
			background: #5e5e5e;
			color: #ffffff;
		}

		#cardealer_content {
			/* background : #ffffff; */
		}

		.multiTitle17,
		.multiInforightText17 {
			color: #12465c;
		}

		.cardealer_description,
		#cardealer_content {
			color: #3a3a3a;
		}

		[id^="cardealer_btn_view-"] {
			width: 190px;
			;
		}

		.CarDealer_container17 {
			border-bottom: 1px solid #bfbfbf;
		}

		/* Single Car Template */
		#content2 {
			background: #f2f2f2;
		}

		.multiContent,
		#content2,
		.featuredList {
			color: #333333;
		}

		.featuredTitle {
			color: #ffffff;
			background: #919191;
			border-radius: 5px 5px 0px 0px;
		}

		.featuredCar {
			/* color : #333333; */
			border: 1px solid #a0a0a0;
			border-radius: 0px 0px 5px 5px;
		}

		.featuredList {
			color: #333333;
		}

		#cardealer_goback,
		#CarDealer_cform {
			color: #ffffff;
			background: #686868;
			border-radius: 5px;
			;
			width: 200px;
			;
		}

		#cardealer-submitBtn,
		#cardealer-submitBtn-widget {
			color: #ffffff;
			background: #727272;
			border-radius: 5px;
			;
			width: 170px;
			;
		}

		.cardealer-search-box {
			/* background-color: #ffffff; */
			border: 1px solid gray;
			border-radius: 4px;
			/* border-color: #c9c9c9; */
			border-color: gray;
		}

		#cardealer-search-box {
			margin-bottom: 22px;
			opacity: .9;
		}

		.cardealer-search-label,
		.search-label-widget {
			color: #606060;
		}

		.cardealer-select-box-meta,
		.cardealer-select-box-meta-widget {
			color: #12465c;
			background: #ededed;
			border-radius: 3px;
			;
		}

		.cardealerlabelprice,
		#meta_price,
		.cardealerlabelprice2,
		#meta_price2 {
			color: #757575;
		}

		/* slider */
		.ui-slider .ui-slider-range {
			/* margin-top: 20px; */
			background: #898989;
		}

		.ui-state-default,
		.ui-widget-content .ui-state-default {
			/* margin-top: 20px; */
			background: #898989;
			/*!important; */
		}

		#slider-button-0,
		#slider-button-1,
		#slider-button-2,
		#slider-button-3 {
			background: #8c8c8c;
			width: 1.0em;
			height: 1.0em;
			border-radius: 50%
		}

		.cardealer-price-slider,
		.cardealer-price-slider2 {
			background: #ffffff;
			border-radius: 7px;
			;
			border: 1px solid #c9c9c9;
		}

		#cardealer-search-box-widget {
			background: #dddddd;
		}
	</style>
<?php
}
