(function ($, root, undefined) {

    function append_button() {
        $('.subsubsub').before(
            "<div class='notification_container'>" +
            "<a class='button button-primary button-hero button-notification' href='#' id='order_notification'><strong>Stop and show order!</strong></a>" +
            "<a class='button button-primary button-hero button-notification' href='#' id='stop_notification'><strong>Stop</strong></a>" +
            "</div>");

    }


    jQuery(document).ready(function ($) {

        var playing = false;

        var cur_ord = window.localStorage.getItem('last_order');

        var first_order = $('#the-list tr').first().attr('id').replace('post-', '');

        if (first_order != undefined && cur_ord != null && first_order > cur_ord) {
            var diff = (first_order - cur_ord);
            $('embed').remove();
            $('body').append('<audio id="notification" src="' + notification.sound + '" preload="auto" loop="true"></audio>');
            playing = true;
            var sound = document.getElementById('notification');
            sound.play();
            window.localStorage.setItem('last_order', first_order);
            append_button();

            for (var i = 0; i < diff; i++) {
                $('#the-list tr[id="post-' + (cur_ord + 1 - i) + '"]').css('background-color', 'orange');
            }
        }

        if (cur_ord == null) {
            window.localStorage.setItem('last_order', first_order);
        }

        if (!playing) {
            setTimeout(function () {
                window.location.reload();
            }, 30000);
        }

        $('.wrap').on('click', '#order_notification', function () {
            if (sound != undefined) {
                sound.pause();
            }

            if (diff != undefined && diff > 0) {

                var last_order = window.localStorage.getItem('last_order');

                for (var i = 0; i < diff; i++) {
                    var order_url = $('#the-list tr[id="post-' + (last_order - i) + '"] td[class^="order_title"]').find('a').first().attr('href');
                    window.open(order_url);
                }
            }

            $('.notification_container').fadeOut('slow', function () {
                window.location.reload();
            });

        });

        $('.wrap').on('click', '#stop_notification', function () {
            if (sound != undefined) {
                sound.pause();
            }

            $('.notification_container').fadeOut('slow', function () {
                window.location.reload();
            });

        });

    });
})
(jQuery, this);
