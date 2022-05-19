$(document).ready(function() {
    //Have all agent install TurboTop

    setTimeout(function(){window.focus()},100);
    //Load Dropdown First
    var drpdown = $('.trans-tp');

    loaddrpdown();

    function loaddrpdown(){
        $.ajax({
            type: "GET",
            url: "trans-type",
            success: function (response) {
                console.log(response);
                drpdown.empty();
                drpdown.append('<option value="0">Please Select Transaction Type</option>');
                $.each(response.data, function(k, v) {
                    drpdown.append(
                        "<option value='"+v['id']+"'>"+v['transaction_name']+"</option>"
                    );
                });
            }
        });
    
    }

    

    var timertat = '',
        startetime = '',
        endetime   = '';
    var sw = {
        // (A) INITIALIZE
        etime : null, // HTML time display
        erst : null, // HTML reset button
        ego : null, // HTML start/stop button
        ecom: null,
        etimestart: null,
        etimeend: null,
        init : function () {
            // (A1) GET HTML ELEMENTS
            sw.etime = document.getElementById("sw-time");
            sw.erst = document.getElementById("sw-rst");
            sw.ego = document.getElementById("sw-go");
            sw.ecom = document.getElementById("commentSection");

            // (A2) ENABLE BUTTON CONTROLS
            sw.erst.addEventListener("click", sw.reset);
            sw.erst.disabled = false;
            sw.ego.addEventListener("click", sw.start);
            sw.ego.disabled = false;
        },

        // (B) TIMER ACTION
        timer : null, // timer object
        now : 0, // current elapsed time
        tick : function () {
            // (B1) CALCULATE HOURS, MINS, SECONDS
            sw.now++;
            var remain = sw.now;
            var hours = Math.floor(remain / 3600);
            remain -= hours * 3600;
            var mins = Math.floor(remain / 60);
            remain -= mins * 60;
            var secs = remain;

            // (B2) UPDATE THE DISPLAY TIMER
            if (hours<10) { hours = "0" + hours; }
            if (mins<10) { mins = "0" + mins; }
            if (secs<10) { secs = "0" + secs; }
            sw.etime.innerHTML = hours + ":" + mins + ":" + secs;
        },
    
        // (C) START!
        start : function () {
            sw.timer = setInterval(sw.tick, 1000);
            sw.ego.value = "Stop";
            sw.ego.removeEventListener("click", sw.start);
            sw.ego.addEventListener("click", sw.stop);

            var today = new Date();
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            startetime = date+' '+time;
        },

        // (D) STOP
        stop  : function () {
            if (sw.ecom.value != "") {
                if ($('.trans-tp').val() != 0){

                    var today = new Date();
                    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    endetime = date+' '+time;

                    //Store all Variables Here first
                    console.log(sw.etime.innerHTML);
                    console.log($('.trans-tp').val());
                    console.log(sw.ecom.value);
                    console.log(startetime);
                    console.log(endetime);

                    const difference = moment(endetime, "YYYY/MM/dd HH:mm:ss").diff(moment(startetime, "YYYY/MM/dd HH:mm:ss"))
                    const diff = moment.utc(difference).format("HH:mm:ss");

                    $.ajax({
                        type: "POST",
                        url: "trnx-save",
                        data: {
                            "trans_type"     : $('.trans-tp').val(),
                            "trans_tat"      : diff,//sw.etime.innerHTML,
                            "trans_rem"      : sw.ecom.value,
                            "trans_str"      : startetime,
                            "trans_end"      : endetime,
                            _token: $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json",
                        success: function (response) {
                            drpdown.empty();
                            loaddrpdown();
                            document.getElementById("commentSection").value = "";
                            console.log(response);
                            location.reload(true);

                            clearInterval(sw.timer);
                            sw.timer = null;
                            sw.ego.value = "Start";
                            sw.ego.removeEventListener("click", sw.stop);
                            sw.ego.addEventListener("click", sw.start);

                            if (sw.timer != null) { sw.stop(); }
                            sw.now = -1;
                            sw.tick();
                        }
                    });

                    
                }
            }else{
                alert("Comment and/or Transaction Type is Missing!");
            }
        },

        // (E) RESET
        reset : function () {
            if (sw.timer != null) { sw.stop(); }
            sw.now = -1;
            sw.tick();
        }
    };

    // window.addEventListener("click", sw.init);
    //$(window).load(sw.init);
    // window.addEventListener("load", sw.init);

    


    ["mouseover"].forEach(
        function (params) {
            window.addEventListener(params, sw.init, false);
        }
    );
    // window.addEventListener("load", sw.init);
    console.log(timertat);

    
});