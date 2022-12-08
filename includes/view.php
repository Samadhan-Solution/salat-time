<?php
function salat_time_view(){
    ob_start();
    ?>

    <div id="app" class="samadhan-salat-time">
        <table>
            <thead>
            <tr>
                <th class="smdn-custom-th">Salat</th>
                <th class="smdn-custom-th">Iqamah</th>
            </tr>
            </thead>
            <tbody>

            <tr v-if="info!==null" v-for="(data,index) in info.data">
                <td class="smdn-custom-label">{{index}}</td>
                <td class="smdn-custom-input">{{data,index}}</td>

            </tr>

            </tbody>
        </table>
        <div id="clock"  style="font-size: 36px !important; border-top: 2px solid #000 !important;">

            <p class="date">Date: {{ date }}</p>
<!--            <div class="time" style="display: inline-flex;" ><div style="width: 60px;">{{hours}} :</div> <div style="width: 80px;">{{minites}} :</div> <div style="width: 60px;"> {{ seconds }} </div> <div style="width: 60px;"> {{amOrPm}} </div></div>-->
        </div>
    </div>


    <?php
   return ob_get_clean();

}


