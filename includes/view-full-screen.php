<?php
function salat_time_view_full_screen(){
    ob_start();
    ?>

    <div id="app" class="samadhan-salat-time-full-screen">
        <table>
            <thead>
            <tr>
                <th class="smdn-custom-th label">Salat</th>
                <th class="smdn-custom-th data" >Iqamah</th>
            </tr>
            </thead>
            <tbody>

            <tr v-if="info!==null" v-for="data in info.data">
                <td class="smdn-custom-td label"><span class="smdn-custom-label-full-screen">{{data.post_title}}</span></td>
                <td class="smdn-custom-td data"><input v-model="data.post_content" @change="saveChanges" class="smdn-custom-input-full-screen" size="8" ></td>
            </tr>
            </tbody>
        </table>
    </div>

    <?php
   return ob_get_clean();

}


