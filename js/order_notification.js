(function ($, root, undefined) {

    function append_button() {
        $('.subsubsub').before(
            "<div class='notification_container'>" +
            "<a class='button button-primary button-hero button-notification' href='#' id='stop_notification'><strong>Stop</strong></a>" +
            "</div>");
    }

    function check_interval() {
        setTimeout(function () {
            window.location.reload();
        }, 30000);
    }


    jQuery(document).ready(function ($) {

        var playing = false;

        // get orders from last time
        var last_orders_string = window.localStorage.getItem('last_orders');

        // get orders in screen just loaded
        var new_orders_scan = [];

        $('#the-list > tr').each(function() {
            new_orders_scan.push($( this ).attr('id').replace('post-', ''));
            }
        );

        // if there are orders and there were orders last time
        if (new_orders_scan.length > 0 && last_orders_string != null) {

            //string storage to array
            var last_orders = JSON.parse(last_orders_string);

            // get highest order number from last time
            var last_order = Math.max(...last_orders);

            // get the difference between last and new
            var difference = new_orders_scan.filter(x => !last_orders.includes(x));

            // get orders higher than last time
            var new_orders = new_orders_scan.filter(function (x) { return x > last_order});

        } else {
            // set all orders in memory
            window.localStorage.setItem('last_orders', JSON.stringify(new_orders_scan));
        }

        check_interval();


        // if there are new orders compared to last time
        if (difference.length > 0) {

            // play sound if set
            if (notification.sound != undefined) {
                $('body').append('<audio id="notification" src="' + notification.sound + '" preload="auto" loop="true"></audio>');
                playing = true;
                var sound = document.getElementById('notification');
                sound.play();
            }

            // display button
            append_button();

            // highlight new rows
            for (var i = 0; i < difference.length; i++) {
                $('#the-list tr[id="post-' + difference[i] + '"]').css('background-color', 'orange');
            }
        }


        // on click stop
        $('.wrap').on('click', '#stop_notification', function () {
            if (sound != undefined) {
                sound.pause();
            }

            // downtone rows
            for (var i = 0; i < difference.length; i++) {
                $('#the-list tr[id="post-' + difference[i] + '"]').css('background-color', '#FFD732');
            }

            window.localStorage.setItem('last_orders', JSON.stringify(new_orders_scan));

            $('.notification_container').fadeOut('slow', function () {
                window.location.reload();
            });

        });

    });
})
(jQuery, this);
