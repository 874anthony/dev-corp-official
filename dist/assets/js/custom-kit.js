jQuery(document).ready(function() {
    /*
        Subscription form
    */
    $('.success-message').hide();
    $('.error-message').hide();

    $('.contact form').submit(function(e) {
        e.preventDefault();
        var postdata = $('.contact form').serialize();
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
});