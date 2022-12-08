<?php

class SalatTimeTable
{
 public function __construct(){

 }
    public static function on_create_table(){
        self::salat_time_data_create_table();
    }
    public static function on_remove_table(){
        self::salat_time_data_remove_table();
    }

    /**************activation plugin create  table*************/
    public static function salat_time_data_create_table(){

        global $wpdb;
        $test_db_version=1.01;
        $db_table_name = $wpdb->prefix .'salat_times';  // table name

        $sql = "CREATE TABLE {$db_table_name}(
                        Id int  NOT NULL auto_increment primary key,
                        Day varchar(255) NULL,
                        Fajr varchar(255) NULL,
                        Fajr_Iqamah varchar(255) NULL,
                        Sunrise varchar(255) NULL,
                        Dhuhr varchar(255) NULL,
                        Dhuhr_iqamah varchar(255) NULL,
                        Asr varchar(255) NULL,
                        Asr_h varchar(255) NULL,
                        Asr_Iqamah varchar(255) NULL,
                        Maghrib varchar(255) NULL,
                        Maghrib_Iqamah varchar(255) NULL,
                        Isha varchar(255) NULL,
                        Isha_Iqamah varchar(255) NULL)";

        $wpdb->query($sql);
        add_option( 'salat_times_db_version', $test_db_version );

    }

    /**************unistall remove table*************/
    public static function salat_time_data_remove_table(){


        global $wpdb;
        $table_name = $wpdb->prefix . 'salat_times';
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
        delete_option("salat_times_db_version");


    }
}
new SalatTimeTable();