$(function () {
    var table = function (data) {
        return `<tr>
                <td>`+ data.id + `</td>
                <td>`+ data.user.name + `</td>
                <td>`+ data.menu.name + `</td>
                <td>`+ data.menu.type + `</td>
                <td>R `+ data.menu.price + `</td>
                <td>`+ data.date_ordered + `</td>
                <td><button data-order="`+ data.id + `" class="btn btn-sm btn-danger cancel-order">Cancel</button></td>
            </tr>`
    },
        bill_table = function (data) {
            return `<tr>
                <td>`+ data.id + `</td>
                <td>`+ data.item + `</td>
                <td>`+ data.price + `</td>
                <td>`+ data.date_billed + `</td>
            </tr>`
        },
        hostroot = function (url) {
            var location = window.location,
                host = location.host, origin;
            if (url == undefined) return location.origin;

            if (host == 'localhost') {
                origin = location.origin + '/foodie/' + url;
            } else {
                origin = location.origin + '/' + url;
            }
            return origin;
        },
        tiURL = function (link, origin) {

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
        }

    function loadOrders() {
        var no_orders = $('#no-orders'),
            loading_orders = $('#loading-orders'),
            orders_table = $('#orders-table')
        orders_table.hide()
        no_orders.hide()
        loading_orders.show()
        $.ajax({
            url: hostroot('api/orders'),
            method: 'get',
            dataType: 'json',
            data: {
                option: $('#menu-option').val(),
                sort: $('#sort').val()
            },
            success: function (r) {
                loading_orders.hide()
                if (r.length != 0) {
                    orders_table.show()
                    var tbody = orders_table.find('tbody')
                    tbody.html('')
                    $.each(r, function (e, i) {
                        tbody.append(table(i))
                    })
                } else {
                    no_orders.show()
                }
            }
        })
    }

    function loadBills() {
        var no_bills = $('#no-bills'),
            loading_bills = $('#loading-bills'),
            bills_table = $('#bills-table')
        bills_table.hide()
        no_bills.hide()
        loading_bills.show()
        $.ajax({
            url: hostroot('api/admin/bills'),
            method: 'get',
            dataType: 'json',
            data: {
                option: $('#menu-option').val(),
                sort: $('#sort').val()
            },
            success: function (r) {
                loading_bills.hide()
                if (r.length != 0) {
                    bills_table.show()
                    var tbody = bills_table.find('tbody')
                    tbody.html('')
                    $.each(r, function (e, i) {
                        tbody.append(bill_table(i))
                    })
                } else {
                    no_bills.show()
                }
            }
        })
    }

    $('select', '.order-arrange').change(function () {
        if ($('body').find('#orders-table').length) loadOrders();

        if ($('body').find('#bills-table').length) loadBills();
    })

    if ($('body').find('#orders-table').length) loadOrders();

    if ($('body').find('#bills-table').length) loadBills();

    $('#orders-table').on('click', '.cancel-order', function () {
        var _this = $(this)
        $.ajax({
            url: hostroot('api/orders/remove'),
            method: 'post',
            dataType: 'json',
            data: {
                order: _this.attr('data-order')
            },
            success: function (r) {
                if (r.success) {
                    _this.parents('tr').remove()
                    var childrenCount = _this.parents('tbody').children().length;
                    if (childrenCount == 0) {
                        $('#loading-orders').hide()
                        $('#orders-table').hide()
                        $('#no-orders').show()
                    }
                } else {

                }
            }
        })
    })

    $('.order-menu').click(function (e) {
        e.preventDefault();

        var btn = $(this);

        $.ajax({
            type: 'POST',
            url: hostroot('user/menu/order'),
            dataType: 'JSON',
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus)
                btn.attr('disabled', false)
            },
            data: { menu_id: btn.attr('data-menu') },
            beforeSend: function () {
                btn.attr('disabled', true)
            },
            success: function (response) {
                if (response.success) {
                    $.pushNotification('success', 'Menu order sent.')
                } else if (response.msg == 't_error') {
                    btn.attr('disabled', false)
                }

            }

        });
    })

    $('#cancel-order').click(function () {
        $('.cancel-reason-container').removeClass('d-none')
    })

    $('#close-reason').click(function () {
        $('.cancel-reason-container').addClass('d-none')
    })

    $('#cancel-order-form').submit(function (e) {
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
                    tiURL('order_history');
                    $('.cancel-reason-container').addClass('d-none')
                    form.find('textarea').val('')

                }
                form.find('input[name="csrf_token"]').val(response.token)
                btn.attr('disabled', false)
            }
        });
    })

})