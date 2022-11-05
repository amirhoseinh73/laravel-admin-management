const register = () => {
    const firstname = document.getElementById( "firstname" ).value
    const lastname  = document.getElementById( "lastname" ).value
    const username  = document.getElementById( "username" ).value
    const mobile    = document.getElementById( "mobile" ).value
    const password  = document.getElementById( "password" ).value
    const gender    = document.getElementById( "gender" ).value
    const expired_at = document.getElementById( "expired_at" ).value
    const grade     = getSelectValues( document.getElementById( "grade" ) )

    const is_send_sms = document.getElementById( "is_send_sms" ).checked

    const data = {
        data    : {
            firstname: firstname,
            lastname: lastname,
            username: username,
            mobile: mobile,
            password: password,
            gender: gender,
            grade: grade,
            expired_at: expired_at,
            is_send_sms: is_send_sms,
        },
        method  : "POST",
    };

    ajaxFetch( Routes.manageUserRegister, sweetAlert, data );
}

const registerSubmit = () => {
    const submit = document.getElementById( "form_register_user" )
    if ( ! submit ) return

    submit.addEventListener( "submit", function( event ) {
        event.preventDefault()
        register()
    } )
}

docReady( () => {
    callCalendar( "expired_at" )
    registerSubmit()
} )