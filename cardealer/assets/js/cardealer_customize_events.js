jQuery(document).ready(function($) {
    // console.log('loaded customize events!');
    jQuery('*').click(function(event) {
       var pageTitle = 'page=Car_Dealer_Designer';  
       var linkUrl = event.target.href; 
        if (linkUrl === null || linkUrl === undefined) {
          return;
        }
        //console.log(linkUrl);
        if (linkUrl.indexOf(pageTitle) !== -1) {
          event.preventDefault();
          //console.log("URL contains 'example'");
          var customize_url = "/wp-admin/customize.php?autofocus[panel]=bill_designer"; // Set the Customizer URL directly
          window.location.href = customize_url; // 
        } 
    });
});