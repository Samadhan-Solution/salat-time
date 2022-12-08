<?php
namespace  SalatTimes;
use DateTime;

class API
{
    function __construct() {
        add_action('rest_api_init', function ()
        {
            register_rest_route('salat/v1', '/time', array(
                'methods' => 'GET',
                'callback' => array( 'SalatTimes\API', 'get_salat_times' )
            ));
            register_rest_route('salat/v1', '/time', array(
                'methods' => 'POST',
                'callback' => array( 'SalatTimes\API', 'save_salat_times' )
            ));
        });
    }


    public static function IsAuthorized()
    {
        //return true;

        $nonce = '';
        if (isset($_REQUEST['_wpnonce'])) {
            $nonce = $_REQUEST['_wpnonce'];
        } elseif (isset($_SERVER['HTTP_X_WP_NONCE'])) {
            $nonce = $_SERVER['HTTP_X_WP_NONCE'];
        }
        return wp_verify_nonce($nonce, 'wp_rest');

    }

    public static function get_salat_times()
    {
         if(self::IsAuthorized()) {


                //$salat_times = get_posts(array('orderby' => 'menu_order', 'order' => 'ASC', 'post_type' => 'salat_times', 'posts_per_page' => 10));
                $salat_times_data =self::get_day_by_current_date();
             //$salat_times=[];
                foreach ($salat_times_data as $salat_time){
                    $salat_times=array(
                        'Shuruq'=>date('h:i ',strtotime($salat_time->Fajr_Iqamah)),
                        'Dhuhr'=>date('h:i ',strtotime($salat_time->Dhuhr_iqamah)),
                        'Asr'=>date('h:i ',strtotime($salat_time->Asr_Iqamah)),
                        'Magrib'=>date('h:i ',strtotime($salat_time->Maghrib_Iqamah)),
                        'Eisha'=>date('h:i ',strtotime($salat_time->Isha_Iqamah)),
                    );
                }
                return rest_ensure_response($salat_times);
          }
         else{
             return rest_ensure_response('You are not authorized to call this service!');
         }
    }

    public static function get_day_by_current_date(){
        global $wpdb;
        $current_timestamp = DateTime::createFromFormat('!d/m/Y',date('d/m/Y'))->getTimestamp();
        $query="SELECT * FROM {$wpdb->prefix}salat_times where Day ='$current_timestamp'";
        return $wpdb->get_results($query);
    }

    public static function save_salat_times()
    {
        //

        if (self::IsAuthorized()) {


            $postdata = file_get_contents('php://input');
            $eventData = json_decode($postdata, true);


            foreach ($eventData as $value) {
                $iqamah = $value['post_title'];
                $salat = $value['post_content'];
                self::update_time($iqamah, $salat);
            }

            return self::get_salat_times();
        }

    }

    public static function update_time($title, $time)
    {
        $salat_time = get_page_by_title($title, OBJECT, 'salat_times');
        $salat_time->post_content = $time;
        wp_update_post($salat_time);
    }

}
new API();
