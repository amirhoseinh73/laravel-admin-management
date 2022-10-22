$('#login_submit').off('submit').on('submit', function ( e ) {
    e.preventDefault();
    const username = document.getElementById('login_username');
    const password = document.getElementById('login_password');
    const remember_me = document.getElementById('remember');

    let data = {
        username: username.value,
        password: password.value,
        remember_me: remember_me.checked,
    };
    SendAjax( Routes.login, data, Routes.dashboard, 206 );
});

function SendAjax(_url, _data, _url_redirect, _code) {
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
            $('#fix_loading').animate({
                'z-index': 99999,
                'opacity': 1,
            }, 500);
        },
        success: function (resp) {
            if (resp.status == "failed") {
                $('.alert_success.all').text('').hide('normal');
                $('.alert_wrong.all').text(resp.message).show('normal');
                $('html,body').animate({ scrollTop: 0 }, 300);
            } else if (resp.status == "success") {
                $('.alert_success.all').text(resp.message).show('normal');
                $('.alert_wrong.all').text('').hide('normal');
                $('html,body').animate({ scrollTop: 0 }, 300);
                
                $('#fix_loading_2').animate({
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
            $('.alert_success.all').text('').hide('normal');
            $('.alert_wrong.all').text( "سرور مشغول می باشد، لطفا چند دقیقه دیگر امتحان کنید" ).show('normal');
            $('html,body').animate({ scrollTop: 0 }, 300);
        },
        complete: function () {
            $('#fix_loading').animate({
                'z-index': -1,
                'opacity': 0,
            }, 500);
        }
    });
}