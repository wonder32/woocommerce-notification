(function ($, root, undefined) {

    // refresh page every 30 seconds
    function check_interval() {
        setTimeout(function () {
            window.location.reload();
        }, 30000);
    }

    // count down 10 - 0 seconds
    function count_down(){
        let counter = 30;

        setInterval(function() {
            counter--;

            if (counter >= 0) {
                $('#notification_counter').html(counter + ' seconds to reload');
            }
            // Display 'counter' wherever you want to display it.
            if (counter === 0) {
                //    alert('this is where it happens');
                clearInterval(counter);
            }

        }, 1000);

    }

    window.onload = function() {
        var context = new AudioContext();
    }

    jQuery(document).ready(function ($) {

        let playing = false;

        //reload in 30sec
        check_interval();
        //count down 30 seconds
        count_down();

        // get orders from last time
        let last_orders = JSON.parse(window.localStorage.getItem('last_orders'));

        // get orders in screen just loaded
        let new_orders_scan = [];

        $('#the-list > tr').each(function() {
            new_orders_scan.push($( this ).attr('id').replace('post-', ''));
            }
        );

        // if there are orders and there were orders last time
        if (new_orders_scan.length > 0 && last_orders != null) {

            // get highest order number from last time
            var last_order = Math.max(...last_orders);

            // get the difference between last and new
            var difference = new_orders_scan.filter(x => !last_orders.includes(x));

            // get orders higher than last time
            var new_orders = new_orders_scan.filter(function (x) { return x > last_order});

        } else if (last_orders == null) {
            window.localStorage.setItem('last_orders', JSON.stringify(new_orders_scan));
        }




        let sound = document.createElement("audio");
        // if there are new orders compared to last time
        if (difference != undefined && difference.length > 0) {


            if (notification.sound.sound != undefined) {

                sound.src = notification.sound.sound;
                sound.volume = 1;
                sound.autoPlay = false;
                sound.loop = true;
                sound.preLoad = true;
                sound.controls = false;
                sound.play();
            }

            if (notification.visual.visual != undefined) {
                // display button
                $('#notification_container').fadeIn('slow', function () {
                    // highlight new rows
                    for (let i = 0; i < difference.length; i++) {
                        $('#the-list tr[id="post-' + difference[i] + '"]').css('background-color', notification.visual.visual);
                    }
                });
            }

        }

        // on click stop
        $('#notification_container').on('click', '#stop_notification', function () {

            sound.pause();

            // downtone rows
            for (var i = 0; i < difference.length; i++) {
                $('#the-list tr[id="post-' + difference[i] + '"]').css('background-color', '#FFD732');
            }

            window.localStorage.setItem('last_orders', JSON.stringify(new_orders_scan));

            // $('.notification_container').fadeOut('slow', function () {
            //     window.location.reload();
            // });

        });

        $('#notification_container').on('click', '#mute_notification', function () {
            sound.pause();
        });

    });
})
(jQuery, this);
