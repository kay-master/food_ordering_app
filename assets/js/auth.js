$(function () {
    $("#login-form").validate({
        rules:
        {
            password: {
                required: true
            },
            email: {
                required: true,
                email: true
            }
        },
        messages:
        {
            password: {
                required: "Please enter your password"
            },
            email: "Please enter your email address"
        },
        submitHandler: loginForm
    });

    $("#signup-form").validate({
        rules:
        {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            password: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            c_password: {
                required: true,
                equalTo: 'input[name="password"]'
            }
        },
        messages:
        {
            password: {
                required: "Please enter password"
            },
            c_password: {
                equalTo: 'Please enter the same password again'
            },
            email: "Please enter email address",
            first_name: "Please enter your first name",
            last_name: "Please enter your last name"
        },
        submitHandler: signupForm
    });

    var hostroot = function (url) {
        var location = window.location,
            host = location.host, origin;
        if (url == undefined) return location.origin;

        if (host == 'localhost') {
            origin = location.origin + '/foodie/' + url;
        } else {
            origin = location.origin + '/' + url;
        }
        return origin;
    }, tiURL = function (link, origin) {

        if (link == 'reload') {
            setTimeout(function () {
                window.location.reload();
            }, 1500);
            return false;
        }
        var redirect_link = '';
        if (origin == undefined) {
            var location = window.location,
                host = location.host;

            if (host == 'localhost') {
                redirect_link = location.origin + '/foodie/' + link;
            } else {
                redirect_link = location.origin + '/' + link;
            }
        } else {
            redirect_link = link;
        }
        setTimeout(' window.location.replace("' + redirect_link + '"); ', 2000);
    };


    function loginForm() {
        var btn = $("#btn-login");
        var data = $("#login-form").serialize();
        $.ajax({
            type: 'POST',
            url: hostroot($("#login-form").attr('action')),
            dataType: 'JSON',
            error: function (jqXHR, textStatus, errorThrown) {
                tiURL("reload");
            },
            data: data,
            beforeSend: function () {
                btn.attr('disabled', true)
            },
            success: function (response) {
                if (response.success) {
                    switch ($("#login-form").attr('data-type')) {
                        case 'user':
                            tiURL("order");
                            break;
                        case 'admin':
                            tiURL("admin/orders");
                            break;
                        default:
                            tiURL('')
                            break;
                    }
                } else {
                    tiURL("reload");
                }
            }

        });
    }

    function signupForm() {
        $('input[name="c_password"]').parent().find('label.error').remove();

        var data = $("#signup-form").serialize(),
            btn = $("#signup-btn")
        $.ajax({
            type: 'POST',
            url: hostroot($("#signup-form").attr('action')),
            data: data,
            dataType: 'json',
            error: function (jqXHR, textStatus, errorThrown) {
                btn.attr('disabled', false).html('Sign Up');
                tiURL("reload");
            },
            beforeSend: function () {
                btn.attr('disabled', true).html('Submitting...');
            },
            success: function (response) {
                if (response.success) {
                    $.pushNotification('success', 'Welcome to Foodie, successfully signed up :)')
                    switch ($("#signup-form").attr('data-type')) {
                        case 'user':
                            tiURL("login");
                            break;
                        case 'admin':
                            tiURL("admin/login");
                            break;
                        default:
                            tiURL('')
                            break;
                    }
                } else {
                    tiURL("reload");
                }
            }
        });
    }

})