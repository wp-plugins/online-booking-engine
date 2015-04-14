<?php
/*
Plugin Name: eZee Reservation
Plugin URL: http://ezeereservation.com
Description: To set eZee Reservation in your page
Version: 1.0.0
Author: KK
Author URI: http://www.ezeereservation.com
Contributors: eZee Team
*/
/*
 * Register wpezeebe
 *
 */
// Initialization function


add_action('admin_menu', 'ezeebe_plugin_settings');

 //Register css / script for admin side
function ezeebe_plugin_settings() { 
    
    add_menu_page('eZee Reservation Settings', 'eZee Reservation', 'administrator', 'ezee_settings', 'ezee_be_settings');
     if (is_admin()) {
     wp_register_style('ezeereservation_styles', plugins_url('css/ezee.css', __FILE__));
     wp_enqueue_style('ezeereservation_styles'); 
    }
}

//Register script for front side
add_action('init', 'ezeebe_register_front_script');
add_action('wp_footer', 'ezeebe_print_front_script');

function ezeebe_register_front_script() {
    if (!is_admin()) {
    wp_register_script('online-booking-engine-script', plugins_url('js/ezee-res.js', __FILE__), array('jquery'), '1.0', true);
}
}

//print script only on page where shortcode has been used
function ezeebe_print_front_script() {
    global $ezeebe_add_front_script;

    if ( ! $ezeebe_add_front_script )
        return;

    wp_print_scripts('online-booking-engine-script');
}

add_action('wp_enqueue_scripts', 'ezee_scripts');


//ezee reservation property code settings
function ezee_scripts() 
{   
    global $post;
    $ezeebe_property_code  = (get_option('ezee_procode') == '') ? "vpineresort" : get_option('ezee_procode');
}

function ezee_be_settings($instance)
{

    $ezeebe_property_code = (get_option('ezee_procode') != '') ? get_option('ezee_procode') : 'vpineresort';   
                        
    $ezeebe_html = '</pre>
            <div class="wrap"> 
            <form action="options.php" method="post" name="options" class="ezeesettingfrm">
            <h2>Reservation Settings</h2>
            ' . wp_nonce_field('update-options') . '
             <p>
            <label>Enter property code</label>
            <input class="regular-text" type="text" name="ezee_procode" value="' . $ezeebe_property_code . '" /><br>
            <div class="codeinfo">To set Booking Engine on website page copy paste  <b> [ezee_booking_engine_code] </b> code in page</div>
             </p>          
             <p>
            <input type="hidden" name="action" value="update"/>
             <div style="clear:both; width:100%;"></div>
            <input type="hidden" name="page_options" value="ezee_procode" />
           
            <label>.</label><input type="submit" name="Submit" value="Update" class="button button-primary" />
            </p>
            </form></div>
            <pre>           
            ';
 
    echo $ezeebe_html;
}

//get property code
function get_ezeebe()
{ 
    global $ezeebe_add_front_script;
    $ezeebe_add_front_script = true;           
    $ezeebe_bepropertyname = (get_option('ezee_procode') != '') ? get_option('ezee_procode') : 'vpineresort';                          
    $ezeebe_bepropertynameurl = "http://live.ipms247.com/booking/book-rooms-".$ezeebe_bepropertyname;
    $ezeebe_iframecode = 
            ' 
            <p style="text-align:center;"><iframe src="'.$ezeebe_bepropertynameurl.'" width=937 height=1125 frameborder="0" name="editframe" class="editframe" id="editframe" marginheight="83" marginwidth="188" scrolling="no" align="center">
            </iframe></p>
            ';

    echo $ezeebe_iframecode;
}
//shortcode
add_shortcode('ezee_booking_engine_code','get_ezeebe');