/*function onRecaptchaSuccess() {
    document.querySelector('#get-quote_submit_button').disabled = false;
}

function dataerrorcallback() {
    alert("this robot thinks you a robot! You cannot subnit this form");
}*/
jQuery(document).ready(function ($) {

    $('#quote_submit_form').submit(function (event) {
        var email = $('#email').val();
        // Prevent the default form submission
        var email = $('#email').val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var email_validation = regex.test(email);
        if (!email_validation) {
            alert("Please enter a valid email address");
            return false;
        }
        event.preventDefault();
        var data = {
            'action': 'getquote_form_submit_action', // the action hook name
            'first_name': $('#first_name').val(),
            'last_name': $('#last_name').val(),
            'company': $('#company').val(),
            'country': $('#country').val(),
            'phone': $('#phone').val(),
            'email': $('#email').val(),
            'nameofproduct': $('#nameofproduct').val(),
            'comments': $('#comments').val()

        };

        $.post(my_ajax_object.ajax_url, data, function (response) {
            response = JSON.parse(response);
            if (response.success) {
                $('#overlay_dialog-message').show();
                $('#dialog-message').show();
            } else {
                alert("something went wrong while submitting the form");
            }
        });
    });

    $('#dialog-message button').click(function (e) {
        window.location.href = 'http://' + window.location.hostname + '/index.php';
    });
});


