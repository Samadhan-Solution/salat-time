<?php
/**
 * Plugin Name: Salat Time Wall
 * Description: A plug to create a Satal Timetable for Wall TV
 * Version : 2.0.2
 * Author: Fazlur Khan
 * Author URI: https://samadhan.com.au
 *
 * Salat Time Wall is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Salat Time Wall is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

use SalatTimes\TimeKeeper;

include_once('includes/salat-time-post.php');
include_once('includes/functions.php');
include_once('includes/api-endpoints.php');
include_once('includes/view.php');
include_once('includes/view-full-screen.php');
include_once('admin/SalatTimeTable.php');
include_once('import-csv/model/ImportCsvModel.php');
include_once('import-csv/view/ImportCsvView.php');

register_activation_hook( __FILE__, 'SalatTimeTable::on_create_table');
register_deactivation_hook(__FILE__, 'SalatTimeTable::on_remove_table');
//register_uninstall_hook(__FILE__, 'SalatTimeTable::on_remove_table');
function func_load_vue_scripts_axios_rest_call() {
    wp_register_script( 'wp_vue_js_rest_call', plugins_url('client/vendor/vue.js',__FILE__ ));
    wp_register_script( 'wp_axios_rest_call', plugins_url('client/vendor/axios.min.js',__FILE__ ));

    wp_register_script('samadhan_salat_app', plugin_dir_url( __FILE__ ).'client/js/main.js', ['jquery','wp_vue_js_rest_call','wp_axios_rest_call'], true );
    wp_register_style('samadhan_salat_css', plugins_url('client/css/main.css',__FILE__ ));
}



function func_wp_vue_axios_rest_call(){

    wp_enqueue_script('wp_vue_js_rest_call');
    wp_enqueue_script('wp_axios_rest_call');
    wp_enqueue_style('samadhan_salat_css');

    wp_localize_script('samadhan_salat_app','settingObject',array(
        'root'=>esc_url_raw(rest_url()),
        'nonce'=>wp_create_nonce('wp_rest')
    ));
    wp_enqueue_script('samadhan_salat_app');
}

function func_salat_time(){
    func_wp_vue_axios_rest_call();
    return  salat_time_view();
    }

function func_salat_time_full(){
    func_wp_vue_axios_rest_call();
    return  salat_time_view_full_screen();
}


function salat_time_wall_activate(){
    TimeKeeper::create_initial_salat_times();
}

register_activation_hook( __FILE__, 'salat_time_wall_activate' );
add_action('wp_enqueue_scripts', 'func_load_vue_scripts_axios_rest_call');
add_shortcode('salat_time', 'func_salat_time');
add_shortcode('salat_time_full_screen', 'func_salat_time_full');

