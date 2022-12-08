
var app=new Vue({

    el: '#app',
    data () {
        return {
            info: [],
            loading: true,
            errored: false,
            time: '',
            date: '',
            AmOrPm: '',
            hours: '',
            minites: '',
            seconds: ''
        }
    },
    methods: {
        currentDate() {
            const current = new Date();
            const date = `${current.getDate()}/${current.getMonth()+1}/${current.getFullYear()}`;      return date;
        },
        loadData()
        {
            var $apiEndpoint =  settingObject.root + 'salat/v1/time?_wpnonce=' + settingObject.nonce;
            axios.get($apiEndpoint)
                .then((response) =>
                {this.info = response;
                    console.log(response);})
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.loading = false)
        },
        saveChanges()
        {
            this.onSubmit();
        },
        onSubmit () {
           //alert(settingObject.root );
           console.log(settingObject.nonce);

            var $apiEndpoint =  settingObject.root + 'salat/v1/time?_wpnonce=' + settingObject.nonce;
            $jsonData=JSON.stringify(this.info.data);
            console.log($jsonData);
////////////////////////////////post data////////////////////
////////////////////////////////post data////////////////////

            var jqxhr = jQuery.post( $apiEndpoint,$jsonData)
                .done(function(response) {
                    //window.app.controls.response.show = true;
                    if(response.status == 'success' || response.status == 'error') {
                       this.loadData();
                    }
                    else {
                        // window.app.controls.response.status = 'error';
                        // window.app.controls.response.message = 'Please close the browser and try again or call us on 1800 200 500';
                    }
                })
                .fail(function(response) {
                    // window.app.controls.response.show = true;
                    // window.app.controls.response.status = 'error';
                    // window.app.controls.response.message = 'Please close the browser and try again or call us on 1800 200 500';
                    //alert( response );
                })
                .always(function(response) {
                    // window.app.controls.isSubmitting = false;
                    //console.log( "done" );
                });
        }

     },
    mounted () {
       this.loadData();
        setTimeout(this.loadData, 5*60*1000);
    }
})


var week = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
var timerID = setInterval(updateTime, 1000);
updateTime();
function updateTime() {
    var cd = new Date();
    var hours = cd.getHours() ; // gives the value in 24 hours format
    var AmOrPm = hours >= 12 ? 'pm' : 'am';
    hours = (hours % 12) || 12; //12 hours format

    app.time = hours + ':' + zeroPadding(cd.getMinutes(), 2) + ':' + zeroPadding(cd.getSeconds(), 2);
    app.date = zeroPadding(cd.getDate(), 2)+ '-' + zeroPadding(cd.getMonth()+1, 2) + '-'+ zeroPadding(cd.getFullYear(), 4)+ ' ' + week[cd.getDay()];
    app.AmOrPm=AmOrPm;
    app.hours = hours;
    app.minites =  zeroPadding(cd.getMinutes(), 2);
    app.seconds =  zeroPadding(cd.getSeconds(), 2);


};

function zeroPadding(num, digit) {
    var zero = '';
    for(var i = 0; i < digit; i++) {
        zero += '0';
    }
    return (zero + num).slice(-digit);
}
