//for load an error when something wrong
$(window).on('load', function () {
    setTimeout(function () {
        if (getUrl().has('error')) {
            swal.fire({
                title: 'خطا',
                type: 'error',
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'متوجه شدم',
            }).then((result) => {
                if (result.value) {
                    window.location.href = Routes.dashboard
                }
            });
        }
    }, 700);
});