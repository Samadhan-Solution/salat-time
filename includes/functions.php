<?php
register_activation_hook( __FILE__,'samadhan_prepare_salat_time_table');
function samadhan_prepare_salat_time_table(){
    samadhan_create_salat_time_table();
    samadhan_populate_salat_time_table();
}
function samadhan_create_salat_time_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . "salat_time_table";

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name(
                                  id mediumint(9) NOT NULL AUTO_INCREMENT,
                                  Salat varchar(10) NOT NULL,
                                  Iqamah   varchar(15)  NOT NULL,                                  
                                  PRIMARY KEY  (id)
                                ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);


}

function samadhan_populate_salat_time_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . "salat_time_table";
    $wpdb->query("TRUNCATE " . $table_name);
    $wpdb->query(  "INSERT INTO " . $table_name . " ( Salat, Iqamah ) VALUES ('Fajr','5:40 am' ) ");
    $wpdb->query(  "INSERT INTO " . $table_name . " ( Salat, Iqamah ) VALUES ('Shuruq','6:40 am' ) ");
    $wpdb->query(  "INSERT INTO " . $table_name . " ( Salat, Iqamah ) VALUES ('Dhuhr','1:15 pm' ) ");
    $wpdb->query(  "INSERT INTO " . $table_name . " ( Salat, Iqamah ) VALUES ('Asr','5:40 pm' ) ");
    $wpdb->query(  "INSERT INTO " . $table_name . " ( Salat, Iqamah ) VALUES ('Magrib','7:20 pm' ) ");
    $wpdb->query(  "INSERT INTO " . $table_name . " ( Salat, Iqamah ) VALUES ('Eisha','9:00 pm' ) ");
    $wpdb->query(  "INSERT INTO " . $table_name . " ( Salat, Iqamah ) VALUES ('Jumuah-1','1:00 pm' ) ");
    $wpdb->query(  "INSERT INTO " . $table_name . " ( Salat, Iqamah ) VALUES ('Jumuah-2','2:00 pm' ) ");

}