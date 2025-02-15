/*
 * @ Author: Bill Minozzi
 * @ Copyright: 2021 www.BillMinozzi.com
 * @ Modified time: 2021-29-11 09:17:42
 * */
jQuery(document).ready(function ($) {
    // console.log('vendor-cd');
    $(".spinner").hide();
    // console.log('vendor-cd'); 
    $("#cardealer-vendor-ok").click();
    $("#TB_title").hide();
    if (!$("#TB_window").is(':visible')) {
        $("#cardealer-vendor-ok").click();
        // console.log('auto click');
    }
    $("*").click(function (ev) {
      //  ev.preventDefault();
        //  alert('2');
        // console.log('click');
        // console.log(ev.target.id);
         //$(this).attr("class");
        // console.log($(this).attr("class"));
        if (ev.target.id == "bill-vendor-button-ok-cd") {
         //    console.log("Learn More");
            window.location.replace("http://cardealerplugin.com/premium//");
        }
        if (ev.target.id == "bill-vendor-button-again-cd") {
           //  console.log("watch again");
           // $("#bill-banner-cd").get(0).play();
            $("#bill-banner-cd").get(0).play().catch(function () {
                // console.log("Fail to Play.");
                self.parent.tb_remove();
                $('#TB_window').fadeOut();
                $("#TB_closeWindowButton").click();
            });
        }
        if ( ev.target.id == "bill-vendor-button-dismiss-cd" || $(this).attr("class") == "tb-close-icon"  ) {
            // event.preventDefault()
             // console.log('clicked !!---!!!!');
            $("#bill-banner-cd").hide();
            /*  $("#bill-banner-cd").html("Please, wait...") */
             $("#cardealer-wait").show();
             $("#cardealer-wait").addClass("is-active");
             // console.log('clicked Dimiss !!!!!!');
             cardealer_setCookie('cd_dismiss', '1', '1');
             $("#bill-vendor-button-dismiss-cd").hide();
             $("#bill-vendor-button-again-cd").hide();
             $("#bill-vendor-button-ok-cd").hide();
             $(".spinner").addClass("is-active");
             $(".spinner").show();
             jQuery.ajax({
                method: 'post',
                url: ajaxurl,
                data: {
                    action: "cardealer_cardealer_bill_go_pro_hide2"
                },
                success: function (data) {
                    console.log('OK-dismissed!!!');
                    setTimeout(myFunction, 3000);
                    // return data;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error' + errorThrown + ' ' + textStatus);
                }
            });
            //console.log("fechar");
            function myFunction() {
                self.parent.tb_remove();
                $('#TB_window').fadeOut();
                $("#TB_closeWindowButton").click();
            }
        }
    }); // click
    if ($('#bill-banner-cd').length) {
        //  $("#bill-banner-cd").get(0).play();
        $("#bill-banner-cd").get(0).play().catch(function () {
            // console.log("Fail to Play.");
            self.parent.tb_remove();
            $('#TB_window').fadeOut();
            $("#TB_closeWindowButton").click();
        });
    }
    $("#TB_window").height(260);
    // $("#TB_window").width(550);
    $("#TB_window").addClass("bill_TB_window");
    function cardealer_setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
      }
      function cardealer_getCookie(cookieName) {
        let cookie = {};
        document.cookie.split(';').forEach(function(el) {
          let [key,value] = el.split('=');
          cookie[key.trim()] = value;
        })
        return cookie[cookieName];
      }
});