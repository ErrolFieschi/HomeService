$('form').submit(function () {

    // Get the Login Name value and trim it
    var email = $.trim($('.email').val());
    var password = $.trim($('.password').val());

    // Check if empty of not
    if (email  === '' && password === '') {
        $('input').addClass('error');
        return false;
    }
});
