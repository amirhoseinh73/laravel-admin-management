$('#ibv_vp_charge_wallet_amount').off('change').on('change', function () {
    $('#ibv_vp_currency_equivalent').removeClass('text-danger').addClass('text-warning').text('');
    var amount = this.value;
    ibv_vp_get_coin_value_by_rial(amount);
});
$('#ibv_vp_pay_rules').off('change').on('change', function () {
    if (this.checked) {
        $('#ibv_vp_currency_equivalent_loading').animate({
            'opacity': 0
        }, 500);
        setTimeout(function () {
            var amount = document.getElementById('ibv_vp_charge_wallet_amount').value;
            $('#ibv_vp_currency_equivalent').removeClass('text-danger').addClass('text-warning').text('');
            ibv_vp_get_coin_value_by_rial(amount);
        }, 500);
    }
});
var ibv_vp_$_rial = '';

function ibv_vp_get_coin_value_by_rial(amount) {
    var $_dollar = '';
    $.ajax({
        url: ibv_vp__url_get_dollar,
        cache: false,
        method: 'get',
        dataType: 'json',
        beforeSend: function () {
            $('#ibv_vp_currency_equivalent_loading').animate({
                'opacity': 1
            }, 100);
        },
        success: function (resp) {
            amount = parseInt(amount);

            ibv_vp_$_rial = parseInt(resp.dollar) * amount;

            $('#ibv_vp_currency_equivalent').text(amount + ibv_vp_short_texts(100) +
                (amount * parseInt(resp.coin)) + ibv_vp_short_texts(101) + ibv_vp_$_rial + ibv_vp_short_texts(102));
        },
        error: function () {
            $('#ibv_vp_currency_equivalent').text(ibv_vp_ErrorsMessages(101));
        },
        complete: function () {
            $('#ibv_vp_currency_equivalent_loading').animate({
                'opacity': 0
            }, 0);
        }
    });
}

$('#ibv_vp_pay_submit').off('click').on('click', function () {
    var amount = document.getElementById('ibv_vp_charge_wallet_amount').value;
    var rules = document.getElementById('ibv_vp_pay_rules');
    $('#ibv_vp_currency_equivalent').removeClass('text-warning').addClass('text-danger').text('');
    if (rules.checked) {
        $('#ibv_vp_currency_equivalent_loading').animate({
            'opacity': 0
        }, 0);
        if (amount > 0) {
            $(this).css('pointer-events', 'none');
            ibv_vp_$_rial = parseInt(ibv_vp_$_rial);
            $.ajax({
                url: ibv_vp__url_request_pay,
                cache: false,
                method: 'post',
                dataType: 'json',
                data: {
                    amount: ibv_vp_$_rial,
                    type_price: 1
                },
                beforeSend: function () {
                    $('#ibv_vp_fix_loading').animate({
                        'z-index': 99999,
                        'opacity': 1,
                    }, 500);
                },
                success: function (resp) {
                    $('#ibv_vp_loading_pay').animate({
                        'opacity': 1
                    }, 0);
                    if (resp.type == 1) {
                        $('.ibv_vp_alert_success').text('').hide('normal');
                        $('.ibv_vp_alert_info').text('').hide('normal');
                        $('.ibv_vp_alert_wrong').text(resp.message).show('normal');
                        if (resp.code == 111) {
                            window.location.href = ibv_vp__url_index;
                        }
                    } else if (resp.type == 3) {
                        $('.ibv_vp_alert_success').text('').hide('normal');
                        $('.ibv_vp_alert_info').text(resp.message).show('normal');
                        $('.ibv_vp_alert_wrong').text('').hide('normal');
                        if (resp.code === 301) {
                            $('#ibv_vp_fix_loading_2').animate({
                                'z-index': 99999,
                                'opacity': 1,
                            }, 100);
                            setTimeout(function () {
                                window.location.href = ibv_vp__url_redirect_to_pay;
                            }, 1500);
                        }
                    }
                },
                error: function () {
                    $('.ibv_vp_alert_wrong').text('').hide('normal');
                    $('.ibv_vp_alert_info').text('').hide('normal');
                    $('#ibv_vp_currency_equivalent').text(ibv_vp_ErrorsMessages(104));
                },
                complete: function () {
                    $('#ibv_vp_fix_loading').animate({
                        'z-index': -1,
                        'opacity': 0,
                    }, 500);
                }
            });
        } else {
            $(this).css('pointer-events', 'all');
            $('#ibv_vp_currency_equivalent_loading').animate({
                'opacity': 1
            }, 0);
            setTimeout(function () {
                $('#ibv_vp_currency_equivalent').text(ibv_vp_ErrorsMessages(102));
            }, 500);
        }
    } else {
        $(this).css('pointer-events', 'all');
        $('#ibv_vp_currency_equivalent_loading').animate({
            'opacity': 1
        }, 0);
        setTimeout(function () {
            $('#ibv_vp_currency_equivalent').text(ibv_vp_ErrorsMessages(103));
        }, 500);
    }
});


function ibv_vp_getUrl() {
    const queryString = window.location.search;
    return new URLSearchParams(queryString);
}

//for load an error when something wrong
$(window).on('load', function () {
    setTimeout(function () {
        if (ibv_vp_getUrl().has('error')) {
            swal.fire({
                title: 'خطا',
                type: 'error',
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'متوجه شدم',
            }).then((result) => {
                if (result.value) {
                    window.location.href = ibv_vp__url_dashboard
                }
            });
        }
    }, 700);
});