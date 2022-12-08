<?php

class ImportCsvView
{
    public function __construct()
    {
        add_shortcode('smdn_import_csv', array($this, 'get_import_csv_file_uploaded_form'));
        add_shortcode('smdn_auto_process_imported_csv', array($this, 'get_import_csv_auto_process_imported_form'));

    }

    public function get_import_csv_file_uploaded_form()
    {
        $current_timestamp = DateTime::createFromFormat('!d/m/Y',date('d/m/Y'))->getTimestamp();

        //var_dump(date('d/m/Y'));
        var_dump($current_timestamp);


//var_dump(date('Y-m-d'));
       if(is_user_logged_in() &&  current_user_can('administrator')){

        $message = ImportCsvModel::smdn_save_csv_import_file_data();

        $importCsv = '<div class="col-md-12" id="importFrm" style="float:right;padding:100px;">
                   <div>' . $message . '</div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" />
                        <input type="submit" class="btn btn-primary" name="importSubmit" value="Import CSV Data">
                    </form>
                 </div>';

          return $importCsv;
       }else{
           return '<div class="col-md-12" id="importFrm" style="text-align:center;padding:100px;"><h2>You can not access this page</h2></div>';
       }
    }



}

new ImportCsvView;