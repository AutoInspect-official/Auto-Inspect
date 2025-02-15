<?php /**
 * @author Bill Minozzi
 * @copyright 2018
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
function cardealer_show_team()
{
    $cardealerTeam = cardealer_reorder_terms();
    $qagents = count($cardealerTeam);
    $output = '';
    $output .= '<div class="container cardealer_wrapteam">';
    if ($qagents > 0) {
         $i = 0;
        foreach ($cardealerTeam as $term) {
          if($i % 3 == 0 or $i == 0)  
             $output .= '<div class="row align-items-start">'; // row
            $image = $term['image'];
           // $image = aq_resize( $image, 800, 400, true ); //resize & crop the image
            if (empty($image)) {
                $image = CARDEALERIMAGES . 'image-no-available-800x400_br.jpg';
                //$image = str_replace("-", "", $image);
            }
            $name = $term['name'];
            $description = $term['description'];
            $function = $term['function'];
            $phone = $term['phone'];
            $email = $term['email'];
            $skype = $term['skype'];
            $skype = $term['skype'];
            $facebook = $term['facebook'];
            $twitter = $term['twitter'];
            $linkedin = $term['linkedin'];
            $vimeo = $term['vimeo'];
            $instagram = $term['instagram'];
            $youtube = $term['youtube'];
            // 6 divide 50%
            // 4  33%
            $output .= '<div class="col-md-4 col-lg-4 cardealer_wrapindividual">'; // start single member
            $output .= '<div class="reatestateimg-team">';
            $output .= '<img class="reatestateimg-img_team" src="' . $image . '" />';
            $output .= '</div>'; //image
            $output .= '<div class="cardealer_nameteam">';
            $output .= $name;
            $output .= '</div>'; //title
            $output .= '<div class="cardealer_cardealer_team_function">';
            $output .= $function;
            $output .= '</div>'; //function
            $output .= '<div class = "cardealer_descriptionteam">';
            $output .= substr($description, 0, 140);
            $output .= '</div>';
            if (!empty($phone)) {
                $output .= '<div class = "cardealer_phone_team">';
                $output .= '<i class="fa fa-phone" aria-hidden="true"></i>';
                $output .= '&nbsp;' . $phone;
                $output .= '</div>';
            }
            if (!empty($skype)) {
                $output .= '<div class = "cardealer_skype_team">';
                $output .= '<i class="fa fa-skype" aria-hidden="true"></i>';
                $output .= '&nbsp;' . $skype;
                $output .= '</div>';
            }
            if (!empty($email)) {
                $output .= '<div class = "cardealer_email_team">';
                $output .= '<i class="fa fa-envelope-o" aria-hidden="true"></i>';
                $output .= '&nbsp;' . $email;
                $output .= '</div>';
            }
            $output .= '<div class = "cardealer_iconswrap">';
            if (!empty($facebook)) {
                $output .= '<div class = "cardealer_iconsteam">';
                $output .= ' <a href="http://facebook.com/' . $facebook .
                    '"><i class="fa fa-facebook" aria-hidden="true"></i></a> ';
                $output .= '</div>';
            }
            if (!empty($twitter)) {
                $output .= '<div class = "cardealer_iconsteam">';
                $output .= ' <a href="http://twitter.com/' . $twitter .
                    '"><i class="fa fa-twitter" aria-hidden="true"></i></a> ';
                $output .= '</div>';
            }
            if (!empty($linkedin)) {
                $output .= '<div class = "cardealer_iconsteam">';
                $output .= ' <a href="http://linkedin.com/' . $linkedin .
                    '"><i class="fa fa-linkedin" aria-hidden="true"></i></a> ';
                $output .= '</div>';
            }
            if (!empty($instagram)) {
                $output .= '<div class = "cardealer_iconsteam">';
                $output .= ' <a href="http://instagram.com/' . $instagram .
                    '"><i class="fa fa-instagram" aria-hidden="true"></i></a> ';
                $output .= '</div>';
            }
            if (!empty($vimeo)) {
                $output .= '<div class = "cardealer_iconsteam">';
                $output .= ' <a href="http://vimeo.com/' . $vimeo .
                    '"><i class="fa fa-vimeo" aria-hidden="true"></i></a> ';
                $output .= '</div>';
            }
            if (!empty($youtube)) {
                $output .= '<div class = "cardealer_iconsteam">';
                $output .= ' <a href="http://youtube.com/' . $youtube .
                    '"><i class="fa fa-youtube" aria-hidden="true"></i></a> ';
                $output .= '</div>';
            }
            $output .= '</div>'; //icons wrap
            $output .= '</div>'; //Single
         $i++;
         if($i % 3 == 0 or $i >= $qagents )
            $output .= '</div>'; // row; 
        }
    } else {
        $output .= __("No Team Member Added!", "cardealer") ;
    }
    $output .= '</div>'; //container

    $cardealer_allowed_atts = array(
        'align'      => array(),
        'class'      => array(),
        'type'       => array(),
        'id'         => array(),
        'dir'        => array(),
        'lang'       => array(),
        'style'      => array(),
        'xml:lang'   => array(),
        'src'        => array(),
        'alt'        => array(),
        'href'       => array(),
        'rel'        => array(),
        'rev'        => array(),
        'target'     => array(),
        'novalidate' => array(),
        'type'       => array(),
        'value'      => array(),
        'name'       => array(),
        'tabindex'   => array(),
        'action'     => array(),
        'method'     => array(),
        'for'        => array(),
        'width'      => array(),
        'height'     => array(),
        'data'       => array(),
        'title'      => array(),

        'checked' => array(),
        'selected' => array(),


    );
    $cardealer_my_allowed['form'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['select'] = $cardealer_allowed_atts;
    // select options
    $cardealer_my_allowed['option'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['style'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['label'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['input'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['textarea'] = $cardealer_allowed_atts;
    
    //more...future...
    $cardealer_my_allowed['form']     = $cardealer_allowed_atts;
    $cardealer_my_allowed['label']    = $cardealer_allowed_atts;
    $cardealer_my_allowed['input']    = $cardealer_allowed_atts;
    $cardealer_my_allowed['textarea'] = $cardealer_allowed_atts;
    $cardealer_my_allowed['iframe']   = $cardealer_allowed_atts;
    $cardealer_my_allowed['script']   = $cardealer_allowed_atts;
    $cardealer_my_allowed['style']    = $cardealer_allowed_atts;
    $cardealer_my_allowed['strong']   = $cardealer_allowed_atts;
    $cardealer_my_allowed['small']    = $cardealer_allowed_atts;
    $cardealer_my_allowed['table']    = $cardealer_allowed_atts;
    $cardealer_my_allowed['span']     = $cardealer_allowed_atts;
    $cardealer_my_allowed['abbr']     = $cardealer_allowed_atts;
    $cardealer_my_allowed['code']     = $cardealer_allowed_atts;
    $cardealer_my_allowed['pre']      = $cardealer_allowed_atts;
    $cardealer_my_allowed['div']      = $cardealer_allowed_atts;
    $cardealer_my_allowed['img']      = $cardealer_allowed_atts;
    $cardealer_my_allowed['h1']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['h2']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['h3']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['h4']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['h5']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['h6']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['ol']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['ul']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['li']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['em']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['hr']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['br']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['tr']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['td']       = $cardealer_allowed_atts;
    $cardealer_my_allowed['p']        = $cardealer_allowed_atts;
    $cardealer_my_allowed['a']        = $cardealer_allowed_atts;
    $cardealer_my_allowed['b']        = $cardealer_allowed_atts;
    $cardealer_my_allowed['i']        = $cardealer_allowed_atts;
     
    
    return wp_kses($output, $cardealer_my_allowed);
    //Sreturn $output;


}
add_shortcode('cardealer_team', 'cardealer_show_team'); ?>