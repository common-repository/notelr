jQuery(document).ready(function () {
    $ = jQuery;
    $("#notelr-send-email-form").submit(function (e) {
        e.preventDefault();
        var email = $("#notelr-send-email").val();
        if (!email) {
            return false;
        }
        var data = {
            action: "notelr_send_email",
            email: email
        }
        $.getJSON(ajaxurl, data, function (response) {
            if (response.status == "ok") {
                $("#notelr-send-email-form").hide();
                $("#notelr-create-user-form").show();
                $("#notelr-email").text(email);
                $("#notelr-email-options").show();
            }else{
                $(".notelr-error-message").remove();
                $("#notelr-send-email-form").append("<span class='notelr-error-message'>"+response['message']+"</span>");
            }
        });
    });
    $("#notelr-create-user-form").submit(function(e){
        e.preventDefault();
        var name = $("#notelr-register-name").val();
        var key = $("#notelr-register-key").val();
        var username = $("#notelr-register-username").val();
        var password = $("#notelr-register-password").val();
        var data = {
            action: "notelr_register",
            key: key,
            password: password,
            name: name,
            username:username
        }
        $.post(ajaxurl, data, function (response) {
            if (response.status == "ok") {
                window.location.reload();
            }else{
                $(".notelr-error-message").remove();
                $("#notelr-create-user-form").append("<span class='notelr-error-message'>"+response['message']+"</span>");
            }
        }, 'json');
    });
    $("#notelr-login-form").submit(function (e) {
        e.preventDefault();
        var email = $("#notelr-login-email").val();
        if (!email) {
            var message = "Email can't be empty";
            $(".notelr-error-message").remove();
            $("#notelr-login-form").append("<span class='notelr-error-message'>"+message+"</span>");
            return false;
        }
        var password = $("#notelr-login-password").val();
        if (!password) {
            var message = "Password can't be empty";
            $(".notelr-error-message").remove();
            $("#notelr-login-form").append("<span class='notelr-error-message'>"+message+"</span>");
            return false;
        }
        var data = {
            action: "notelr_login",
            email: email,
            password: password
        }
        $.post(ajaxurl, data, function (response) {
            if (response.status == "ok") {
                window.location = "admin.php?page=notelr";
            }else{
                $(".notelr-error-message").remove();
                $("#notelr-login-form").append("<span class='notelr-error-message'>"+response['message']+"</span>");
            }
        }, 'json');
    });
    $(".notelr-paypal-form").submit(function(e){
        e.preventDefault();
        var email = $(".notelr-paypal-email").val();
        var data = {
            action: "notelr_set_paypal",
            email: email
        }
        $.post(ajaxurl, data, function (response) {
            if (response.status == "ok") {
               alert("PayPal email successfully updated!");
            }
        }, 'json');
    });
    $("#notelr-resend-email").click(function(e){
        e.preventDefault();
        var data = {
            action: "notelr_resend_email"
        }
        $.post(ajaxurl, data, function (response) {
            if (response.status == "ok") {
                alert("Email resent!");
            }
        }, 'json');
    });
    $("#notelr-change-email").click(function(e){
        e.preventDefault();
        var data = {
            action: "notelr_change_email"
        }
        $.post(ajaxurl, data, function (response) {
            if (response.status == "ok") {
                $("#notelr-send-email").val("");
                $("#notelr-create-user-form").hide();
                $("#notelr-send-email-form").show();
            }
        }, 'json');
    });
});