(function($) {

    // console.log('9000');
    $(document).ready(function() {






        $(document).click(function(event) {

            // console.log('Elemento clicado:'+ event.target);
            // const url =  event.target;
            const target = event.target;

            if (target.tagName === 'A') {

                const url = event.target.href;

                // console.log(typeof url);
                // console.log('string:'+ url);
                

                // Check if the value is a valid URL
                if (typeof url === 'string' && url.startsWith('http')) {
                    // Create a new URL object
                    const parsedUrl = new URL(url);

                    // console.log('Passou:');
                    
                    var urlProper = parsedUrl.origin + parsedUrl.pathname;
                    const hasCustomizeChangeset = parsedUrl.searchParams.has('customize_changeset_uuid');
                    const hasCustomizeMessengerChannel = parsedUrl.searchParams.has('customize_messenger_channel');
                    if (hasCustomizeChangeset && hasCustomizeMessengerChannel) {
                        // console.log('A URL contém os parâmetros customize_changeset e customize_messenger_channel!!!.');
                        const urlCookie = cardealer_getCookie('cardealer_url');
                        if (urlCookie !== null) {
                            // console.log('Tem cookie 1 '+urlCookie);
                            document.cookie = 'cardealer_url' + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        }
                        cardealer_setUrlCookie(urlProper);
                        // console.log('Tem cookie 2 '+urlCookie);
                    } 
                }
            }

        });

        /*    Search Box   */
        // Search BKG color
        wp.customize('cardealer-search-box-bk-color', function(value) {
            value.bind(function(new_value) {
                //console.log('bkg: ' + new_value);
                // Update preview
                $('.cardealer-search-box').css("background-color", new_value);
            });
        });
        wp.customize('cardealer-search-box-border-color', function(value) {
            value.bind(function(new_value) {
                // Update preview
                $('.cardealer-search-box').css("border-color", new_value);
            });
        });
        // Search Border Size
        wp.customize('cardealer-search-box-border-size', function(value) {
            value.bind(function(new_value) {
                // Update preview
                var $set_border = new_value + "px";
                $('.cardealer-search-box').css("border-width", $set_border);
            });
        });
        // Search Border Radius
        wp.customize('cardealer-search-box-border-radius', function(value) {
            value.bind(function(new_value) {
                // Update preview
                var $set_border = new_value + "px";
                $('.cardealer-search-box').css("border-radius", $set_border);
            });
        });
        // Margin Bottom
        wp.customize('cardealer-search-box-margin-bottom', function(value) {
            value.bind(function(new_value) {
                // Update preview
                var $set_margin = new_value + "px";
                $('.cardealer-search-box').css("margin-bottom", $set_margin);
            });
        });
        /*    End Search Box   */
        /*    Search Fields   */
        wp.customize('cardealer-search-fields-label-color', function(value) {
            value.bind(function(new_value) {
                $('.cardealer-search-label').css("color", new_value);
                $('.search-label-widget').css("color", new_value);
            });
        });
        // .cardealer-select-box-meta
        wp.customize('cardealer-search-fields-control-color', function(value) {
            value.bind(function(new_value) {
                $('.cardealer-select-box-meta').css("color", new_value);
                $('.cardealer-select-box-meta-widget').css("color", new_value);
            });
        });
        wp.customize('cardealer-search-fields-control-bkg-color', function(value) {
            value.bind(function(new_value) {
                $('.cardealer-select-box-meta').css("background", new_value);
                $('.cardealer-select-box-meta-widget').css("background", new_value);
            });
        });
        //cardealer-search-fields-radius
        wp.customize('cardealer-search-fields-radius', function(value) {
            value.bind(function(new_value) {
                var $set_border = new_value + "px";
                $('.cardealer-select-box-meta').css("border-radius", $set_border);
                $('.cardealer-select-box-meta-widget').css("border-radius", $set_border);
            });
        });
        /*    End Search Fields   */
        // submitBtn
        wp.customize('cardealer-search-button-color', function(value) {
            value.bind(function(new_value) {
                $('#cardealer-submitBtn').css("color", new_value);
                $('#cardealer-submitBtn-widget').css("color", new_value);
            });
        });
        wp.customize('cardealer-search-button-bkg-color', function(value) {
            value.bind(function(new_value) {
                $('#cardealer-submitBtn').css("background", new_value);
                $('#cardealer-submitBtn-widget').css("background", new_value);
            });
        });
        //cardealer-search-button-radius
        wp.customize('cardealer-search-button-radius', function(value) {
            value.bind(function(new_value) {
                var $set_border = new_value + "px";
                $('#cardealer-submitBtn').css("border-radius", $set_border);
                $('#cardealer-submitBtn-widget').css("border-radius", $set_border);
            });
        });
                // cardealer-search-button-width
                wp.customize('cardealer-search-button-width', function(value) {
                    value.bind(function(new_value) {
                        var $set_width = new_value + "px";
                        $('#cardealer-submitBtn').css("width", $set_width);
                    });
                });  
        // Slider
        // .cardealer-select-box-meta
        wp.customize('cardealer-search-slider-label-color', function(value) {
            value.bind(function(new_value) {
                // console.log(new_value);
                $('.cardealerlabelprice').css("color", new_value);
                $('#meta_price').css("color", new_value);
                $('.cardealerlabelprice2').css("color", new_value);
                $('#meta_price2').css("color", new_value);
                /* >>>>>>>>>>>>>>>>>>>>  */
            });
        });
        wp.customize('cardealer-search-slider-control-bkg-color', function(value) {
            value.bind(function(new_value) {
                $('.cardealer-price-slider').css("background", new_value);
                $('.cardealer-price-slider2').css("background", new_value);
                $('#meta_price').css("color", new_value);
                $('#meta_price2').css("color", new_value);
            });
        });
        wp.customize('cardealer-search-slider-control-color', function(value) {
            value.bind(function(new_value) {
                // console.log(new_value);
                $('.ui-slider .ui-slider-range').hide(); 
                $('.ui-widget.ui-widget-content').css("background-color", new_value);
              $('.ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active').css("background-color", new_value+' !important');
              $('.ui-state-default, .ui-widget-content .ui-state-default').css("background-color", new_value+' !important');
              $('.ui-slider .ui-slider-handle').css("background-color", new_value+' !important');
            });
        });
        wp.customize('cardealer-search-slider-handle-color', function(value) {
            value.bind(function(new_value) {
                $('#slider-button-0').css("background-color", new_value); 
                $('#slider-button-1').css("background-color", new_value); 
                $('#slider-button-2').css("background-color", new_value); 
                $('#slider-button-3').css("background-color", new_value); 
            });
        });
        wp.customize('cardealer-search-slider-border-color', function(value) {
            value.bind(function(new_value) {
                $('.cardealer-price-slider').css("border-color", new_value);
                $('.cardealer-price-slider2').css("border-color", new_value);
            });
        });
        wp.customize('cardealer-search-slider-radius', function(value) {
            value.bind(function(new_value) {
                var $set_border = new_value + "px";
                $('.cardealer-price-slider').css("border-radius", $set_border);
                $('.cardealer-price-slider2').css("border-radius", $set_border);
            });
        });
        // Template Single Car
        //cardealer-template-single-bk-color
        wp.customize('cardealer-template-single-bk-color', function(value) {
            value.bind(function(new_value) {
                $('#content2').css("background", new_value);
            });
        });
        wp.customize('cardealer-template-single-color', function(value) {
            value.bind(function(new_value) {
                $('.multiContent').css("color", new_value);
                $('#content2').css("color", new_value);
                $('.featuredList').css("color", new_value);
            });
        });
        wp.customize('cardealer-template-single-features-bkg', function(value) {
            value.bind(function(new_value) {
                $('.featuredTitle').css("background", new_value);
            });
        });
        wp.customize('cardealer-template-single-features-color', function(value) {
            value.bind(function(new_value) {
                $('.featuredTitle').css("color", new_value);
            });
        });
        wp.customize('cardealer-template-single-features-border-color', function(value) {
            value.bind(function(new_value) {
                $('.featuredCar').css("border-color", new_value);
            });
        });
        wp.customize('cardealer-template-single-features-border-radius', function(value) {
            value.bind(function(new_value, event) {
                var $set_border = "0px 0px "+new_value + "px "  + new_value + "px" ;
                var $set_border2 = new_value + "px "  + new_value + "px 0px 0px" ;
                $('.featuredCar').css("border-radius", $set_border);
                $('.featuredTitle').css("border-radius", $set_border2);
            });
        });
        // .cardealer-back and contact
        wp.customize('cardealer-back-contact-buttons-color', function(value) {
            value.bind(function(new_value) {
                $('#cardealer_goback').css("color", new_value);
            });
        });
        wp.customize('cardealer-back-contact-buttons-bk-color', function(value) {
            value.bind(function(new_value) {
                $('#cardealer_goback').css("background", new_value);
            });
        });
        wp.customize('cardealer-back-contact-buttons-radius', function(value) {
            value.bind(function(new_value, event) {
                var $set_border = new_value + "px";
                $('#cardealer_goback').css("border-radius", $set_border);
            });
        });
		wp.customize('cardealer-back-contact-buttons-width', function(value) {
            value.bind(function(new_value, event) {
                var $set_border = new_value + "px";
                $('#cardealer_goback').css("width", $set_border);
            });
        });

        
        // Change Template
        wp.customize('CarDealer_template_gallery', function(value) {
            value.bind(function(new_value) {

                var previewUrl = cardealer_my_data.cardealer_previewUrl;
                const ultimoSlashIndex = previewUrl.lastIndexOf("/");
                siteUrl = previewUrl.slice(0, ultimoSlashIndex + 1);
                
                 if (new_value == 'list') {
                    $('#cardealer_content').html('<img src="'+siteUrl+'wp-content/plugins/cardealer/assets/images/lview.jpg">');
                 }
                 else if (new_value == 'grid') {
                    $('#cardealer_content').html('<img src="'+siteUrl+'wp-content/plugins/cardealer/assets/images/grid.jpg">');
                }
                else {
                    $('#cardealer_content').html('<img src="'+siteUrl+'wp-content/plugins/cardealer/assets/images/gallery.jpg">');
                }
                $('#cardealer_content').css("margin-bottom", "50px");
            });
        });

        // Change Single Car Template
        wp.customize('CarDealer_template_single', function(value) {
            value.bind(function(new_value) {

                var previewUrl = cardealer_my_data.cardealer_previewUrl;
                const ultimoSlashIndex = previewUrl.lastIndexOf("/");
                siteUrl = previewUrl.slice(0, ultimoSlashIndex + 1);

                // console.log(siteUrl);
                //console.log(new_value);

                 if (new_value == '1') {
                    $('#cardealer_content').html('<img src="'+siteUrl+'wp-content/plugins/cardealer/assets/images/screenshot_modelo1.jpg">');
                 }
                 else if (new_value == '2') {
                    $('#cardealer_content').html('<img src="'+siteUrl+'wp-content/plugins/cardealer/assets/images/screenshot_side.jpg">');
                 }
                 else if (new_value == '3') {
                    $('#cardealer_content').html('<img src="'+siteUrl+'wp-content/plugins/cardealer/assets/images/screenshot_outro.jpg">');
                 }
                 else {
                    $('#cardealer_content').html('<img src="'+siteUrl+'wp-content/plugins/cardealer/assets/images/screenshot_modal.jpg">');
                 }
                $('#cardealer_content').css("margin-bottom", "50px");
            });
        });




        // Template
        wp.customize('cardealer-template-bk-color', function(value) {
            value.bind(function(new_value) {
                $('#cardealer_content').css("background", new_value);
            });
        });
        wp.customize('cardealer-template-title-color', function(value) {
            value.bind(function(new_value) {
                $('.multiTitle17').css("color", new_value);
                $('.multiInforightText17').css("color", new_value);
            });
        });
        wp.customize('cardealer-template-fg-color', function(value) {
            value.bind(function(new_value) {
                $('.cardealer_description').css("color", new_value);
                $('#cardealer_content').css("color", new_value);
            });
        });
            // .cardealer-Button View
            wp.customize('cardealer-template-button-color', function(value) {
                value.bind(function(new_value) {
                    $('.cardealer_btn_view').css("color", new_value);
                });
            });
            wp.customize('cardealer-template-button-bkg-color', function(value) {
                value.bind(function(new_value) {
                    var new_value99 = new_value + ' !important';
                    var count = $('[id^="cardealer_btn_view-"]').length;
                    for (let i = 1; i <= count; i++) {
                        let elementId = "#cardealer_btn_view-" + i;
                        $(elementId).css("background", new_value);
                    }
                });
            });
            wp.customize('cardealer-template-button-radius', function(value) {
                value.bind(function(new_value, event) {
                    var $set_border = new_value + "px";
                    var count = $('[id^="cardealer_btn_view-"]').length;
                    for (let i = 1; i <= count; i++) {
                        let elementId = "#cardealer_btn_view-" + i;
                        let elementId2 = ".cardealer_btn_view-" + i;
                        $(elementId).css("border-radius", $set_border);
                        $(elementId2).css("border-radius", $set_border);
                    }
                });
            });
            wp.customize('cardealer-template-button-width', function(value) {
                value.bind(function(new_value, event) {
                    var $set_width = new_value + "px";
                    $('.cardealer_btn_view').css("width", $set_width);
                });
            });
   // .CarDealer_container17
   wp.customize('cardealer-template-list-separator', function(value) {
        value.bind(function(new_value, event) {
            var $set_border = "1px solid "+new_value;
            $('.CarDealer_container17').css("border-bottom", $set_border);
        });
    });
    // Gallery Title
    wp.customize('cardealer-template-gallery-title', function(value) {
        value.bind(function(new_value, event) {
            $('.carTitle').css("color", new_value);
            $('.sideTitle').css("color", new_value);
        });
    });
    wp.customize('cardealer-template-gallery-title-bkg', function(value) {
        value.bind(function(new_value, event) {
            $('.carTitle').css("background", new_value);
            $('.sideTitle').css("background", new_value);
            $('.multiTitle-widget').css("background", new_value);
        });
    });


    // Gallery Border  Radius
        wp.customize('cardealer-template-gallery-border-radius', function(value) {
            value.bind(function(new_value) {
                // Update preview
                var $set_border = new_value + "px " +  new_value + "px " + "0px 0px" ;
                $('.CarDealer_gallery_2016').css("border-radius", $set_border);
                $('.sideTitle').css("border-radius", $set_border);
                $('.CarDealer_caption_img').css("border-radius", $set_border);
                $('.CarDealer_caption_text').css("border-radius", $set_border);
                // $("p#44.test").css("background-color","red");
            });
        });
        wp.customize('cardealer-template-gallery-border', function(value) {
            value.bind(function(new_value, event) {
                var $set_border = "1px solid " +  new_value;
                $('.CarDealer_gallery_2016').css("border", $set_border);
            });
        });
        wp.customize('cardealer-template-grid-border', function(value) {
            value.bind(function(new_value, event) {
                var $set_border = "1px solid " +  new_value;
                $('.cardealer-item-grid').css("border", $set_border);
            });
        });
        // Test Site Title...
        wp.customize('myplugin_setting', function(value) {
            value.bind(function(new_value) {
                if (new_value == '1') {
                    $('.site-title-text').hide();
                } else {
                    $('.site-title-text').show();
                }
            });
        });
        wp.customize('cardealer-widget-bkg', function(value) {
            value.bind(function(new_value, event) {
                $('#cardealer-search-box-widget').css("background", new_value);
            });
        });
});  // end doc ready...

    function cardealer_setUrlCookie(url) {
        document.cookie = `cardealer_url=${encodeURIComponent(url)+ "; path=/"}`;
      }
      if (typeof cardealer_getCookie !== 'function') {
        function cardealer_getCookie(name) {
            const cookieString = document.cookie;
            const cookies = cookieString.split(';');
            for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].trim();
            if (cookie.startsWith(name + '=')) {
                return decodeURIComponent(cookie.substring(name.length + 1));
            }
            }
            return null;
        }
    }
})(jQuery);