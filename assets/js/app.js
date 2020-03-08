$(function () {


    $("#create-menu-form").validate({
        rules:
        {
            menu_name: {
                required: true
            },
            day_of_menu: {
                required: true
            },
            menu_type: {
                required: true
            },
            price: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages:
        {
            price: {
                required: "Please price of menu"
            },
            description: {
                required: 'Please write a short description of menu'
            },
            menu_type: "Specify if it's a normal or alternative menu",
            day_of_menu: "Please specify when will the menu be ordered",
            menu_name: "Please specify name of menu"
        },
        submitHandler: createMenuForm
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

    function createMenuForm() {
        var btn = $("#create-menu-btn"),
            form = $("#create-menu-form");
        var data = form.serialize();
        $.ajax({
            type: 'POST',
            url: hostroot(form.attr('action')),
            dataType: 'JSON',
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus)
                btn.attr('disabled', false)
            },
            data: data,
            beforeSend: function () {
                btn.attr('disabled', true)
            },
            success: function (response) {
                if (response.success) {
                    form[0].reset();
                    tiURL('admin/view_menu')
                }
                form.find('input[name="csrf_token"]').val(response.token)
                btn.attr('disabled', false)
            }

        });
    }

    function watchAddedUser(data) {
        var user_elem = $('#user-list'),
            user_list = user_elem.find('li:not(.no-user)')
        if (user_list.length == 0) {
            user_elem.find('.no-user').remove()
        }

        var printOut = function (id) {
            if (!data.on_order) {
                return `<input type="hidden" value="` + id + `" name="users[]">`
            }
            return ``;
        },
        on_order =  (data.on_order)  ? 'Not addable': 'Addable',
        orderClass = on_order.replace(' ','_').toLowerCase();

        user_elem.append(`  <li>
                                <div>
                                    <div class="name">`+ data.name + `</div>
                                    <div style="margin: 0 7px;">-</div>
                                    <span data-type="` + on_order + `" class="type ` + orderClass + `">` + on_order + `</span>
                                    <div class="remove" title="Remove `+ data.name + `"><i class="fa fa-trash"></i></div>
                                    `+ printOut(data.id) + `
                                </div>
                            </li>
                            `)

        user_elem.find('li').each(function (e, i) {
            if ($(this).find('span.type').attr('data-type').toLowerCase() == 'addable') {
                $('#add-user-btn').attr('disabled', false)
            }
        })

    }

    if ($('body').find('#find_user').length) {
        $('#find_user').select2({
            placeholder: 'Searching users',
            // dropdownParent: $('#__MdL-modal'),
            ajax: {
                url: hostroot('api/find_users'),
                dataType: 'JSON',
                data: function (params) {
                    var query = {
                        search: params.term,
                        menu_type: $('#menu_type').attr('data-type'),
                        menu_id: $('input[name="menu_id"]', '#add-user-form').val(),
                        type: 'private'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data) {
                    // Tranforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data.users
                    };
                }
            }
        });

        $('#find_user').on('select2:select', function (e) {
            watchAddedUser(e.params.data)
            $('#find_user').val(null).trigger('change')
        });

        $('#user-list').on('click', '.remove', function () {
            var empty = '<li class="no-user">No selected user</li>',
                parent = $(this).parents()[1];
            parent.remove()
            var this_parent = $('#user-list');
            if (this_parent.children().length == 0) {
                this_parent.append(empty)
                $('#add-user-btn').attr('disabled', true)
            }
        })
    }

    $('#add-user-form').submit(function (e) {
        e.preventDefault();

        var user_elem = $('#user-list'),
            user_list = user_elem.find('li:not(.no-user)'),
            form = $(this),
            data = form.serialize(),
            btn = $('#add-user-btn');
        if (user_list.length == 0) {
            btn.attr('disabled', true)
            return false;
        }

        $.ajax({
            type: 'POST',
            url: hostroot(form.attr('action')),
            dataType: 'JSON',
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus)
                btn.attr('disabled', false)
            },
            data: data,
            beforeSend: function () {
                btn.attr('disabled', true)
            },
            success: function (response) {
                if (response.success) {
                    user_elem.html('<li class="no-user">No selected user</li>')
                    $.pushNotification('success', 'User(s) added to menu.')
                }
                form.find('input[name="csrf_token"]').val(response.token)
                btn.attr('disabled', false)
            }

        });
    })

    // function verifySettingsInput(){
    //     if($.trim($('#start-time').val()) != '' && $.trim($('#closing-time').val()) != '' && $.trim($('#price').val()) != ''){
    //         return true;
    //     }
    //     return false;
    // }

    $('#settings-form').submit(function(e){
        e.preventDefault();

        var form = $(this),
        btn = form.find('button[type="submit"]');

        $.ajax({
            type: 'POST',
            url: hostroot(form.attr('action')),
            dataType: 'JSON',
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus)
                btn.attr('disabled', false)
            },
            data: form.serialize(),
            beforeSend: function () {
                btn.attr('disabled', true)
            },
            success: function (response) {
                if (response.success) {
                    $.pushNotification('success', 'Settings saved.')
                }
                form.find('input[name="csrf_token"]').val(response.token)
                btn.attr('disabled', false)
            }
        });
    })


})