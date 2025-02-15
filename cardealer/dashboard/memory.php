<?php
/**
 * @author William Sergio Minozzi
 * @copyright 2017
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly 
$cardealer_memory = cardealer_check_memory();
echo '<div id="cardealer-memory-page">';
echo '<div class="cardealer-block-title">';
    if ( $cardealer_memory['msg_type'] == 'notok')
       {
        esc_attr_e("Unable to get your Memory Info","cardealer"); 
        echo '</div>';
    }
    else
    {
esc_attr_e("Memory Info","cardealer"); 
echo '</div>';
echo '<div id="memory-tab">';
echo '<br />';
if($cardealer_memory['msg_type']  == 'ok')
  $mb = 'MB';
else
  $mb = '';
if ($cardealer_memory['limit'] > 9999){
    $cardealer_memory['limit'] = ($cardealer_memory['limit'] / 1024);
    $mbl = 'TB';
}
else {
   $mbl = 'MB';
}


echo esc_attr__("Current memory WordPress Limit:","cardealer").' ' . esc_attr($cardealer_memory['wp_limit']) . esc_attr($mb) .
    '&nbsp;&nbsp;&nbsp;  |&nbsp;&nbsp;&nbsp;';
$perc = $cardealer_memory['usage'] / $cardealer_memory['wp_limit'];
if ($perc > .7)
   echo '<span style="'.esc_attr($cardealer_memory['color']).';">';
echo esc_attr__("Your usage now:","cardealer").' ' . esc_attr($cardealer_memory['usage']) .
    'MB &nbsp;&nbsp;&nbsp;';
if ($perc > .7)
   echo '</span>';    
echo '|&nbsp;&nbsp;&nbsp;'. esc_attr__("Total Server Memory:","cardealer") .' '. esc_attr($cardealer_memory['limit']) . esc_attr($mbl);
// echo 'Current memory WordPress Limit: '.$cardealer_memory['wp_limit'].$mb.'&nbsp;&nbsp;&nbsp;  |&nbsp;&nbsp;&nbsp;   Your usage: '.$cardealer_memory['usage'].'MB of '.$cardealer_memory['limit'];
   echo '<br />';    
   echo '<br />'; 
   echo '<br />';
?>  
   </strong>
<!-- <div id="memory-tab"> -->
<?php
///////////////////////////
// Fix it...

     echo esc_attr__("If you want adjust and control your WordPress Memory Limit and PHP Memory Limit quickly, try our free plugin WPmemory:","cardealer"); 

     echo '<br />';
     echo '<a href="https://wordpress.org/plugins/wp-memory/">'.esc_attr__("Learn More","cardealer").'</a>';
 
     echo '<br />';
     echo '<br />';
     echo '<hr>';
     esc_attr_e("Follow this instructions to do it manually:","cardealer");
     echo '<br />';

//////////////////////////////
?>

    <br />
    <?php esc_attr_e("To increase the WordPress memory limit, add this info to your file wp-config.php (located at root folder of your server)","cardealer"); ?> 
    <br />
    <?php esc_attr_e("(just copy and paste)","cardealer"); ?> 
    
    <br />    <br />
<strong>    
define('WP_MEMORY_LIMIT', '128M');
</strong>
    <br />    <br />
    <?php esc_attr_e("before this row:","cardealer"); ?> 
    
    <br />
    /* That's all, stop editing! Happy blogging. */
    <br />
    <br />
    <?php esc_attr_e("If you need more, just replace 128 with the new memory limit.","cardealer"); ?> 
    <br /> 
    <?php esc_attr_e("To increase your total server memory, talk with your hosting company.","cardealer"); ?> 
   
    <br />   <br />
    <hr />
    <br />    
<strong>   
<?php esc_attr_e("How to Tell if Your Site Needs a Shot of more Memory:","cardealer"); ?>  
    </strong>
        <br />    <br />
        <?php esc_attr_e("If your site is behaving slowly, or pages fail to load, you 
    get random white screens of death or 500 
    internal server error you may need more memory. 
Several things consume memory, such as WordPress itself, the plugins installed, the 
theme you're using and the site content.","cardealer"); ?> 
     <br />  
     <?php esc_attr_e("Basically, the more content and features you add to your site, 
the bigger your memory limit has to be.
if you're only running a small 
site with basic functions without a Page Builder and Theme 
Options (for example the native Twenty Sixteen). However, once 
you use a Premium WordPress theme and you start encountering 
unexpected issues, it may be time to adjust your memory limit 
to meet the standards for a modern WordPress installation.","cardealer"); ?>
     <br /> <br /> 
     <?php esc_attr_e("   
    Increase the WP Memory Limit is a standard practice in 
WordPress and you find instructions also in the official 
WordPress documentation (Increasing memory allocated to PHP).","cardealer"); ?> 
    <br /><br />
    <?php esc_attr_e("Here is the link: ","cardealer"); ?> 
   
<br />
<a href="https://codex.wordpress.org/Editing_wp-config.php" target="_blank">https://codex.wordpress.org/Editing_wp-config.php</a>
<br /><br />
</div>
</div>
<?php
}
?>