<?php /**
 * @author Bill Minozzi
 * @copyright 2017
 */
if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly
if (is_admin()) {
    add_action('current_screen', 'cardealer_this_screen');

    function cardealer_this_screen()
    {
        // removed add_filter('contextual_help', 'CarDealer_contextual_help_fields', 10, 3);
        // called functions...directly

        require_once ABSPATH . 'wp-admin/includes/screen.php';
        $current_screen = get_current_screen();


        if ($current_screen->id === "edit-cardealerfields") {
            CarDealer_contextual_help_fields($current_screen);

        } elseif ($current_screen->id === "cars") {
            CarDealer_contextual_help_cars($current_screen);
        } elseif ($current_screen->id === "edit-team") {
            CarDealer_contextual_help_agents($current_screen);
        } elseif ($current_screen->id === "edit-locations") {
            CarDealer_contextual_help_locations($current_screen);
        } elseif ($current_screen->id === "edit-makes") {
            CarDealer_contextual_help_makes($current_screen);
        } elseif ($current_screen->id === "toplevel_page_car_dealer_plugin" or $current_screen->id === "admin_page_cardealer_settings") {
             CarDealer_main_help($current_screen);
        } else {
            if (isset($_GET['page'])) {
                if (sanitize_text_field($_GET['page']) == 'car_dealer_plugin') {
                    CarDealer_main_help($current_screen);
                }
            }
        }


    }
}
function CarDealer_main_help($screen)
{
    $myhelp = '<br>'. esc_attr__("The easiest way to manage, list and sell yours cars online.","cardealer");
    $myhelp .= '<br />';
    $myhelp .= esc_attr__("Follow the 3 steps in the Dashboard screen (Car Dealer => Dashboad) after install the plugin.","cardealer").' <br />';
    $myhelp .= '<br />';
    $myhelp .= esc_attr__("You will find Context Help in many screens.","cardealer");
    $myhelp .= '<br />';
    $myhelp .= esc_attr__("You can find also our complete OnLine Guide","cardealer");
    $myhelp .=  '<a href="https://cardealerplugin.com/help/" target="_self">';
    $myhelp .= ' '.esc_attr__("here.","cardealer");
    $myhelp .=  '</a>';
    
    $myhelpdemo = '<br />';
    $myhelpdemo .= esc_attr__("If you want to import demo data, download the demo data from this link:","cardealer");
    $myhelpdemo .= '<br />';
    $myhelpdemo .= 'https://cardealerplugin.com/demo-data/download-demo.php';
    $myhelpdemo .= '<br /><br />';
    $myhelpdemo .= esc_attr__("After download:","cardealer");
    $myhelpdemo .= '<br />';
    $myhelpdemo .= esc_attr__("1. Log in to that site as an administrator. ","cardealer");
    $myhelpdemo .= '<br />';
    $myhelpdemo .= esc_attr__("2. Go to Tools: Import in the WordPress admin panel.","cardealer");
    $myhelpdemo .= '<br />';
    $myhelpdemo .= esc_attr__('3. Install the "WordPress" importer from the list.',"cardealer");
    $myhelpdemo .= '<br />';
    $myhelpdemo .= esc_attr__("4. Activate & Run Importer.","cardealer");
    $myhelpdemo .= '<br />';
    $myhelpdemo .= esc_attr__("5. Upload the file downloaded using the form provided on that page.","cardealer");
    $myhelpdemo .= '<br />';
    $myhelpdemo .= esc_attr__("6. You will first be asked to map the authors in this export file to users","cardealer");
    $myhelpdemo .= '<br />';
    $myhelpdemo .= esc_attr__("on the site. For each author, you may choose to map to an","cardealer");
    $myhelpdemo .= '<br />';
    $myhelpdemo .= esc_attr__("existing user on the site or to create a new user. ","cardealer");
    $myhelpdemo .= '<br />';
    $myhelpdemo .= esc_attr__("7. WordPress will then import the demo data into you site.","cardealer");
    $myhelpdemo .= '<br />';
    $screen->add_help_tab(array(
        'id' => 'CarDealer-overview-tab',
        'title' => esc_attr__('Overview', 'cardealer'),
        'content' => '<p>' . $myhelp . '</p>',
    ));
    $screen->add_help_tab(array(
        'id' => 'import-demo',
        'title' => esc_attr__('Import Demo Data', 'cardealer'),
        'content' => '<p>' . $myhelpdemo . '</p>',
    ));
    return;
    // $contextual_help;
}
function CarDealer_contextual_help_fields($screen)
{
    $myhelp = esc_attr__("In the FIELDS screen you can manage the main table fields.
    This fields will show up
    in your main cars form management, search bar and search widget","cardealer");
    $myhelp .= '<br />';
    $myhelp .= esc_attr__("Each row represents one field.","cardealer");
    $myhelp .= '<br />';
    $myhelp .= esc_attr__("For example:","cardealer");
    $myhelp .= '<br />';
    $myhelp .= '<ul>';
    $myhelp .= '<li>';
    $myhelp .= esc_attr__("Number Doors","cardealer");
    $myhelp .= '</li>';
    $myhelp .= '<li>';
    $myhelp .= esc_attr__("Number Passengers","cardealer");
    $myhelp .= '</li>';
    $myhelp .= '<li>';
    $myhelp .= esc_attr__("Alarm","cardealer");
    $myhelp .= '</li>';
    $myhelp .= '<li>';
    $myhelp .= esc_attr__("And So On","cardealer");
    $myhelp .= '</li>';


    $myhelp .= '</ul>';
    $myhelp .= '<br />';
    $myhelp .= esc_attr__("You don\'t need include this fields: Price, Year, Miles, HP, Transmission Type, Fuel Type, Condition and Featured.","cardealer");
    $myhelp .= '<br />';
    $myhelp .= '<br />';
     $myhelp .= esc_attr__("Technical WordPress guys call this of Metadata.","cardealer");
     $myhelp .= '<br />';
    $myhelp .= esc_attr__("Don\'t create 2 fields with the same name.","cardealer");
    $myhelp .= '<br />';
    $myhelp .= '<br />';


    $myhelpAdd = esc_attr__("To add fields in the table, click the button Add New. This can open the empty window to include your information:","cardealer");
    $myhelpAdd .= '<br />';
    $myhelpAdd .= '</ul>';
    $myhelpAdd .= '<li>';
    $myhelpAdd .= esc_attr__("Field Name","cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd .= '<li>';
    $myhelpAdd .= esc_attr__("Field Label","cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd .= '<li>';
    $myhelpAdd .= esc_attr__("Field Order","cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd .= '<li>';
    $myhelpAdd .= esc_attr__("Show in Search Bar (your frontpage)","cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd .= '<li>';
    $myhelpAdd .= esc_attr__("Show in Search Widget (your frontpage)","cardealer");
    
    
    $myhelpAdd .= '</li>';
    $myhelpAdd .= '<li>';
    $myhelpAdd .= esc_attr__("Type of Field","cardealer");
    
    $myhelpAdd .= '</li>';
    $myhelpAdd .= '<li>';
    $myhelpAdd .= esc_attr__("And So On","cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd .= '</ul>';
    $myhelpAdd .= esc_attr__("In that screen, move the mouse pointer over each field to get help about that field.","cardealer");
    $myhelpAdd .= '<br />';
    $myhelpAdd .= esc_attr__("Just fill out and click OK button.","cardealer");
    $myhelpAdd .= '<br />';


    $myhelpTypes = esc_attr__("You have available this types of fields (Control Types):","cardealer");
    $myhelpTypes .= '<br />';
    $myhelpTypes .= '<ul>';
    $myhelpTypes .= '<li>';
    $myhelpTypes .= esc_attr__("Text (Used by text and numbers). It is not possible include this type of field in Search Bars.","cardealer");
    $myhelpTypes .= '</li>';
    $myhelpTypes .= '<li>';
    $myhelpTypes .= esc_attr__("CheckBox","cardealer");
    $myhelpTypes .= '</li>';
    $myhelpTypes .= '<li>';
    $myhelpTypes .= esc_attr__("Drop Down (also called select box)","cardealer");
    $myhelpTypes .= '</li>';
    $myhelpTypes .= '<li>';
    $myhelpTypes .= esc_attr__("Range Select (you can define de value min, max and step)","cardealer");
    $myhelpTypes .= '</li>';
    $myhelpTypes .= '</ul>';
    $myhelpTypes .= '<br />';
    $myhelpTypes .= esc_attr__("For more details about HTML input types, please, check this page:","cardealer");
    $myhelpTypes .= ' '.'<a href="https://www.w3schools.com/html/html_form_input_types.asp ">https://www.w3schools.com/html/html_form_input_types.asp</a>';
    $myhelpTypes .= '<br />';



    $myhelpEdit = esc_attr__("You can manage the table, i mean, Add, Edit and Trash Fields.","cardealer");
    $myhelpEdit = '<br />';
    $myhelpEdit .=__("At the Add Fields and Edit Fields forms, put the mouse over each row and the menu show up. Then, click over Edit or Trash.","cardealer");
    $myhelpEdit = '<br />';
    $myhelpEdit .=__("To know more about Edit Fields, please, check the Add Fields Form Option at this help menu.","cardealer");
 
    $screen->add_help_tab(array(
        'id' => 'CarDealer-overview-tab',
        'title' => esc_attr__('Overview', 'cardealer'),
        'content' => '<p>' . $myhelp . '</p>',
    ));
    $screen->add_help_tab(array(
        'id' => 'CarDealer-field-types',
        'title' => esc_attr__('Field Types', 'cardealer'),
        'content' => '<p>' . $myhelpTypes . '</p>',
    ));
    $screen->add_help_tab(array(
        'id' => 'CarDealer-overview-add',
        'title' => esc_attr__('Add Fields Form', 'cardealer'),
        'content' => '<p>' . $myhelpAdd . '</p>',
    ));
    $screen->add_help_tab(array(
        'id' => 'CarDealer-field-edit',
        'title' => esc_attr__('Edit and Trash Fields', 'cardealer'),
        'content' => '<p>' . $myhelpEdit . '</p>',
    ));
    return;
}
function CarDealer_contextual_help_cars($screen)
{
    $myhelp = esc_attr__("In the CARS screen you can manage (include, edit or delete) items in your Cars table.","cardealer");
    $myhelp .= esc_attr__("This cars will show up in your site front page.","cardealer");
    $myhelp .= '<br />';
    $myhelp .= esc_attr__("We suggest you take some time to complete your Field table before this step.","cardealer");
    $myhelp .= '<br />';
    $myhelp .= esc_attr__("Dashboard => CarDealer => Fields Table.","cardealer");
    $myhelp .= '<br />';
    $myhelp .= esc_attr__("You will find some fields automatically included by the system (Price, Year, Miles, HP, Transmission type, Type, Fuel, Condition and Featured).","cardealer");
    $myhelp .= esc_attr__("Just add your cars in this table.","cardealer");
    $myhelp .= '<br />';

    $myhelpAdd = esc_attr__('To add fields in the table, click the button Add New. This can open the empty window to include your information:',"cardealer");
    $myhelpAdd .= '<br />';
    $myhelpAdd .= '<ul>';
    $myhelpAdd .= '<li>';
    $myhelpAdd = esc_attr__('Field Name',"cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd .= '<li>';
    $myhelpAdd .= esc_attr__('Field Label',"cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd = '<li>';
    $myhelpAdd .= esc_attr__('Field Order',"cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd .= '<li>';
    $myhelpAdd .= esc_attr__('Show in Search Bar (your frontpage)',"cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd = '<li>';
    $myhelpAdd .= esc_attr__('Show in Search Widget (your frontpage)',"cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd = '<li>';
    $myhelpAdd .= esc_attr__('Type of Field',"cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd = '<li>';
    $myhelpAdd .= esc_attr__('And So On',"cardealer");
    $myhelpAdd .= '</li>';
    $myhelpAdd .= '</ul>';
    $myhelpAdd .= esc_attr__('In that screen, move the mouse pointer over each field to get help about that field.',"cardealer");
    $myhelpAdd .= '<br />';
    $myhelpAdd .= esc_attr__('Just fill out and click OK button.',"cardealer");
    $myhelpAdd .= '<br />';


    $myhelpAgents = esc_attr__('Use the Team control it is optional. To add new members, go to:',"cardealer");
    $myhelpAgents .= '<br />';
    $myhelpAgents .= 'Dashboard=> Car Dealer => Team';
    $myhelpAgents .= '<br />';
    $myhelpAgents .= '<br />';
    
    $myhelpLocation = esc_attr__('Use the Location control it is optional. Maybe you want use it if you have more than one location.',"cardealer");
    $myhelpLocation .= esc_attr__('To add new locations, go to:',"cardealer");
    $myhelpLocation .= '<br />';
    $myhelpLocation .= 'Dashboard=> Car Dealer => Locations';
    $myhelpLocation .= '<br />';
    $myhelpLocation .= esc_attr__('If you are, for example, in Florida, maybe you want add:',"cardealer");
    $myhelpLocation .= '<li>';
    $myhelpLocation .= esc_attr__('Fort Lauderdale',"cardealer");
    $myhelpLocation .= '</li>';
    $myhelpLocation .= '<li>';
    $myhelpLocation .= esc_attr__('Miami',"cardealer");
    $myhelpLocation .= '</li>';
    $myhelpLocation .= '<li>';
    $myhelpLocation .= esc_attr__('And So On...',"cardealer");
    $myhelpLocation .= '</li>';
    $myhelpLocation .= '</ul>';
    $myhelpLocation .= '<br />';
    $myhelpLocation .= '<br />';



    $myhelpMake = esc_attr__('Use the Makes control it is optional.',"cardealer");
    $myhelpMake .= esc_attr__('To add new makes, go to:',"cardealer");
    $myhelpMake .= '<br />';
    $myhelpMake .= 'Dashboard=> Car Dealer => Makes';
    $myhelpMake .= '<br />';
    $myhelpMake .= esc_attr__('Maybe you want add:',"cardealer");
    $myhelpMake .= '<ul>';
    $myhelpMake .= '<li>';
    $myhelpMake .= esc_attr__('Ford',"cardealer");
    $myhelpMake .= '</li>';
    $myhelpMake .= '<li>';
    $myhelpMake .= esc_attr__('Toyota',"cardealer");
    $myhelpMake .= '</li>';
    $myhelpMake .= '<li>';
    $myhelpMake .= esc_attr__('And So On...',"cardealer");
    $myhelpMake .= '</li>';
    $myhelpMake .= '</ul>';
    $myhelpMake .= '<br />';
    $myhelpMake .= '<br />';


    $myhelpEdit = esc_attr__('You can manage the table, i mean, Add, Edit and Trash Cars.',"cardealer");
    $myhelpEdit .= '<br />';
    $myhelpEdit .= esc_attr__('Use the Add New Buttom or to Edit, put the mouse over each row and the menu will show up. Then, click over Edit or Trash.',"cardealer");
    $myhelpEdit .= '<br />';




    $myhelpFeatured = esc_attr__('You can add one main image to each car.',"cardealer");
    $myhelpFeatured .= esc_attr__('In the Cars Form, click the button Set Featured Image at bottom right corner.',"cardealer");
    $myhelpFeatured .= '<br />'; 
    $myhelpFeatured .= esc_attr__("Read below Images and Gallery menu voice about how to create a Image\'s gallery with many images to show up at the top of your car\'s page.","cardealer");
    $myhelpFeatured .= '<br />';
    $myhelpFeatured .= '<br />';



    $myhelpGallery = esc_attr__('You can add many Images or one gallery for each car.',"cardealer");
    $myhelpGallery .= esc_attr__('Just go to Cars Form and add the images (or the gallery) in the main description field (click the Add Media buttom).',"cardealer");
    $myhelpGallery .= '<br />'; 
    $myhelpGallery .= '<br />'; 
    $myhelpGallery .= esc_attr__('Use the default WordPress Gallery or our plugin will create automatically one nice slider gallery. To enable the plugin gallery, go to',"cardealer");
    $myhelpGallery .= '<br />'; 
    $myhelpGallery .= 'Dashboard => Car Dealer => Settings';
    $myhelpGallery .= '<br />'; 
    $myhelpGallery .= esc_attr__('and look for',"cardealer"); 
    $myhelpGallery .= '<em>';
    $myhelpGallery .= esc_attr__('Replace the Wordpress Gallery with Flexslider Gallery',"cardealer");
    $myhelpGallery .= '</em>';
    $myhelpGallery .= '?';
    $myhelpGallery .= '<br />'; 
    $myhelpGallery .= esc_attr__('Then, check Yes and Save Changes.',"cardealer");
    $myhelpGallery .= '<br />'; 
    $myhelpGallery .= esc_attr__('This images and gallery will be visible in single car page.',"cardealer");
    $myhelpGallery .= '<br />'; 
    $myhelpGallery .= esc_attr__('Look',"cardealer"); 
    $myhelpGallery .= ' '.'<a href="http://cardealerplugin.com/upload-images/">';
    $myhelpGallery .= esc_attr__('our demo',"cardealer"); 
    $myhelpGallery .= ' </a>'; 
    $myhelpGallery .= esc_attr__('about how to upload and crop images easily (less than 2 minutes).',"cardealer");
    $myhelpGallery .= '<br />'; 
    $myhelpGallery .= esc_attr__('To get more info about galleries,',"cardealer");
    $myhelpGallery .= ' '.'<a href="https://en.support.wordpress.com/gallery/" target="_blank">';
    $myhelpGallery .= esc_attr__('visit WordPress Help site.',"cardealer");
    $myhelpGallery .= '</a>.';
    $myhelpGallery .= '<br />'; 




    $screen->add_help_tab(array(
        'id' => 'CarDealer-overview-tab',
        'title' => esc_attr__('Overview', 'cardealer'),
        'content' => '<p>' . $myhelp . '</p>',
    ));
    $screen->add_help_tab(array(
        'id' => 'CarDealer-cars-agents',
        'title' => esc_attr__('Team', 'cardealer'),
        'content' => '<p>' . $myhelpAgents . '</p>',
    ));
    $screen->add_help_tab(array(
        'id' => 'CarDealer-cars-location',
        'title' => esc_attr__('Location', 'cardealer'),
        'content' => '<p>' . $myhelpLocation . '</p>',
    ));
    $screen->add_help_tab(array(
        'id' => 'CarDealer-cars-makes',
        'title' => esc_attr__('Makes', 'cardealer'),
        'content' => '<p>' . $myhelpMake . '</p>',
    ));
    $screen->add_help_tab(array(
        'id' => 'CarDealer-cars-edit',
        'title' => esc_attr__('Edit and Trash Cars', 'cardealer'),
        'content' => '<p>' . $myhelpEdit . '</p>',
    ));
    $screen->add_help_tab(array(
        'id' => 'CarDealer-cars-featured',
        'title' => esc_attr__('Featured Image', 'cardealer'),
        'content' => '<p>' . $myhelpFeatured . '</p>',
    ));
    $screen->add_help_tab(array(
        'id' => 'CarDealer-cars-gallery',
        'title' => esc_attr__('Images and Gallery', 'cardealer'),
        'content' => '<p>' . $myhelpGallery . '</p>',
    ));
    return;
}
function CarDealer_contextual_help_agents($screen)
{
    $myhelpAgents = esc_attr__('Use the Team table it is optional.',"cardealer");
    $myhelpAgents .= '<br />';

    $screen->add_help_tab(array(
        'id' => 'CarDealer-overview-tab',
        'title' => esc_attr__('Overview', 'cardealer'),
        'content' => '<p>' . $myhelpAgents . '</p>',
    ));
    return;
}
function CarDealer_contextual_help_locations($screen)
{
    $myhelpLocation = esc_attr__('Use the Location table it is optional. Maybe you want use it if you have more than one location.','cardealer');

    $myhelpLocation .= '<br />';

    $myhelpLocation .= esc_attr__('If you are, for example, in Florida, maybe you want add:','cardealer');
    $myhelpLocation .= '<ul>';
    $myhelpLocation .= '<li>';
    $myhelpLocation .= esc_attr__('Fort Lauderdale','cardealer');
    $myhelpLocation .= '</li>';
    $myhelpLocation .= '<li>';
    $myhelpLocation .= esc_attr__('Miami','cardealer');
    $myhelpLocation .= '</li>';
    $myhelpLocation .= '<li>';
    $myhelpLocation .= esc_attr__('And So On...','cardealer');
    $myhelpLocation .= '</li>';
    $myhelpLocation .= '</ul>';
    $myhelpLocation .= '<br />';

    $screen->add_help_tab(array(
        'id' => 'CarDealer-overview-tab',
        'title' => esc_attr__('Overview', 'cardealer'),
        'content' => '<p>' . $myhelpLocation . '</p>',
    ));
    return;
}
function CarDealer_contextual_help_makes($screen)
{
    $myhelpMake = esc_attr__('Use the Makes control it is optional.','cardealer');
    $myhelpMake .= esc_attr__('To add new makes, go to:','cardealer');
    $myhelpMake .= '<br />';
    $myhelpMake .= 'Dashboard=> Car Dealer => Makes';
    $myhelpMake .= '<br />';
    $myhelpMake .= esc_attr__('Maybe you want add alguns some makes. (Ford, Toyota...)','cardealer');
    /*  $myhelpMake .= '<ul>';
    $myhelpMake .= '<li';
    $myhelpMake .= esc_attr__('Ford','cardealer');
    $myhelpMake .= '</li';
    $myhelpMake .= '<li';
    $myhelpMake .= esc_attr__('Toyota','cardealer');
    $myhelpMake .= '</li';
    $myhelpMake .= '<li';
    $myhelpMake .= esc_attr__('And So On...','cardealer');
    $myhelpMake .= '</li';
    $myhelpMake .= '</ul>';
    */
    $myhelpMake .= '<br />';
    $myhelpMake .= '<br />';
  
  
  
  
   $screen->add_help_tab(array(
        'id' => 'CarDealer-overview-tab',
        'title' => esc_attr__('Overview', 'cardealer'),
        'content' => '<p>' . $myhelpMake . '</p>',
    ));
    return;
}
/////////// Pointers ////////////////
add_action('admin_enqueue_scripts', 'cardealer_adm_enqueue_scripts2');
function cardealer_adm_enqueue_scripts2()
{
    global $cardealer_bill_current_screen;
    // wp_enqueue_style( 'wp-pointer' );
    wp_enqueue_script('wp-pointer');
    require_once ABSPATH . 'wp-admin/includes/screen.php';
    $myscreen = get_current_screen();
    $cardealer_bill_current_screen = $myscreen->id;
    if ($cardealer_bill_current_screen == 'cars' or $cardealer_bill_current_screen == 'toplevel_page_car_dealer_plugin' or $cardealer_bill_current_screen == 'edit-cardealerfields') 
    {} else {
        return;
    }
    $dismissed = explode(',', (string) get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
    if (in_array($cardealer_bill_current_screen, $dismissed)) {
        return;
    }
    if (get_option('CarDealer_activated', '0') == '1') 
        add_action('admin_print_footer_scripts', 'cardealer_admin_print_footer_scripts');
}
function cardealer_admin_print_footer_scripts()
{
    global $cardealer_bill_current_screen;
    $pointer_content = esc_attr__('Help Available for this Window!','cardealer');
    $pointer_content2 = esc_attr__('Just Click Help Button to get content help for this window.','cardealer');
    ?>
        <script type="text/javascript">
        //<![CDATA[
            // setTimeout( function() { this_pointer.pointer( 'close' ); }, 400 );
        jQuery(document).ready( function($) {
            $('#contextual-help-link').pointer({
                content: '<?php echo '<h3>'.esc_attr($pointer_content).'</h3>'.'<p>'.esc_attr($pointer_content2).'</p>'; ?>',
                position: {
                        edge: 'top',
                        align: 'right'
                    },
                close: function() {
                    // Once the close button is hit
                    $.post( ajaxurl, {
                            pointer: '<?php echo esc_attr($cardealer_bill_current_screen); ?>',
                            action: 'dismiss-wp-pointer'
                        });
                }
            }).pointer('open');
            /* $('.wp-pointer-undefined .wp-pointer-arrow').css("right", "50px"); */
        });
        //]]>
        </script>
        <?php
}
?>
