const alertHTML = ( alertText, alertClass ) => {
    if ( alertClass === "failed" ) alertClass = "danger"
    return `<section class="col alert alert-${ alertClass }">
                ${ alertText }
            </section>`
}

const appendAlertHTML = ( respond ) => {
    const parentHTML = document.getElementById( "show_alert_message" );
    if ( ! parentHTML ) return

    const existAlert = document.querySelector( ".alert" )
    if ( existAlert ) existAlert.remove()

    parentHTML.classList.remove( "d-none" );
    parentHTML.insertAdjacentHTML( "afterbegin", alertHTML( respond.message, respond.status ) )

    const captchaHTML = document.getElementById( "captchaText" )
    if ( ! captchaHTML ) return

    ajaxFetch( Routes.recaptcha, ( respond ) => {
        captchaHTML.innerHTML = respond.data
    }, {
        method: "post",
        data: {}
    } )
}

const submitHandler = ( e ) => {
    e.preventDefault()

    const code = document.getElementById( "code" );
    const mobile = document.getElementById( "mobile" );
    const captchaAnswer = document.getElementById( "captchaAnswer" );

    const data = {
        method: "post",
        data: {
            code: code.value,
            mobile: mobile.value,
            captchaAnswer: captchaAnswer.value
        }
    }

    ajaxFetch( Routes.offlinePageFormSubmit, appendAlertHTML, data )
}

const submitForm = () => {
    const form = document.getElementById( "activation_code_form_page" )
    if ( ! form ) return

    form.addEventListener( "submit", submitHandler )
}

docReady( () => {
   
    submitForm();

} )