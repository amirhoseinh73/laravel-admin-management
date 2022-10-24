function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

/**
 * @param {string} url
 * @param {function} successFn
 * @param {object} data { method, headers, data }
 */
async function ajaxFetch( url, successFunction, data ) {
    document.body.insertAdjacentHTML( "beforeend", html_loading() );
    const preloader = document.getElementById( "preloader" );
    const form_data = new FormData();
    if ( data.method.toUpperCase() === "POST" ) {
        for ( const key in data.data ) {
            form_data.append( key , data.data[key] );
        }
        form_data.append( "_token", document.querySelector( 'meta[name="csrf-token"]' ).getAttribute('content') )
    }
    return fetch( url , {
        method:  data.method,
        // headers: _data.headers,
       ...( ( data.method.toUpperCase() === "POST" ) && { body: form_data } ),
    } )
    .then( ( response ) => response.json() )
    .then( ( respond ) => {
        if ( preloader ) preloader.remove();
        return successFunction( respond );
    } )
    .catch( ( error ) => {
        if ( preloader ) preloader.remove();
        console.error( 'Error:', error );
    } );
}

function sweetAlert( info ) {
    Swal.fire({
        title: info.title,
        text: info.message,
        type: info.status === "failed" ? "error" : info.status,
        showCancelButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: 'متوجه شدم',
    });
}

function sweetAlertConfirm( fn ) {
    Swal.fire({
        title: "آیا از ادامه عملیات اطمینان دارید؟",
        type: 'info',
        showCancelButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: 'بله',
        cancelButtonText: "خیر",
    }).then((resp) => {
        if (resp.value) {
            fn();
        }
    });
}

function html_loading() {
    return `<div id="preloader" style="opacity: 70%">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    <style type="text/css">
        #preloader {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            background-color: #fff;
            z-index: 9999999999;
            display: flex;
            justify-content: center;
            align-items: center;
        }
      
        .spinner-chase {
            margin: 0 auto;
            width: 40px;
            height: 40px;
            position: relative;
            -webkit-animation: spinner-chase 2.5s infinite linear both;
                    animation: spinner-chase 2.5s infinite linear both;
        }
      
        .chase-dot {
            width: 100%;
            height: 100%;
            position: absolute;
            right: 0;
            top: 0;
            -webkit-animation: chase-dot 2.0s infinite ease-in-out both;
                    animation: chase-dot 2.0s infinite ease-in-out both;
        }
        
        .chase-dot:before {
            content: '';
            display: block;
            width: 25%;
            height: 25%;
            background-color: #3b5de7;
            border-radius: 100%;
            -webkit-animation: chase-dot-before 2.0s infinite ease-in-out both;
                    animation: chase-dot-before 2.0s infinite ease-in-out both;
        }
        
        .chase-dot:nth-child(1) {
            -webkit-animation-delay: -1.1s;
                    animation-delay: -1.1s;
        }
        
        .chase-dot:nth-child(1):before {
            -webkit-animation-delay: -1.1s;
                    animation-delay: -1.1s;
        }
        
        .chase-dot:nth-child(2) {
            -webkit-animation-delay: -1.0s;
                    animation-delay: -1.0s;
        }
        
        .chase-dot:nth-child(2):before {
            -webkit-animation-delay: -1.0s;
                    animation-delay: -1.0s;
        }
        
        .chase-dot:nth-child(3) {
            -webkit-animation-delay: -0.9s;
                    animation-delay: -0.9s;
        }
        
        .chase-dot:nth-child(3):before {
            -webkit-animation-delay: -0.9s;
                    animation-delay: -0.9s;
        }
        
        .chase-dot:nth-child(4) {
            -webkit-animation-delay: -0.8s;
                    animation-delay: -0.8s;
        }
        
        .chase-dot:nth-child(4):before {
            -webkit-animation-delay: -0.8s;
                    animation-delay: -0.8s;
        }
        
        .chase-dot:nth-child(5) {
            -webkit-animation-delay: -0.7s;
                    animation-delay: -0.7s;
        }
        
        .chase-dot:nth-child(5):before {
            -webkit-animation-delay: -0.7s;
                    animation-delay: -0.7s;
        }
        
        .chase-dot:nth-child(6) {
            -webkit-animation-delay: -0.6s;
                    animation-delay: -0.6s;
        }
        
        .chase-dot:nth-child(6):before {
            -webkit-animation-delay: -0.6s;
                    animation-delay: -0.6s;
        }
        
        @-webkit-keyframes spinner-chase {
            100% {
            -webkit-transform: rotate(-360deg);
                    transform: rotate(-360deg);
            }
        }
        
        @keyframes spinner-chase {
            100% {
            -webkit-transform: rotate(-360deg);
                    transform: rotate(-360deg);
            }
        }
        
        @-webkit-keyframes chase-dot {
            80%, 100% {
            -webkit-transform: rotate(-360deg);
                    transform: rotate(-360deg);
            }
        }
        
        @keyframes chase-dot {
            80%, 100% {
            -webkit-transform: rotate(-360deg);
                    transform: rotate(-360deg);
            }
        }
        
        @-webkit-keyframes chase-dot-before {
            50% {
            -webkit-transform: scale(0.4);
                    transform: scale(0.4);
            }
            100%, 0% {
            -webkit-transform: scale(1);
                    transform: scale(1);
            }
        }
        
        @keyframes chase-dot-before {
            50% {
            -webkit-transform: scale(0.4);
                    transform: scale(0.4);
            }
            100%, 0% {
            -webkit-transform: scale(1);
                    transform: scale(1);
            }
        }
    </style>`;
}

function getUrl() {
    const queryString = window.location.search;
    return new URLSearchParams(queryString);
}