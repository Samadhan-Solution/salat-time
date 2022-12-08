<?php


class ImportCsvModel
{
    public function __construct(){

    }
    public static function smdn_save_csv_import_file_data(){

        if(isset($_POST['importSubmit']) && !empty($_POST['importSubmit'])){

            //truncate Table
            $get_truncate_data= self::smdn_truncate_salat_times_table_data();

            if($get_truncate_data){
                $csvMimes = array('text/x-comma-separated-values','text/comma-separated-values','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/octet-stream','application/vnd.ms-excel','application/x-csv','text/x-csv','text/csv','text/xlsx','application/csv','application/excel','application/vnd.msexcel','text/plain');

                if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){

                    if(is_uploaded_file($_FILES['file']['tmp_name'])){

                        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

                        $get_csv_header=fgetcsv($csvFile);
                        $totalCount=0;

                        while(($data = fgetcsv($csvFile)) !== FALSE){
                            $totalCount++;
                                self::smdn_insert_import_salat_time_data($data);

                        }
                        fclose($csvFile);
                        $mgs = '<h5 style="color:#0cc50c">Data Imported  Successfully.</h5>';
                        $mgs .= '<h5 style="color:#0cc50c">Total CSV Records Imported='.$totalCount.'.</h5>';

                    }

                }else{
                    $mgs = '<h5 style="color:#000">Please! Choose an upload file.</h5>';
                }
            }else{
                $mgs = '<h5 style="color:red">  Table data could not be removed!</h5>';
            }
        }

        return $mgs;
    }
    public static function  smdn_insert_import_salat_time_data($data){


        global $wpdb;
        $Imported_au_shipping_zone_table = $wpdb->prefix.'salat_times';
        $timestamp = DateTime::createFromFormat('!d/m/Y', $data[0])->getTimestamp();
        $zone_data= array(
            'Day' => $timestamp,
            'Fajr' => $data[1],
            'Fajr_Iqamah' => $data[2],
            'Sunrise' => $data[3],
            'Dhuhr' => $data[4],
            'Dhuhr_iqamah' => $data[5],
            'Asr' => $data[6],
            'Asr_h' => $data[7],
            'Asr_Iqamah' => $data[8],
            'Maghrib' => $data[9],
            'Maghrib_Iqamah' => $data[10],
            'Isha' => $data[11],
            'Isha_Iqamah' => $data[12],
        );


        return  $wpdb->insert( $Imported_au_shipping_zone_table,$zone_data );

    }
    public static function smdn_truncate_salat_times_table_data(){
        global $wpdb;
        $importedTransactionTable = $wpdb->prefix.'salat_times';
        return $wpdb->query("TRUNCATE TABLE $importedTransactionTable");

    }


}
new ImportCsvModel();