// Bill 2023
(function($) {
    if (typeof wp === "undefined" || typeof wp.customize === "undefined") {
      return;
    }
    wp.customize.bind('ready', function() {
        wp.customize.panel('bill_designer', function(panel) {

            panel.expanded.bind(function(isExpanded) {
                if (isExpanded) {
                    var mensagem = '<div class="notice notice-info" style="color: green; font-weight: bold;"><p><span class="dashicons dashicons-info"></span>Choose your showroom page from the panel menu on the right, if it is different from the home page.</p></div>';
                    $('#customize-controls .customize-info .preview-notice').html(mensagem);
                    const urlCookie = cardealer_getCookie('cardealer_url');
                    if (urlCookie) {
                        if (cardealer_validarURL(urlCookie)) {
                            wp.customize.previewer.previewUrl(urlCookie);
                        }
                    }
                }
                else{
                    $('#customize-controls .customize-info .preview-notice').html('');

                }
            });
        });
        // Template show room...
        wp.customize.section('template', function(section) {
            var current_url = wp.customize.previewer.previewUrl();
            section.expanded.bind(function(isExpanding) {
                if (isExpanding) {
                    // Verificar se o cookie "url" existe e obter o seu conteúdo
                    const urlCookie = cardealer_getCookie('cardealer_url');
                    if (urlCookie) {
                        //console.log('O cookie "url" existe e o seu conteúdo é:', urlCookie);
                        if (cardealer_validarURL(urlCookie)) {
                            wp.customize.previewer.previewUrl(urlCookie);
                        }
                    }
                } else {
                    //console.log('nao expandiu template');
                    var previewUrl = cardealer_my_data.cardealer_previewUrl;
                    const ultimoSlashIndex = previewUrl.lastIndexOf("/");
                    previewUrl = previewUrl.slice(0, ultimoSlashIndex + 1);
                    var current_url = wp.customize.previewer.previewUrl();
                }
            });
        });
        // Template Single Car ...
        wp.customize.section('template-single', function(section) {
            section.expanded.bind(function(isExpanding) {
                if (isExpanding) {
                    var previewUrl = cardealer_my_data.cardealer_previewUrl;
                    if (previewUrl.endsWith("-1")) {
                        alert("Please, add one Car to Car's table before configurate Single Car template.");
                    } else {
                        wp.customize.previewer.previewUrl(previewUrl);
                    }
                } else {
                    // Verificar se o cookie "url" existe e obter o seu conteúdo
                    const urlCookie = cardealer_getCookie('cardealer_url');
                    if (urlCookie) {
                        if (cardealer_validarURL(urlCookie)) {
                            wp.customize.previewer.previewUrl(urlCookie);
                        }
                    } 
                }
            });
        });
        // Choose Template ...
        wp.customize.section('template name', function(section) {
            section.expanded.bind(function(isExpanding) {
                if (isExpanding) {
                    var current_url = wp.customize.previewer.previewUrl();
                    var previewUrl = cardealer_my_data.cardealer_previewUrl;
                    const ultimoSlashIndex = previewUrl.lastIndexOf("/");
                    previewUrl = previewUrl.slice(0, ultimoSlashIndex + 1);
                    previewUrl = previewUrl + '?CarDealer_search_type=page';
                    // Funciona ...
                    wp.customize.previewer.previewUrl(previewUrl);
                } else {
                    const urlCookie = cardealer_getCookie('cardealer_url');
                    if (urlCookie) {
                        if (cardealer_validarURL(urlCookie)) {
                            wp.customize.previewer.previewUrl(urlCookie);
                        }
                    }
                }
            });
        });
        // Template single car Buttons GoBack and Contact
        wp.customize.section('back-contact-us', function(section) {
            //console.log('customize controls 31');
            section.expanded.bind(function(isExpanding) {
                // Value of isExpanding will = true if you're entering the section, false if you're leaving it.
                if (isExpanding) {
                    var previewUrl = cardealer_my_data.cardealer_previewUrl;
                    // Funciona ...
                    wp.customize.previewer.previewUrl(previewUrl);
                } else {
                    const urlCookie = cardealer_getCookie('cardealer_url');
                    if (urlCookie) {
                        if (cardealer_validarURL(urlCookie)) {
                            wp.customize.previewer.previewUrl(urlCookie);
                        }
                    }
                }
            });
        });
    });
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
    function cardealer_validarURL(url) {
        var regex = /^(https?):\/\/[^\s/$.?#].[^\s]*$/i;
        return regex.test(url);
    }
 })(jQuery);