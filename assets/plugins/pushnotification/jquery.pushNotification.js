/**
 * @author Kuhle Hanisi
 * @version 1.0.0
 */

(function () {
    $.pushNotification = function (type, message) {
        $('body').append('<div class="request-' + type + '">' + message + ' <span class="close-push-notification"><i class="fa fa-times"></i></span></div>');
        function countDown() {
            $('.close-push-notification').parent().addClass('dismiss-push-notification');
            setTimeout("$('.close-push-notification').parent().removeClass('request-" + type + "').remove();", 500);
        }
        setTimeout(countDown, 5000);
        $('.close-push-notification').click(function () {
            $(this).parent().addClass('dismiss-push-notification');
            setTimeout("$('.close-push-notification').parent().removeClass('request-" + type + "').remove();", 500);
        });
    };
})(jQuery);