jQuery(document).ready(function() {

    /*
        Subscription form
    */
    $('.success-message').hide();
    $('.error-message').hide();

    $('.contact form').submit(function(e) {
        e.preventDefault();

        // Adding the dates
        var shippingDate = Date.now();
        var expirationDate = shippingDate + (3 * 60 * 60 * 1000);

        var postdata = $('.contact form').serialize() + `&date=${shippingDate}&expirationDate=${expirationDate}`;

        /**
         * Saving the info email to the storage
         */
        localStorage.setItem('messageInfo', postdata);

        $.ajax({
            type: 'POST',
            url: 'assets/contact.php',
            data: postdata,
            dataType: 'json',
            success: function(json) {
                if (json.valid == 0) {
                    $('.success-message').hide();
                    $('.error-message').hide();
                    $('.error-message').html(json.message);
                    $('.error-message').fadeIn();
                } else {
                    $('.error-message').hide();
                    $('.success-message').hide();
                    $('.contact form').hide();
                    $('.success-message').html(json.message);
                    $('.success-message').fadeIn();
                }
            }
        });
    });

    /**
     * Disable the button if there's already an email
     */

    if (localStorage.getItem('messageInfo')) {
        $('#sendMessageCustom').prop('disabled', true);

        var data = localStorage.getItem('messageInfo');

        var shippingDate = data.split('&')[3].split('=')[1];
        var expirationDate = data.split('&')[4].split('=')[1];

        if (Date.now() >= expirationDate) {
            localStorage.removeItem('messageInfo');
            $('#sendMessageCustom').prop('disabled', false);
        }

    } else {
        $('#sendMessageCustom').prop('disabled', false);
    }

    /**
     * Disabling the button if the info required is not provided     
     */

    $('#sendMessageCustom').prop('disabled', true);
    $('input[type="text"]').keyup(function() {
        if ($(this).val() != '') { // The this keyword points to the input tag.
            $('#sendMessageCustom').prop('disabled', false);
        } else {
            $('#sendMessageCustom').prop('disabled', true);
        }
    });

});