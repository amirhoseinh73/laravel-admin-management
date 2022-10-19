//4 time wait for email,username,password and repeat password
var ibv_vp__time_wait_1 = 0;
var ibv_vp__time_wait_2 = 0;
var ibv_vp__time_wait_3 = 0;
var ibv_vp__time_wait_4 = 0;

//hide alert or change alert when letter was change
$('#ibv_vp_register_email').off('keydown').on('keydown', function () {
    $('.ibv_vp_alert_email').text('').hide();
    ibv_vp__time_wait_1 = parseInt(Date.now() / 1000) + 2;
});
$('#ibv_vp_register_username').off('keydown').on('keydown', function () {
    $('.ibv_vp_alert_username').text('').hide();
    ibv_vp__time_wait_2 = parseInt(Date.now() / 1000) + 2;
});
$('#ibv_vp_register_password').off('keydown').on('keydown', function () {
    $('.ibv_vp_alert_password').text('').hide();
    ibv_vp__time_wait_3 = parseInt(Date.now() / 1000) + 2;
});
$('#ibv_vp_register_password_conf').off('keydown').on('keydown', function () {
    $('.ibv_vp_alert_password_conf').text('').hide();
    ibv_vp__time_wait_4 = parseInt(Date.now() / 1000) + 2;
});

//check email,username,password and repeat password when keyup and when mouse click out
// start check
$('#ibv_vp_register_email').off('keyup').on('keyup', function () {
    ibv_vp_check_email_keyUp();
}).off('focusout').on('focusout', function () {
    ibv_vp_check_email_keyUp();
});
$('#ibv_vp_register_username').off('keyup').on('keyup', function () {
    ibv_vp_check_username_keyUp();
}).off('focusout').on('focusout', function () {
    ibv_vp_check_username_keyUp();
});
$('#ibv_vp_register_password').off('keyup').on('keyup', function () {
    ibv_vp_check_password_keyUp();
}).off('focusout').on('focusout', function () {
    ibv_vp_check_password_keyUp();
});
$('#ibv_vp_register_password_conf').off('keyup').on('keyup', function () {
    ibv_vp_check_password_conf_keyUp();
}).off('focusout').on('focusout', function () {
    ibv_vp_check_password_conf_keyUp();
});

function ibv_vp_check_email_keyUp() {
    setTimeout(function () {
        if (ibv_vp__time_wait_1 > 0 && parseInt(Date.now() / 1000) > ibv_vp__time_wait_1) {
            var email = document.getElementById('ibv_vp_register_email').value;
            if (email.length > 0) {
                let data = {
                    email: email,
                };
                ibv_vp__time_wait_1 = parseInt(Date.now() / 1000) + 2;
                ibv_vp_SendAjaxKeyUp(ibv_vp__url_ajax_reg_em, data, '.ibv_vp_alert_email');
            }
        }
    }, 3000);
}
function ibv_vp_check_username_keyUp() {
    setTimeout(function () {
        if (ibv_vp__time_wait_2 > 0 && parseInt(Date.now() / 1000) > ibv_vp__time_wait_2) {
            var username = document.getElementById('ibv_vp_register_username').value;
            if (username.length > 0) {
                let data = {
                    username: username,
                };
                ibv_vp__time_wait_2 = parseInt(Date.now() / 1000) + 2;
                ibv_vp_SendAjaxKeyUp(ibv_vp__url_ajax_reg_us, data, '.ibv_vp_alert_username');
            }
        }
    }, 3000);
}
function ibv_vp_check_password_keyUp() {
    setTimeout(function () {
        if (ibv_vp__time_wait_3 > 0 && parseInt(Date.now() / 1000) > ibv_vp__time_wait_3) {
            var password = document.getElementById('ibv_vp_register_password').value;
            if (password.length > 0) {
                let data = {
                    password: password,
                };
                ibv_vp__time_wait_3 = parseInt(Date.now() / 1000) + 2;
                ibv_vp_SendAjaxKeyUp(ibv_vp__url_ajax_reg_pas, data, '.ibv_vp_alert_password');
            }
        }
    }, 3000);
}
function ibv_vp_check_password_conf_keyUp() {
    setTimeout(function () {
        if (ibv_vp__time_wait_4 > 0 && parseInt(Date.now() / 1000) > ibv_vp__time_wait_4) {
            var password = document.getElementById('ibv_vp_register_password').value;
            var password_conf = document.getElementById('ibv_vp_register_password_conf').value;
            if (password_conf.length > 0) {
                let data = {
                    password: password,
                    password_conf: password_conf,
                };
                ibv_vp__time_wait_4 = parseInt(Date.now() / 1000) + 2;
                ibv_vp_SendAjaxKeyUp(ibv_vp__url_ajax_reg_pas_conf, data, '.ibv_vp_alert_password_conf');
            }
        }
    }, 3000);
}
// end check
//register submit function and send data
$('#ibv_vp_register_submit').off('click').on('click', function () {
    var firstName = document.getElementById('ibv_vp_register_first_name').value;
    var lastName = document.getElementById('ibv_vp_register_last_name').value;
    var username = document.getElementById('ibv_vp_register_username').value;
    var email = document.getElementById('ibv_vp_register_email').value;
    var password = document.getElementById('ibv_vp_register_password').value;
    var password_conf = document.getElementById('ibv_vp_register_password_conf').value;
    var gender = document.getElementById('ibv_vp_register_gender').value;
    let data = {
        firstName: firstName,
        lastName: lastName,
        username: username,
        email: email,
        password: password,
        password_conf: password_conf,
        gender: gender,
    };
    console.log(ibv_vp__url_dashboard);
    ibv_vp_SendAjax(ibv_vp__url_ajax_reg, data, ibv_vp__url_dashboard, 201);
});
$('#ibv_vp_login_after_verify').off('click').on('click', function () {
    ibv_vp_SendAjax(ibv_vp__url_login_to_after_verify, '', ibv_vp__url_dashboard, 206);
});

$('#ibv_vp_verify_email_submit').off('click').on('click', function () {
    var code = document.getElementById('ibv_vp_verify_email_code').value;
    let data = {
        code: code
    };
    ibv_vp_SendAjax(ibv_vp__url_verify_email_code, data, ibv_vp__url_redirect_verified_email, 207);
});
$('#ibv_vp_login_submit').off('submit').on('submit', function ( e ) {
    e.preventDefault();
    var username = document.getElementById('ibv_vp_login_username');
    var password = document.getElementById('ibv_vp_login_password');
    var remember_me = document.getElementById('ibv_vp_remember');

    ibv_vp_isRememberMe(remember_me, username, password);

    let data = {
        username: username.value,
        password: password.value,
    };
    ibv_vp_SendAjax(ibv_vp__url_ajax_log, data, ibv_vp__url_dashboard, 206);
});

$(window).on('load',function(){
    var remember_me = document.getElementById('ibv_vp_remember');
    var username = document.getElementById('ibv_vp_login_username');
    var password = document.getElementById('ibv_vp_login_password');
    if (localStorage.remember_me && localStorage.remember_me != '' &&
    localStorage.username != '' && typeof remember_me != 'undefined' && remember_me != null) {
        remember_me.setAttribute("checked", "checked");
        username.value = JSON.parse(localStorage.username);
        if(localStorage.password != ''){
            password.value = JSON.parse(localStorage.password);
        }
    } /* else {
        remember_me.removeAttribute("checked");
        username.value = "";
        password.value = "";
    }*/
});

function ibv_vp_isRememberMe(_checkBox, _input_1, _input_2 = null) {
    if (_checkBox.checked) {
        localStorage.remember_me = _checkBox.checked;
        if (_input_1.value != "" && _input_1 != null) {
            localStorage.username = JSON.stringify(_input_1.value);
        }
        if (_input_2.value != "" && _input_2 != null) {
            localStorage.password = JSON.stringify(_input_2.value);
        }
    } else {
        localStorage.username = '';
        localStorage.password = '';
        localStorage.remember_me = '';
    }
}

$('#ibv_vp_verify_email_sent_again').off('click').on('click', function () {
    let data = {
        check: 'ok'
    };
    ibv_vp_SendAjax(ibv_vp__url_redirect_verify_again, data);
});

function ibv_vp_SendAjaxKeyUp(_url_ajax, _data, _alert) {

    $('.ibv_vp_alert_success' + _alert).text('').hide();
    $('.ibv_vp_alert_wrong' + _alert).text('').hide();

    $.ajax({
        url: _url_ajax,
        method: 'post',
        catch: false,
        data: _data,
        dataType: 'json',
        success: function (resp) {
            if (resp.status == "failed") {
                $('.ibv_vp_alert_wrong' + _alert).text(resp.message).fadeIn('normal');
            } else if (resp.status == "success") {
                $('.ibv_vp_alert_success' + _alert).text(resp.message).fadeIn('normal');
            }
        },
        error: function () {
            $('.ibv_vp_alert_wrong' + _alert).text(ibv_vp_ErrorsMessages(100)).fadeIn('normal');
        }
    })
}
function ibv_vp_SendAjax(_url, _data, _url_redirect, _code) {
    let __data;
    if (typeof _data !== "undefined" && typeof _data !== undefined) {
        __data = _data;
    } else {
        __data = 'nok';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: _url,
        method: 'post',
        catch: false,
        data: __data,
        dataType: 'json',
        beforeSend: function () {
            $('#ibv_vp_fix_loading').animate({
                'z-index': 99999,
                'opacity': 1,
            }, 500);
        },
        success: function (resp) {
            if (resp.status == "failed") {
                $('.ibv_vp_alert_success.ibv_vp_all').text('').hide('normal');
                $('.ibv_vp_alert_wrong.ibv_vp_all').text(resp.message).show('normal');
                $('html,body').animate({ scrollTop: 0 }, 300);
            } else if (resp.status == "success") {
                $('.ibv_vp_alert_success.ibv_vp_all').text(resp.message).show('normal');
                $('.ibv_vp_alert_wrong.ibv_vp_all').text('').hide('normal');
                $('html,body').animate({ scrollTop: 0 }, 300);
                
                $('#ibv_vp_fix_loading_2').animate({
                    'z-index': 99999,
                    'opacity': 1,
                }, 500);
                setTimeout(function () {
                    window.location.href = _url_redirect;
                }, 500);
            }
        },
        error: function ( err ) {
            console.log(err);
            $('.ibv_vp_alert_success.ibv_vp_all').text('').hide('normal');
            $('.ibv_vp_alert_wrong.ibv_vp_all').text( "سرور مشغول می باشد، لطفا چند دقیقه دیگر امتحان کنید" ).show('normal');
            $('html,body').animate({ scrollTop: 0 }, 300);
        },
        complete: function () {
            $('#ibv_vp_fix_loading').animate({
                'z-index': -1,
                'opacity': 0,
            }, 500);
        }
    });
}