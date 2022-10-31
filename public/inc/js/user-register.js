const register = () => {
    const firstname = document.getElementById( "firstname" ).value
    const lastname  = document.getElementById( "lastname" ).value
    const username  = document.getElementById( "username" ).value
    const mobile    = document.getElementById( "mobile" ).value
    const password  = document.getElementById( "password" ).value
    const gender    = document.getElementById( "gender" ).value
    const grade     = getSelectValues( document.getElementById( "grade" ) )

    const data = {
        data    : {
            firstname: firstname,
            lastname: lastname,
            username: username,
            mobile: mobile,
            password: password,
            gender: gender,
            grade: grade,
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
    registerSubmit()
} )