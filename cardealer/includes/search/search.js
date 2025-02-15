jQuery(document).ready(function ($) {
    // console.error("Search Loaded!");


    /*
        $('.close-modal').on('click', function () {
            //alert('2');
            // Hide the modal and overlay
            $('.modal-container').css('display', 'none');
            $('.modal-overlay').css('display', 'none');
        });
        $(document).on('click', '.close-modal', function (event) {
            $('.modal-overlay').toggle();
            $('.modal-container').toggle();
        });
        */

    // Fecha o modal ao clicar no botão de fechar
    $(document).on('click', '.close-modal22', function (event) {
        console.log('Clicou Close Modal');
        closeModal();
    });

    $(document).on('click', 'body', function (event) {
        const clickedInsideModal = $(event.target).closest('.modal-container22').length > 0;
        const isCloseButton = $(event.target).hasClass('close-modal22');

        //console.log('Clicou no body');
        //console.log('Está dentro do modal:', clickedInsideModal);
        //console.log('O alvo é o botão de fechar:', isCloseButton);

        // Fecha o modal somente se o clique for fora do modal e não no botão de fechar
        if (!clickedInsideModal && !isCloseButton) {
            // console.log('Clicou fora do modal, fechando...');
            closeModal();
        }
    });

    // Função para fechar o modal
    function closeModal() {
        console.log('Fechando modal...');
        $('.modal-overlay22').hide();
        $('.modal-container22').hide();
        $('body').removeClass('modal-open22');
    }


    // single car
    $(document).on('click', '.open-modal', function (e) {
        // console.log("clicou... open-modal");
        $(document).on('ajaxStart', function () {
            // $('.multiGallery').css('filter', 'brightness(0.7) opacity(0.7)');
            $('body').css('filter', 'brightness(0.9) opacity(0.7)');
        });
        e.preventDefault();
        if ($(this).is('a')) {
            modalId = $(this).attr('href'); // Se for link, pega o href
        } else if ($(this).is('input')) {
            modalId = '#myModal-' + $(this).attr('id').replace('modal-submit-', ''); // Se for botão, cria o ID do modal
        }
        var match = modalId.match(/myModal-(\d+)/);
        if (match) {
            var postId = match[1]; // Extracted post number
            // console.log(postId); // Output: 162
        }
        $('body').addClass('modal-open22');
        $('.modal-overlay22').toggle(); // Mostra o overlay
        $('.modal-container22').toggle(); // Mostra o modal

        $('body').css('filter', 'brightness(0.9) opacity(0.7)');
        $(document).on('ajaxStop', function () {
            $('body').css('filter', 'none');
        });


        $(document).on('click', '.close-modal22', function (event) {
            //alert('f');
            $('body').removeClass('modal-open22');
            $('.modal-overlay22').hide(); // Esconde o overlay
            $('.modal-container22').toggle(); // Esconde o modal
            $('.modal-container22').hide(); // Esconde o modal
            // console.log('Fechar');
        });
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'cardealer_single_car_ajax', // Nome da ação definida no PHP
                post_id: postId // Envia os dados do formulário serializados
            },
            success: function (response) {
                if ($(".modal-content").html() !== response) {
                    $(".modal-content").html(response);  // Só atualiza se o conteúdo for diferente
                }
                function initFlexSlider() {
                    if (typeof jQuery().flexslider === 'function') {
                        jQuery('.flexslider').flexslider();
                        // Previne o comportamento do link na imagem
                        jQuery('.flexslider .slides a').on('click', function (event) {
                            event.preventDefault();  // Impede que o link abra a imagem em uma nova página
                        });
                    } else {
                        // console.log('FlexSlider não está carregado.');
                    }
                }
                setTimeout(function () {
                    initFlexSlider(); // Chama a função após 5 segundos
                }, 100);
                if ($(".carGallery").html() !== response) {
                    //   $(".carGallery").html(response);  // Só atualiza se o conteúdo for diferente
                }
            },
            error: function () {
                // console.error('Erro na consulta 22');
            }
        });
    });
    /*
    // Função para fechar o modal
    function closeModal(modal, overlay) {
        modal.fadeOut(function () {
            modal.remove();
        });
        overlay.fadeOut(function () {
            overlay.remove();
        });
    }
        */
    // Ao clicar no botão de submit
    $(document).on('click', '#cardealer-submitBtn', function (event) {
        // Adiciona o spinner ao iniciar o AJAX
        /*
        if ($('.carGallery').length) {  // Verifica se a classe .carGallery existe
            var carGallerywidth = $('.carGallery').width();  // Obtém o width do elemento
            console.log('Width da .carGallery: ' + carGallerywidth);  // Exibe o width no console
        } else {
            console.log('.carGallery não encontrada.');
        }
        */
        $(document).on('ajaxStart', function () {
            $('.multiGallery').css('filter', 'brightness(0.7) opacity(0.7)');
            $('#cardealer-search-box').css('filter', 'brightness(0.7) opacity(0.7)');
            $('.carGallery').css('filter', 'brightness(0.7) opacity(0.7)');
            if ($('.loading-spinner').length === 0) {
                $('#cardealer-search-box').append('<div class="loading-spinner"></div>');
            }
            $('.loading-spinner').css('display', 'block'); // Mostra o spinner
            $('.loading-spinner').css({
                'position': 'fixed',           // Fixar o spinner na tela
                'top': '50%',                  // Centraliza verticalmente
                'left': '50%',                 // Centraliza horizontalmente
                'transform': 'translate(-50%, -50%)',  // Ajuste para centralizar exatamente
                'z-index': '9999',             // Garante que o spinner fique acima de outros elementos
                'width': '100px',               // Ajuste do tamanho, caso necessário
                'height': '100px',              // Ajuste do tamanho, caso necessário
                'border': '4px solid #f3f3f3', // Cor do spinner
                'border-top': '4px solid #3498db', // Cor da parte superior do spinner
                'border-radius': '50%',        // Torna o spinner redondo
                'animation': 'spin 1s linear infinite',  // Animação do spinner
                'filter': 'none'
            });
        });
        // Remove o spinner ao finalizar o AJAX
        $(document).on('ajaxStop', function () {
            $('.multiGallery').css('filter', 'none');
            $('#cardealer-search-box').css('filter', 'none');
            $('.loading-spinner').css('display', 'none'); // Mostra o spinner
            $('.carGallery').css('filter', 'none');
        });
        event.preventDefault(); // Evita o recarregamento da página
        var formData = $('#searchform3').serialize(); // 'searchform3' é o ID do formulário
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'cardealer_search_cars_ajax', // Nome da ação definida no PHP
                form_data: formData // Envia os dados do formulário serializados
            },
            success: function (response) {

                var sidebar = $(".sidebar"); // ou $(".sidebar") dependendo da classe ou ID
                if (sidebar.length > 0 && sidebar.css("display") !== "none") {
                    // sidebar.css("display", "none"); // Torna o sidebar invisível e não ocupa espaço
                    sidebar.css("visibility", "hidden");
                }

                //  console.log(carGallerywidth);
                /*
                if (typeof carGallerywidth !== 'undefined' && carGallerywidth !== 0) {
                    $('.carGallery').width(carGallerywidth);  // Ajusta o width com o valor da variável
                    $('#cardealer-search-box').width(carGallerywidth);
                } else {
                    console.log('A variável carGallerywidth não existe ou é zero.');
                }
                */
                if ($(".multiGallery").html() !== response) {
                    $(".multiGallery").html(response);  // Só atualiza se o conteúdo for diferente
                }
                if ($(".carGallery").html() !== response) {
                    $(".carGallery").html(response);  // Só atualiza se o conteúdo for diferente
                }



                // Verificar se existe um elemento com ID 'main'
                var mainElement = $('#main');

                // Se o elemento com ID 'main' existir e tiver 'position: absolute'
                if (mainElement.length > 0 && mainElement.css('position') === 'absolute') {
                    // Desativar o 'position: absolute' definindo como 'static' ou outro valor
                    mainElement.css('position', 'static');
                    console.log('Position alterado para static');
                }


            },
            error: function () {
                // console.error('Erro na consulta');
            }
        });
    });
    // Ao clicar nos links de navegação (paginção)
    // search content
    $(document).on('click', '.page-link', function (event) {
        event.preventDefault(); // Impede o comportamento padrão do link
        var page = $(this).attr('href').split('=')[1]; // Pega o número após "page="
        // console.error(page);
        var formData = $('#searchform3').serialize();
        formData += '&paged=' + page;
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'cardealer_search_cars_ajax', // Nome da ação definida no PHP
                form_data: formData // Envia os dados do formulário com o número da página
            },
            success: function (response) {
                // Atualiza o conteúdo da galeria com os resultados retornados
                if ($(".multiGallery").html() !== response) {
                    $(".multiGallery").html(response);  // Só atualiza se o conteúdo for diferente
                }
                if ($(".carGallery").html() !== response) {
                    $(".carGallery").html(response);  // Só atualiza se o conteúdo for diferente
                }
            },
            error: function () {
                // console.error('Erro na consulta');
            }
        });
    });
});
